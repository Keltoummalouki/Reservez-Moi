<?php
// app/Http/Controllers/ReservationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationCreated;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    protected $reservationService;
    
    public function __construct(ReservationService $reservationService)
    {
        $this->middleware(['auth', 'role:Client']);
        $this->reservationService = $reservationService;
    }

    /**
     * Affiche le formulaire de réservation avec les créneaux disponibles
     *
     * @param int $serviceId
     * @return \Illuminate\View\View
     */
    public function showForm($serviceId)
    {
        $service = Service::where('is_available', true)->findOrFail($serviceId);
        
        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(30);
        $availableDates = [];
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateString = $date->format('Y-m-d');
            $slots = [];
            
            if (count($slots) > 0) {
                $availableDates[] = [
                    'date' => $dateString,
                    'formatted' => $date->format('d/m/Y'),
                    'day_name' => $date->translatedFormat('l'),
                    'slots_count' => count($slots)
                ];
            }
        }
        
        return view('client.reserve_form', compact('service', 'availableDates'));
    }

    /**
     * Récupère les créneaux disponibles pour une date spécifique (AJAX)
     *
     * @param Request $request
     * @param int $serviceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTimeSlots(Request $request, $serviceId)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);
        
        $service = Service::findOrFail($serviceId);
        
        $slots = [];
        
        $formattedSlots = [];
        foreach ($slots as $slot) {
            $startTime = Carbon::parse($slot['start_time'])->format('H:i');
            $endTime = Carbon::parse($slot['end_time'])->format('H:i');
            
            $formattedSlots[] = [
                'start_time' => $startTime,
                'end_time' => $endTime,
                'formatted' => $startTime . ' - ' . $endTime,
                'available_spots' => $slot['available_spots'],
                'value' => $validated['date'] . ' ' . $startTime,
            ];
        }
        
        return response()->json([
            'slots' => $formattedSlots,
            'has_slots' => count($formattedSlots) > 0,
        ]);
    }

    /**
     * Traite la demande de réservation
     *
     * @param Request $request
     * @param int $serviceId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reserve(Request $request, $serviceId)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);


        try {
            $reservation = $this->reservationService->makeReservation($serviceId, $request->all());
            return redirect()->route('client.reservations.paypal', compact('reservation'))
                ->with('success', 'Réservation effectuée avec succès ! Veuillez procéder au paiement via PayPal.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Annuler une réservation
     *
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$reservation->canBeCancelled()) {
            return redirect()->route('client.reservations')
                ->with('error', 'Cette réservation ne peut pas être annulée.');
        }

        $reservation->markAsCancelled('Annulée par le client');

        return redirect()->route('client.reservations')
            ->with('success', 'Votre réservation a été annulée avec succès.');
    }

    /**
     * Rediriger vers PayPal pour le paiement
     *
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paypal(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if (!$reservation->isPendingPayment()) {
            return redirect()->route('client.reservations')
                ->with('error', 'Cette réservation ne nécessite pas de paiement.');
        }

        return app(PayPalController::class)->createPayment(new Request([
            'reservation_id' => $reservation->id,
            'amount' => $reservation->amount
        ]));
    }

    /**
     * Callback de succès PayPal
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paypalSuccess(Request $request)
    {
        return app(PayPalController::class)->success($request);
    }

    /**
     * Callback d'annulation PayPal
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paypalCancel()
    {
        return app(PayPalController::class)->cancel();
    }

    /**
     * Afficher la liste des réservations de l'utilisateur
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with(['service.provider'])
            ->latest()
            ->paginate(10);

        return view('client.reservations', compact('reservations'));
    }

    /**
     * Retourne la liste des réservations filtrées (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxList(Request $request)
    {
        $query = Auth::user()->reservations()->with(['service.provider']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('service', function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhereHas('provider', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%") ;
                  });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->filled('date')) {
            $query->whereDate('reservation_date', $request->get('date'));
        }
        $reservations = $query->latest()->paginate(10);
        return response()->json([
            'reservations' => $reservations
        ]);
    }
}