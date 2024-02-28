<?php

namespace Pashkevich\Wallet\Wallets\Apple\Handlers;

abstract class WebhookHandler
{
    protected string $authenticationToken;

    public function setAuthenticationToken(string $token): void
    {
        $this->authenticationToken = $token;
    }

    public function getAuthenticationToken(): string
    {
        return $this->authenticationToken;
    }

    public function registerPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
        string $pushToken,
    ): int {
        // Request Not Authorized (401)
        if ($this->getAuthenticationToken() !== 'abc') {
            return 401;
        }

        // Serial Number Already Registered for Device (200)

        // Registration Successful (201)

        return 200;
    }

    public function unregisterPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): int {
        // Request Not Authorized (401)
        if ($this->getAuthenticationToken() !== 'abc') {
            return 401;
        }

        // Device Unregistered (200)

        return 200;
    }

    public function getUpdatablePasses(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        ?string $passesUpdatedSince,
    ): array {
        // No Matching Passes (204)
        if ('a' !== 'b') {
            return ['statue' => 204];
        }

        // Return Matching Passes (200)
        return [
            'status' => 200,
            'content' => [
                'serialNumbers' => ['111', '222'],
                'lastUpdated' => '1351981923',
            ],
        ];
    }

    public function getUpdatedPass(string $passTypeIdentifier, string $serialNumber): int
    {
        // Request Not Authorized (401)
        if ($this->getAuthenticationToken() !== 'abc') {
            return 401;
        }

        // The request is successful and returns the updated pass (200)
        return 200;
    }

    public function log(array $log): void
    {
        // write log to any store if it's needed
    }
}
