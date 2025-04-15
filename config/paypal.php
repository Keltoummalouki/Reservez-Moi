<?php

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Peut être 'sandbox' ou 'live'
    
    'sandbox' => [
        'client_id'     => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'        => env('PAYPAL_SANDBOX_APP_ID', ''),
    ],

    'live' => [
        'client_id'     => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'        => env('PAYPAL_LIVE_APP_ID', ''),
    ],

    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Peut être 'Sale', 'Authorization' ou 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'EUR'),
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // URL de notification IPN PayPal
    'locale'         => env('PAYPAL_LOCALE', 'fr_FR'), // Paramètre de langue par défaut pour les pages de PayPal
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Valider SSL lors des requêtes à l'API PayPal
    
    // Paramètres supplémentaires pour la configuration de l'API PayPal
    'settings' => [
        'http.ConnectionTimeOut' => 30,
        'mode' => env('PAYPAL_MODE', 'sandbox'),
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'INFO', // PLEASE USE `INFO` LEVEL FOR LOGGING IN PRODUCTION ENVIRONMENT
    ],
];