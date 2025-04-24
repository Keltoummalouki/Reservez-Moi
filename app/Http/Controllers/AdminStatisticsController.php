<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminStatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    public function index(Request $request)
    {
        $period = $request->input('period', 30);
        $startDate = Carbon::now()->subDays($period);
        
        $totalReservations = Reservation::where('created_at', '>=', $startDate)->count();
        $totalRevenue = Reservation::where('payment_status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->sum('amount');
        
        $newClients = User::whereHas('roles', function ($query) {
            $query->where('name', 'Client');
        })->where('created_at', '>=', $startDate)->count();
        
        $visits = 1000; 
        $conversionRate = $visits > 0 ? round(($totalReservations / $visits) * 100, 2) : 0;
        
        $previousStartDate = Carbon::now()->subDays($period * 2)->startOfDay();
        $previousEndDate = Carbon::now()->subDays($period)->endOfDay();
        
        $previousReservations = Reservation::whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();
        $reservationsGrowth = $previousReservations > 0 
            ? round((($totalReservations - $previousReservations) / $previousReservations) * 100, 2) 
            : 100;
        
        $previousRevenue = Reservation::where('payment_status', 'completed')
            ->whereBetween('created_at', [$previousStartDate, $previousEndDate])
            ->sum('amount');
        $revenueGrowth = $previousRevenue > 0 
            ? round((($totalRevenue - $previousRevenue) / $previousRevenue) * 100, 2) 
            : 100;
        
        $previousNewClients = User::whereHas('roles', function ($query) {
            $query->where('name', 'Client');
        })->whereBetween('created_at', [$previousStartDate, $previousEndDate])->count();
        $clientsGrowth = $previousNewClients > 0 
            ? round((($newClients - $previousNewClients) / $previousNewClients) * 100, 2) 
            : 100;
        
        $previousConversionRate = 5.2; // Exemple
        $conversionRateChange = round($conversionRate - $previousConversionRate, 2);
        
        // Catégories populaires
        $popularCategories = Category::withCount(['services' => function($query) use ($startDate) {
            $query->withCount(['reservations' => function($reservationQuery) use ($startDate) {
                $reservationQuery->where('created_at', '>=', $startDate);
            }]);
        }])
        ->get()
        ->map(function($category) use ($totalReservations) {
            // Calculate total reservations for this category by summing up the
            // reservation counts from all services
            $reservationsCount = $category->services->sum('reservations_count');
            $percentage = $totalReservations > 0 ? round(($reservationsCount / $totalReservations) * 100, 2) : 0;
            return [
                'name' => $category->name,
                'count' => $reservationsCount,
                'percentage' => $percentage
            ];
        })
        ->sortByDesc('percentage')
        ->take(5)
        ->values()
        ->all();
        
        // Services les plus réservés
        $topServices = Service::withCount(['reservations' => function($query) use ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }])
        ->with('provider')
        ->orderByDesc('reservations_count')
        ->take(5)
        ->get()
        ->map(function($service) {
            $revenue = $service->reservations()
                ->where('payment_status', 'completed')
                ->sum('amount');
            
            return [
                'name' => $service->name,
                'provider' => $service->provider->name,
                'reservations' => $service->reservations_count,
                'revenue' => $revenue
            ];
        });
        
        return view('admin.statistics', compact(
            'totalReservations',
            'totalRevenue',
            'newClients',
            'conversionRate',
            'reservationsGrowth',
            'revenueGrowth',
            'clientsGrowth',
            'conversionRateChange',
            'popularCategories',
            'topServices'
        ));
    }
}
