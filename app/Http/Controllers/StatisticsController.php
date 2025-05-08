<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $provider = Auth::user();
        $totalReservations = $provider->reservations()->count();
        $totalRevenue = $provider->reservations()->where('status', 'completed')->sum('amount');
        $averageRating = $provider->reviews()->avg('rating') ?? 0;
        $activeServices = $provider->services()->where('is_active', true)->count();
        $reservationsByMonth = $provider->reservations()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
        $revenueByMonth = $provider->reservations()
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
        $topServices = $provider->services()
            ->withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();
        $recentActivity = $this->getRecentActivity($provider);
        return view('provider.statistics', compact(
            'totalReservations',
            'totalRevenue',
            'averageRating',
            'activeServices',
            'reservationsByMonth',
            'revenueByMonth',
            'topServices',
            'recentActivity'
        ));
    }

    private function getRecentActivity($provider)
    {
        $activities = [];
        $recentReservations = $provider->reservations()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
        foreach ($recentReservations as $reservation) {
            $activities[] = [
                'icon' => 'calendar-check',
                'color' => 'blue',
                'title' => 'Nouvelle réservation',
                'description' => 'Réservation de ' . $reservation->user->name,
                'time' => $reservation->created_at->diffForHumans()
            ];
        }
        $recentReviews = $provider->reviews()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
        foreach ($recentReviews as $review) {
            $activities[] = [
                'icon' => 'star',
                'color' => 'yellow',
                'title' => 'Nouvel avis',
                'description' => 'Note de ' . $review->rating . '/5 par ' . $review->user->name,
                'time' => $review->created_at->diffForHumans()
            ];
        }
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        return array_slice($activities, 0, 5);
    }

    public function ajax(Request $request)
    {
        $provider = Auth::user();
        $period = (int) $request->get('period', 30);
        $startDate = now()->subDays($period);
        $reservations = $provider->reservations()->where('created_at', '>=', $startDate);
        $totalReservations = $reservations->count();
        $totalRevenue = $reservations->where('status', 'completed')->sum('amount');
        $newClients = $reservations->distinct('user_id')->count('user_id');
        $conversionRate = 0;
        $previousStart = now()->subDays($period * 2);
        $previousEnd = now()->subDays($period);
        $prevReservations = $provider->reservations()->whereBetween('created_at', [$previousStart, $previousEnd]);
        $prevTotalReservations = $prevReservations->count();
        $prevTotalRevenue = $prevReservations->where('status', 'completed')->sum('amount');
        $reservationsGrowth = $prevTotalReservations > 0 ? round((($totalReservations - $prevTotalReservations) / $prevTotalReservations) * 100) : 0;
        $revenueGrowth = $prevTotalRevenue > 0 ? round((($totalRevenue - $prevTotalRevenue) / $prevTotalRevenue) * 100) : 0;
        $clientsGrowth = 0;
        $conversionRateChange = 0;
        $topServices = $provider->services()
            ->withCount(['reservations' => function($q) use ($startDate) {
                $q->where('created_at', '>=', $startDate);
            }])
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get()
            ->map(function($service) {
                $revenue = $service->reservations()->where('status', 'completed')->sum('amount');
                return [
                    'name' => $service->name,
                    'reservations' => $service->reservations_count,
                    'revenue' => $revenue,
                ];
            });
        $categories = $provider->services()->with('category')->get()->groupBy('category.name');
        $popularCategories = collect();
        $totalCatReservations = $reservations->count();
        foreach ($categories as $catName => $services) {
            $count = $services->sum(function($service) use ($startDate) {
                return $service->reservations()->where('created_at', '>=', $startDate)->count();
            });
            $popularCategories->push([
                'name' => $catName,
                'count' => $count,
                'percentage' => $totalCatReservations > 0 ? round(($count / $totalCatReservations) * 100) : 0
            ]);
        }
        return response()->json([
            'totalReservations' => $totalReservations,
            'totalRevenue' => $totalRevenue,
            'newClients' => $newClients,
            'conversionRate' => $conversionRate,
            'reservationsGrowth' => $reservationsGrowth,
            'revenueGrowth' => $revenueGrowth,
            'clientsGrowth' => $clientsGrowth,
            'conversionRateChange' => $conversionRateChange,
            'topServices' => $topServices,
            'popularCategories' => $popularCategories,
        ]);
    }
}