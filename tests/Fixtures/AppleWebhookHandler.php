<?php

namespace Pashkevich\Wallet\Tests\Fixtures;

use Pashkevich\Wallet\Handlers\Apple\WebhookHandler;
use Pashkevich\Wallet\Http\Responses\{AppleResponse, ApplePassResponse};

class AppleWebhookHandler extends WebhookHandler
{
    public function registerPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
        string $pushToken,
    ): AppleResponse {
        return new AppleResponse();
    }

    public function unregisterPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): AppleResponse {
        return new AppleResponse();
    }

    public function getUpdatablePasses(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        ?string $passesUpdatedSince,
    ): AppleResponse {
        return new AppleResponse();
    }

    public function getUpdatedPass(string $passTypeIdentifier, string $serialNumber,): AppleResponse|ApplePassResponse
    {
        return new AppleResponse();
    }

    public function log(array $log): AppleResponse
    {
        return new AppleResponse();
    }
}
