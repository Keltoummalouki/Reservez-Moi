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
            ->withCount(['reservations', 'availabilities'])
            ->latest()
            ->take(5)
            ->get();
        
        $servicesCount = Service::where('provider_id', $user->id)->count();
        
        // Récupérer les catégories avec leurs services
        $categories = Category::with(['services' => function($query) use ($user) {
            $query->where('provider_id', $user->id)
                  ->withCount('reservations')
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
        
        // Récupérer les disponibilités à venir
        $upcomingAvailabilities = $this->getUpcomingAvailabilities($user->id);
        
        return view('provider.dashboard', compact(
            'services', 
            'servicesCount', 
            'reservations', 
            'reservationsCount', 
            'pendingReservationsCount', 
            'revenue',
            'upcomingAvailabilities',
            'categories'
        ));
    }
    
    /**
     * Récupère les disponibilités à venir pour affichage dans le tableau de bord
     *
     * @param int $providerId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getUpcomingAvailabilities($providerId)
    {
        $now = Carbon::now();
        $startOfToday = $now->copy()->startOfDay();
        $endOfNextWeek = $now->copy()->addWeeks(2)->endOfDay();
        
        // Récupérer les disponibilités spécifiques à venir
        $specificAvailabilities = Availability::whereHas('service', function($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
            ->whereNotNull('specific_date')
            ->where('specific_date', '>=', $startOfToday->toDateString())
            ->where('specific_date', '<=', $endOfNextWeek->toDateString())
            ->where('is_available', true)
            ->with('service')
            ->orderBy('specific_date')
            ->orderBy('start_time')
            ->take(5)
            ->get();
            
        // Récupérer les disponibilités hebdomadaires pour les 14 prochains jours
        $weeklyAvailabilityIds = [];
        $weeklyAvailabilities = collect();
        
        $weeklySchedule = Availability::whereHas('service', function($query) use ($providerId) {
                $query->where('provider_id', $providerId);
            })
            ->whereNull('specific_date')
            ->with('service')
            ->get();
        
        // Pour chaque jour des 2 prochaines semaines
        for ($day = 0; $day < 14; $day++) {
            $currentDate = $now->copy()->addDays($day);
            $dayOfWeek = $currentDate->dayOfWeek; // 0 = dimanche, 6 = samedi
            
            // Trouver les disponibilités pour ce jour de la semaine
            $dayAvailabilities = $weeklySchedule->where('day_of_week', $dayOfWeek);
            
            foreach ($dayAvailabilities as $availability) {
                // Créer une copie virtuelle de cette disponibilité pour ce jour précis
                $availabilityCopy = clone $availability;
                $availabilityCopy->specific_date = $currentDate->toDateString();
                
                // Limiter à 5 disponibilités hebdomadaires au total
                if (count($weeklyAvailabilityIds) < 5) {
                    $weeklyAvailabilityIds[] = $availability->id;
                    $weeklyAvailabilities->push($availabilityCopy);
                }
            }
        }
        
        // Fusionner et trier les deux types de disponibilités
        $combinedAvailabilities = $specificAvailabilities->concat($weeklyAvailabilities);
        $sortedAvailabilities = $combinedAvailabilities->sortBy([
            ['specific_date', 'asc'],
            ['start_time', 'asc']
        ])->take(5);
        
        // Calculer le nombre de réservations pour chaque disponibilité
        foreach ($sortedAvailabilities as $availability) {
            if (!$availability->specific_date) {
                continue;
            }
            $datePart = date('Y-m-d', strtotime($availability->specific_date));
            $startTime = date('H:i:s', strtotime($availability->start_time));
            $endTime = date('H:i:s', strtotime($availability->end_time));
            $reservationDate = Carbon::parse($datePart . ' ' . $startTime);
            $endTimeObj = Carbon::parse($datePart . ' ' . $endTime);

            $reservationsCount = Reservation::where('service_id', $availability->service_id)
                ->whereDate('reservation_date', $availability->specific_date)
                ->whereRaw('TIME(reservation_date) BETWEEN ? AND ?', [
                    $startTime,
                    $endTime
                ])
                ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
                ->count();
                
            $availability->reservations_count = $reservationsCount;
        }
        
        return $sortedAvailabilities;
    }
}