<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationCreated;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Client']);
    }

    public function showForm($serviceId)
    {
        $service = Service::where('is_available', true)->findOrFail($serviceId);
        return view('client.reserve_form', compact('service'));
    }

    public function reserve(Request $request, $serviceId)
    {
        $service = Service::where('is_available', true)->findOrFail($serviceId);

        $request->validate([
            'reservation_date' => 'required|date|after:now',
            'notes' => 'nullable|string|max:1000',
        ], [
            'reservation_date.after' => 'La date de réservation doit être dans le futur.',
        ]);

        $conflictingReservation = Reservation::where('service_id', $service->id)
            ->where('status', 'confirmed')
            ->where('reservation_date', $request->reservation_date)
            ->exists();

        if ($conflictingReservation) {
            return redirect()->back()
                ->with('error', 'Ce créneau est déjà réservé. Veuillez choisir une autre date.')
                ->withInput();
        }

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'service_id' => $service->id,
            'reservation_date' => $request->reservation_date,
            'status' => 'pending',
            'notes' => $request->notes,
            'amount' => $service->price,
            'payment_status' => 'pending',
        ]);

        try {
            $reservation->service->provider->notify(new ReservationCreated($reservation));
        } catch (\Exception $e) {
            \Log::error('Failed to send reservation notification: ' . $e->getMessage());
        }

        return redirect()->route('client.reservations.paypal', compact('reservation'))
            ->with('success', 'Réservation effectuée avec succès ! Veuillez procéder au paiement via PayPal.');
    }

    public function cancel(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($reservation->status === 'cancelled') {
            return redirect()->route('client.reservations')
                ->with('error', 'Cette réservation est déjà annulée.');
        }

        $reservation->update([
            'status' => 'cancelled'
        ]);

        try {
        } catch (\Exception $e) {
            \Log::error('Failed to send cancellation notification: ' . $e->getMessage());
        }

        return redirect()->route('client.reservations')
            ->with('success', 'Votre réservation a été annulée avec succès.');
    }

    public function paypal(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id() || $reservation->payment_status !== 'pending') {
            abort(403, 'Unauthorized');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "reference_id" => $reservation->id,
                        "amount" => [
                            "currency_code" => config('paypal.currency', 'USD'),
                            "value" => $reservation->amount,
                        ],
                        "description" => "Paiement pour la réservation du service: " . $reservation->service->name,
                    ],
                ],
                "application_context" => [
                    "return_url" => route('client.reservations.paypal.success') . '?reservation_id=' . $reservation->id,
                    "cancel_url" => route('client.reservations.paypal.cancel'),
                ],
            ]);

            if (isset($response['id']) && $response['status'] === 'CREATED') {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('client.reservations')
                ->with('error', 'Une erreur est survenue lors de la création du paiement PayPal.');
        } catch (\Exception $e) {
            \Log::error('Erreur PayPal: ' . $e->getMessage());
            return redirect()->route('client.reservations')
                ->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.');
        }
    }

    public function paypalSuccess(Request $request)
    {
        $reservationId = $request->query('reservation_id');

        if (!$reservationId) {
            return redirect()->route('client.reservations')
                ->with('error', 'ID de réservation manquant dans la réponse PayPal.');
        }

        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return redirect()->route('client.reservations')
                ->with('error', 'Réservation non trouvée.');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            $response = $provider->capturePaymentOrder($request->token);

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $reservation->update([
                    'payment_status' => 'completed',
                    'paypal_transaction_id' => $response['id'],
                ]);

                return redirect()->route('client.reservations')
                    ->with('success', 'Paiement effectué avec succès via PayPal !');
            }

            return redirect()->route('client.reservations')
                ->with('error', 'Le paiement PayPal a échoué.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la capture du paiement PayPal: ' . $e->getMessage());
            return redirect()->route('client.reservations')
                ->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.');
        }
    }

    public function paypalCancel()
    {
        return redirect()->route('client.reservations')
            ->with('error', 'Le paiement PayPal a été annulé.');
    }

    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with('service.provider')
            ->latest()
            ->paginate(10);

        return view('client.reservations', compact('reservations'));
    }
}