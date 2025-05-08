<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    /**
     * Initialiser le paiement PayPal pour une réservation
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPayment(Request $request)
    {
        $reservation = Reservation::findOrFail($request->reservation_id);
        if ($reservation->payment_status === 'completed') {
            return redirect()->route('client.reservations')
                ->with('error', 'Cette réservation a déjà été payée.');
        }
        if ($reservation->status === 'cancelled') {
            return redirect()->route('client.reservations')
                ->with('error', 'Cette réservation a été annulée et ne peut pas être payée.');
        }
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('client.reservations.paypal.success') . '?reservation_id=' . $reservation->id,
                "cancel_url" => route('client.reservations.paypal.cancel'),
                "brand_name" => "Reservez-Moi",
                "locale" => "fr-FR",
                "landing_page" => "BILLING",
                "user_action" => "PAY_NOW",
            ],
            "purchase_units" => [[
                "reference_id" => $reservation->id,
                "description" => "Paiement pour la réservation #" . $reservation->id,
                "custom_id" => $reservation->id,
                "amount" => [
                    "currency_code" => config('paypal.currency', 'EUR'),
                    "value" => number_format($reservation->amount, 2, '.', ''),
                    "breakdown" => [
                        "item_total" => [
                            "currency_code" => config('paypal.currency', 'EUR'),
                            "value" => number_format($reservation->amount, 2, '.', '')
                        ]
                    ]
                ],
                "items" => [[
                    "name" => $reservation->service->name,
                    "description" => "Réservation pour le " . $reservation->reservation_date->format('d/m/Y H:i'),
                    "unit_amount" => [
                        "currency_code" => config('paypal.currency', 'EUR'),
                        "value" => number_format($reservation->amount, 2, '.', '')
                    ],
                    "quantity" => 1,
                    "category" => "DIGITAL_GOODS"
                ]]
            ]]
        ]);
        if (isset($order['id']) && $order['id']) {
            $reservation->update(['paypal_order_id' => $order['id']]);
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }
        return redirect()->route('client.reservations.paypal.cancel')
            ->with('error', 'Impossible de créer la commande PayPal. Veuillez réessayer.');
    }

    /**
     * Capturer le paiement lorsque l'utilisateur revient après avoir approuvé le paiement
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success(Request $request)
    {
        if (!$request->has('token') || !$request->has('reservation_id')) {
            return redirect()->route('client.reservations')
                ->with('error', 'Paramètres manquants dans la réponse PayPal.');
        }
        $reservation = Reservation::findOrFail($request->reservation_id);
        if ($reservation->payment_status === 'completed') {
            return redirect()->route('client.reservations')
                ->with('info', 'Cette réservation a déjà été payée.');
        }
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $result = $provider->capturePaymentOrder($request->token);
        if (isset($result['status']) && $result['status'] === 'COMPLETED') {
            $reservation->update([
                'payment_status' => 'completed',
                'paypal_transaction_id' => $result['id'],
                'status' => ($reservation->status === 'pending') ? 'confirmed' : $reservation->status
            ]);
            return redirect()->route('client.reservations')
                ->with('success', 'Paiement effectué avec succès via PayPal ! Votre réservation est confirmée.');
        }
        return redirect()->route('client.reservations')
            ->with('error', 'Le paiement PayPal a échoué. Veuillez réessayer.');
    }

    /**
     * Gérer l'annulation du paiement par l'utilisateur
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel()
    {
        return redirect()->route('client.reservations')
            ->with('error', 'Le paiement PayPal a été annulé. Vous pouvez réessayer ultérieurement.');
    }

    /**
     * Webhook pour recevoir les notifications de PayPal
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('Webhook PayPal reçu', $payload);
        $eventType = $payload['event_type'] ?? null;
        switch ($eventType) {
            case 'PAYMENT.CAPTURE.COMPLETED':
                $this->handlePaymentCompleted($payload);
                break;
            case 'PAYMENT.CAPTURE.DENIED':
                $this->handlePaymentDenied($payload);
                break;
        }
        return response()->json(['status' => 'success']);
    }
    
    /**
     * Traiter les paiements complétés via webhook
     * 
     * @param array $payload
     * @return void
     */
    private function handlePaymentCompleted($payload)
    {
        $resource = $payload['resource'] ?? [];
        $customId = $resource['custom_id'] ?? null;
        if (!$customId) {
            Log::error('ID de réservation introuvable dans le webhook PayPal', $payload);
            return;
        }
        $reservation = Reservation::find($customId);
        if (!$reservation) {
            Log::error('Réservation non trouvée pour le paiement PayPal', ['custom_id' => $customId]);
            return;
        }
        if ($reservation->payment_status !== 'completed') {
            $reservation->update([
                'payment_status' => 'completed',
                'status' => ($reservation->status === 'pending') ? 'confirmed' : $reservation->status
            ]);
        }
    }
    
    /**
     * Traiter les paiements refusés via webhook
     * 
     * @param array $payload
     * @return void
     */
    private function handlePaymentDenied($payload)
    {
        $resource = $payload['resource'] ?? [];
        $customId = $resource['custom_id'] ?? null;
        if (!$customId) {
            Log::error('ID de réservation introuvable dans le webhook PayPal', $payload);
            return;
        }
        $reservation = Reservation::find($customId);
        if (!$reservation) {
            Log::error('Réservation non trouvée pour le paiement PayPal', ['custom_id' => $customId]);
            return;
        }
        $reservation->update([
            'payment_status' => 'failed'
        ]);
    }
}