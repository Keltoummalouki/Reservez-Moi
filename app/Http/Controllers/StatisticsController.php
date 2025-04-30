<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index()
    {
        $provider = Auth::user();

        // Statistiques principales
        $totalReservations = $provider->reservations()->count();
        $totalRevenue = $provider->reservations()->where('status', 'completed')->sum('amount');
        $averageRating = $provider->reviews()->avg('rating') ?? 0;
        $activeServices = $provider->services()->where('is_active', true)->count();

        // Réservations par mois (array: ['2024-01' => 5, ...])
        $reservationsByMonth = $provider->reservations()
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Revenu par mois (array: ['2024-01' => 120, ...])
        $revenueByMonth = $provider->reservations()
            ->where('status', 'completed')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Top services (5 plus réservés)
        $topServices = $provider->services()
            ->withCount('reservations')
            ->orderByDesc('reservations_count')
            ->take(5)
            ->get();

        // Activité récente
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

        // Dernières réservations
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

        // Derniers avis
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

        // Trier les activités par date (plus récentes d'abord)
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 5);
    }
}