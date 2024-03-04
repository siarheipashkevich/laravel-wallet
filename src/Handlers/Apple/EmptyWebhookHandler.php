<?php

namespace Pashkevich\Wallet\Handlers\Apple;

use Pashkevich\Wallet\Http\Responses\{AppleResponse, ApplePassResponse};

class EmptyWebhookHandler extends WebhookHandler
{
    public function registerPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
        string $pushToken,
    ): AppleResponse {
        // Request Not Authorized (401)
        if ($this->authenticationToken !== 'abc') {
            return new AppleResponse(401);
        }

        // Serial Number Already Registered for Device (200)
//        return new AppleResponse(200);

        // Registration Successful (201)
        return new AppleResponse(201);
    }

    public function unregisterPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): AppleResponse {
        // Request Not Authorized (401)
        if ($this->authenticationToken !== 'abc') {
            return new AppleResponse(401);
        }

        // Device Unregistered (200)
        return new AppleResponse();
    }

    public function getUpdatablePasses(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        ?string $passesUpdatedSince,
    ): AppleResponse {
        // No Matching Passes (204)
        if ('a' !== 'b') {
            return new AppleResponse(204);
        }

        // Return Matching Passes (200)
        return new AppleResponse(content: [
            'serialNumbers' => ['111', '222'],
            'lastUpdated' => '1351981923',
        ]);
    }

    public function getUpdatedPass(string $passTypeIdentifier, string $serialNumber): AppleResponse|ApplePassResponse
    {
        // Request Not Authorized (401)
        if ($this->authenticationToken !== 'abc') {
            return new AppleResponse(401);
        }

        // The request is successful and returns the updated pass (200)
        return new ApplePassResponse('pass_path', 'pass_name');
    }

    public function log(array $log): AppleResponse
    {
        // write log to any store if it's needed

        return new AppleResponse();
    }
}
