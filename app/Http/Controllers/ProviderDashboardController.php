<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;
use App\Models\Reservation;
use App\Models\Availability;
use App\Models\Category;
use Carbon\Carbon;

class ProviderDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:ServiceProvider']);
    }

    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les services du prestataire
        $services = Service::where('provider_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        $servicesCount = Service::where('provider_id', $user->id)->count();
        
        // Récupérer les catégories avec leurs services
        $categories = Category::with(['services' => function($query) use ($user) {
            $query->where('provider_id', $user->id)
                  ->orderBy('name');
        }])->get();
        
        // Récupérer les réservations du prestataire
        $reservations = Reservation::whereHas('service', function ($query) use ($user) {
                $query->where('provider_id', $user->id);
            })
            ->with('service', 'user')
            ->latest()
            ->take(5)
            ->get();
        
        $reservationsCount = Reservation::whereHas('service', function ($query) use ($user) {
            $query->where('provider_id', $user->id);
        })->count();
        
        $pendingReservationsCount = Reservation::whereHas('service', function ($query) use ($user) {
            $query->where('provider_id', $user->id);
        })->where('status', 'pending')->count();
        
        $revenue = Reservation::whereHas('service', function ($query) use ($user) {
                $query->where('provider_id', $user->id);
            })
            ->where('status', 'confirmed')
            ->where('payment_status', 'completed')
            ->sum('amount');
        
        return view('provider.dashboard', compact(
            'services', 
            'servicesCount', 
            'reservations', 
            'reservationsCount', 
            'pendingReservationsCount', 
            'revenue',
            'categories'
        ));
    }
}