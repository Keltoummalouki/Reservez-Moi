<?php
namespace App\Services\Payment;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalPaymentService implements PaymentServiceInterface
{
    protected $client;
    
    public function __construct()
    {
        $this->client = new PayPalClient;
        $this->client->setApiCredentials(config('paypal'));
        $this->client->getAccessToken();
    }
    
    public function createPayment($amount, $description, $redirectUrls)
    {
        return $this->client->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => $redirectUrls['success'],
                "cancel_url" => $redirectUrls['cancel'],
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => config('paypal.currency', 'USD'),
                        "value" => $amount,
                    ],
                    "description" => $description,
                ]
            ]
        ]);
    }
    
    public function capturePayment($token)
    {
        return $this->client->capturePaymentOrder($token);
    }
}