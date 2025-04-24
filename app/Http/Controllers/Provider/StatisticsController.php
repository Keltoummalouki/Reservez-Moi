<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Review;

class StatisticsController extends Controller
{
    public function index()
    {
        $provider = Auth::user()->provider;
        
        // Statistiques principales
        $totalReservations = $provider->reservations()->count();
        $totalRevenue = $provider->reservations()->where('status', 'completed')->sum('price');
        $averageRating = $provider->reviews()->avg('rating') ?? 0;
        $activeServices = $provider->services()->where('is_active', true)->count();

        // Réservations par mois
        $reservationsByMonth = $provider->reservations()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Revenu par mois
        $revenueByMonth = $provider->reservations()
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Activité récente
        $recentActivity = $this->getRecentActivity($provider);

        return view('provider.statistics', compact(
            'totalReservations',
            'totalRevenue',
            'averageRating',
            'activeServices',
            'reservationsByMonth',
            'revenueByMonth',
            'recentActivity'
        ));
    }

    private function getRecentActivity($provider)
    {
        $activities = [];

        // Dernières réservations
        $recentReservations = $provider->reservations()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        foreach ($recentReservations as $reservation) {
            $activities[] = [
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>',
                'icon_color' => 'bg-blue-100 text-blue-600',
                'title' => 'Nouvelle réservation',
                'description' => 'Réservation de ' . $reservation->user->name,
                'time' => $reservation->created_at->diffForHumans()
            ];
        }

        // Derniers avis
        $recentReviews = $provider->reviews()
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        foreach ($recentReviews as $review) {
            $activities[] = [
                'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>',
                'icon_color' => 'bg-yellow-100 text-yellow-600',
                'title' => 'Nouvel avis',
                'description' => 'Note de ' . $review->rating . '/5 par ' . $review->user->name,
                'time' => $review->created_at->diffForHumans()
            ];
        }

        // Trier les activités par date
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }
} 