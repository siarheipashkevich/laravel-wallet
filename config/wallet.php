<?php

return [
    'apple' => [
        'certificate_path' => env('WALLET_APPLE_CERTIFICATE_PATH'),
        'certificate_password' => env('WALLET_APPLE_CERTIFICATE_PASSWORD'),
        'wwdr_certificate_path' => env('WALLET_APPLE_WWDR_CERTIFICATE_PATH'),

        'webhook' => [
            'handler' => \Pashkevich\Wallet\Handlers\Apple\EmptyWebhookHandler::class,
        ],

        'apns' => [
            'certificate_path' => env('WALLET_APPLE_APNS_CERTIFICATE_PATH'),
            'password' => env('WALLET_APPLE_APNS_PASSWORD'),
        ],
    ],

    'google' => [
        'gcm' => [
            'key' => env('WALLET_GOOGLE_GCM_KEY'),
        ],
    ],
];
