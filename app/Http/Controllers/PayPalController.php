<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function createPayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        try {
            $order = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('client.reservations.paypal.success') . '?reservation_id=' . $request->reservation_id,
                    "cancel_url" => route('client.reservations.paypal.cancel'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => config('paypal.currency', 'USD'),
                            "value" => $request->amount,
                        ],
                        "description" => "Paiement pour la réservation #" . $request->reservation_id,
                    ]
                ]
            ]);

            if (isset($order['id'])) {
                foreach ($order['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('client.reservations.paypal.cancel')
                ->with('error', 'Impossible de créer la commande PayPal.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du paiement PayPal: ' . $e->getMessage());
            return redirect()->route('client.reservations.paypal.cancel')
                ->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        try {
            $result = $provider->capturePaymentOrder($request->token);

            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
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

    public function cancel()
    {
        return redirect()->route('client.reservations')
            ->with('error', 'Le paiement PayPal a été annulé.');
    }
}