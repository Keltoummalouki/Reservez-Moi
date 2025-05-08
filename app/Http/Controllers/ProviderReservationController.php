<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationConfirmed;
use App\Notifications\ReservationCancelled;

class ProviderReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:ServiceProvider']);
    }

    public function index()
    {
        $reservations = Reservation::whereHas('service', function ($query) {
            $query->where('provider_id', Auth::id());
        })
            ->with('service', 'user')
            ->latest()
            ->paginate(10);
        return view('provider.reservations', compact('reservations'));
    }

    public function confirm(Reservation $reservation)
    {
        if ($reservation->service->provider_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        if ($reservation->status !== 'pending') {
            return redirect()->route('provider.reservations')->with('error', 'Cette réservation ne peut pas être confirmée.');
        }
        $reservation->update(['status' => 'confirmed']);
        $reservation->user->notify(new ReservationConfirmed($reservation));
        return redirect()->route('provider.reservations')->with('success', 'Réservation confirmée avec succès !');
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->service->provider_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return redirect()->route('provider.reservations')->with('error', 'Cette réservation ne peut pas être annulée.');
        }
        $reservation->update(['status' => 'cancelled']);
        $reservation->user->notify(new ReservationCancelled($reservation, 'provider'));
        return redirect()->route('provider.reservations')->with('success', 'Réservation annulée avec succès !');
    }

    public function details($id)
    {
        $reservation = Reservation::with(['user', 'service.category'])
            ->where('id', $id)
            ->whereHas('service', function ($query) {
                $query->where('provider_id', Auth::id());
            })
            ->first();
        if (!$reservation) {
            return response()->json(['success' => false, 'message' => 'Réservation introuvable.']);
        }
        return response()->json([
            'success' => true,
            'reservation' => $reservation
        ]);
    }
}