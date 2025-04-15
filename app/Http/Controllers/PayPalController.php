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
        try {
            // Vérification de la réservation
            $reservation = Reservation::findOrFail($request->reservation_id);
            
            // Vérifier si la réservation a déjà été payée
            if ($reservation->payment_status === 'completed') {
                return redirect()->route('client.reservations')
                    ->with('error', 'Cette réservation a déjà été payée.');
            }
            
            // Vérifier si la réservation a été annulée
            if ($reservation->status === 'cancelled') {
                return redirect()->route('client.reservations')
                    ->with('error', 'Cette réservation a été annulée et ne peut pas être payée.');
            }
            
            // Initialiser le client PayPal
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            // Créer l'ordre de paiement
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
                "purchase_units" => [
                    [
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
                        "items" => [
                            [
                                "name" => $reservation->service->name,
                                "description" => "Réservation pour le " . $reservation->reservation_date->format('d/m/Y H:i'),
                                "unit_amount" => [
                                    "currency_code" => config('paypal.currency', 'EUR'),
                                    "value" => number_format($reservation->amount, 2, '.', '')
                                ],
                                "quantity" => 1,
                                "category" => "DIGITAL_GOODS"
                            ]
                        ]
                    ]
                ]
            ]);

            // Rediriger vers la page de paiement PayPal si l'ordre est créé avec succès
            if (isset($order['id']) && $order['id']) {
                // Stocker l'ID de l'ordre PayPal dans la réservation
                $reservation->update([
                    'paypal_order_id' => $order['id']
                ]);
                
                // Trouver le lien d'approbation pour rediriger l'utilisateur
                foreach ($order['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            // Si le lien d'approbation n'est pas trouvé
            return redirect()->route('client.reservations.paypal.cancel')
                ->with('error', 'Impossible de créer la commande PayPal. Veuillez réessayer.');
            
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du paiement PayPal: ' . $e->getMessage());
            return redirect()->route('client.reservations.paypal.cancel')
                ->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.');
        }
    }

    /**
     * Capturer le paiement lorsque l'utilisateur revient après avoir approuvé le paiement
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success(Request $request)
    {
        try {
            // Vérification du token et de l'ID de réservation
            if (!$request->has('token') || !$request->has('reservation_id')) {
                return redirect()->route('client.reservations')
                    ->with('error', 'Paramètres manquants dans la réponse PayPal.');
            }
            
            // Récupérer la réservation
            $reservation = Reservation::findOrFail($request->reservation_id);
            
            // Vérifier si la réservation a déjà été payée
            if ($reservation->payment_status === 'completed') {
                return redirect()->route('client.reservations')
                    ->with('info', 'Cette réservation a déjà été payée.');
            }
            
            // Initialiser le client PayPal
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();

            // Capturer le paiement
            $result = $provider->capturePaymentOrder($request->token);

            // Vérifier le statut du paiement
            if (isset($result['status']) && $result['status'] === 'COMPLETED') {
                // Mettre à jour le statut de paiement de la réservation
                $reservation->update([
                    'payment_status' => 'completed',
                    'paypal_transaction_id' => $result['id'],
                    // Si le statut était 'pending', le mettre à 'confirmed'
                    'status' => ($reservation->status === 'pending') ? 'confirmed' : $reservation->status
                ]);
                
                // Envoyer une notification au prestataire (vous pouvez ajouter cette fonctionnalité plus tard)
                
                return redirect()->route('client.reservations')
                    ->with('success', 'Paiement effectué avec succès via PayPal ! Votre réservation est confirmée.');
            }

            // Si le paiement n'est pas complété
            return redirect()->route('client.reservations')
                ->with('error', 'Le paiement PayPal a échoué. Veuillez réessayer.');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors de la capture du paiement PayPal: ' . $e->getMessage());
            return redirect()->route('client.reservations')
                ->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer.');
        }
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
        // Vérifier l'authenticité de la requête PayPal (à implémenter)
        
        $payload = $request->all();
        Log::info('Webhook PayPal reçu', $payload);
        
        // Traiter différents types d'événements
        $eventType = $payload['event_type'] ?? null;
        
        switch ($eventType) {
            case 'PAYMENT.CAPTURE.COMPLETED':
                // Mettre à jour le statut du paiement
                $this->handlePaymentCompleted($payload);
                break;
                
            case 'PAYMENT.CAPTURE.DENIED':
                // Gérer les paiements refusés
                $this->handlePaymentDenied($payload);
                break;
                
            // Ajouter d'autres cas selon les besoins
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
        try {
            // Extraire l'ID de la réservation des données de paiement
            $resource = $payload['resource'] ?? [];
            $customId = $resource['custom_id'] ?? null;
            
            if (!$customId) {
                Log::error('ID de réservation introuvable dans le webhook PayPal', $payload);
                return;
            }
            
            // Trouver et mettre à jour la réservation
            $reservation = Reservation::find($customId);
            
            if (!$reservation) {
                Log::error('Réservation non trouvée pour le paiement PayPal', ['custom_id' => $customId]);
                return;
            }
            
            // Mettre à jour la réservation si elle n'est pas déjà payée
            if ($reservation->payment_status !== 'completed') {
                $reservation->update([
                    'payment_status' => 'completed',
                    'status' => ($reservation->status === 'pending') ? 'confirmed' : $reservation->status
                ]);
                
                // Envoyer une notification (à implémenter)
            }
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement du webhook de paiement PayPal', [
                'error' => $e->getMessage(),
                'payload' => $payload
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
        try {
            // Extraire l'ID de la réservation des données de paiement
            $resource = $payload['resource'] ?? [];
            $customId = $resource['custom_id'] ?? null;
            
            if (!$customId) {
                Log::error('ID de réservation introuvable dans le webhook PayPal', $payload);
                return;
            }
            
            // Trouver et mettre à jour la réservation
            $reservation = Reservation::find($customId);
            
            if (!$reservation) {
                Log::error('Réservation non trouvée pour le paiement PayPal', ['custom_id' => $customId]);
                return;
            }
            
            // Mettre à jour le statut de paiement
            $reservation->update([
                'payment_status' => 'failed'
            ]);
            
            // Envoyer une notification (à implémenter)
            
        } catch (\Exception $e) {
            Log::error('Erreur lors du traitement du webhook de paiement refusé PayPal', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);
        }
    }
}