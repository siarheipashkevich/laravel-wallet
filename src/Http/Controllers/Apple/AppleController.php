<?php

namespace Pashkevich\Wallet\Http\Controllers\Apple;

use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{App, Config};
use Pashkevich\Wallet\Wallets\Apple\Handlers\WebhookHandler;

class AppleController
{
    public function registerPass(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): Response {
        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook_handler'));

        $handler->setAuthenticationToken($this->getAuthenticationToken($request));

        $status = $handler->registerPass(
            $deviceLibraryIdentifier,
            $passTypeIdentifier,
            $serialNumber,
            $request->get('pushToken'),
        );

        return new Response(status: $status);
    }

    public function unregisterPass(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): Response {
        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook_handler'));

        $handler->setAuthenticationToken($this->getAuthenticationToken($request));

        $status = $handler->unregisterPass($deviceLibraryIdentifier, $passTypeIdentifier, $serialNumber);

        return new Response(status: $status);
    }

    public function getUpdatablePasses(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
    ): Response {
        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook_handler'));

        $response = $handler->getUpdatablePasses(
            $deviceLibraryIdentifier,
            $passTypeIdentifier,
            $request->query('passesUpdatedSince'),
        );

        return new Response($response['content'] ?? '', $response['status']);
    }

    public function getUpdatedPass(Request $request, string $passTypeIdentifier, string $serialNumber): Response
    {
        $authenticationToken = $this->getAuthenticationToken($request);

        return new Response();
    }

    public function log(Request $request): Response
    {
        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook_handler'));

        $handler->log($request->all());

        return new Response();
    }

    protected function getAuthenticationToken(Request $request): string
    {
        return str_replace('ApplePass ', '', $request->headers->get('Authorization', ''));
    }
}
