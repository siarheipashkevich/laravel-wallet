<?php

declare(strict_types=1);

namespace Pashkevich\Wallet\Handlers\Apple;

use Pashkevich\Wallet\Http\Responses\{AppleResponse, ApplePassResponse};

abstract class WebhookHandler
{
    public function __construct(public readonly ?string $authenticationToken = null) {}

    abstract public function registerPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
        string $pushToken,
    ): AppleResponse;

    abstract public function unregisterPass(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): AppleResponse;

    abstract public function getUpdatablePasses(
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        ?string $passesUpdatedSince,
    ): AppleResponse;

    abstract public function getUpdatedPass(
        string $passTypeIdentifier,
        string $serialNumber,
    ): AppleResponse|ApplePassResponse;

    abstract public function log(array $log): AppleResponse;
}
