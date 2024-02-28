<?php

return [
    'apple' => [
        'certificate_path' => env('WALLET_APPLE_CERTIFICATE_PATH'),
        'certificate_password' => env('WALLET_APPLE_CERTIFICATE_PASSWORD'),
        'wwdr_certificate_path' => env('WALLET_APPLE_WWDR_CERTIFICATE_PATH'),

        'webhook_handler' => \Pashkevich\Wallet\Wallets\Apple\Handlers\EmptyWebhookHandler::class,
    ],
    'google' => [],
];
