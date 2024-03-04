<?php

namespace Pashkevich\Wallet\Http\Controllers\Apple;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{App, Config};
use Illuminate\Contracts\Support\Responsable;
use Pashkevich\Wallet\Handlers\Apple\WebhookHandler;

class WebhookController
{
    /**
     * Register a pass for update notifications.
     *
     * Set up change notifications for a pass on a device.
     *
     * @param Request $request
     * @param string $deviceLibraryIdentifier
     * @param string $passTypeIdentifier
     * @param string $serialNumber
     * @return Responsable
     */
    public function registerPass(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): Responsable {
        $authenticationToken = $this->getAuthenticationToken($request);

        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'), compact('authenticationToken'));

        return $handler->registerPass(
            $deviceLibraryIdentifier,
            $passTypeIdentifier,
            $serialNumber,
            $request->get('pushToken'),
        );
    }

    /**
     * Unregister a pass for update notifications.
     *
     * Stop sending update notifications for a pass on a device.
     *
     * @param Request $request
     * @param string $deviceLibraryIdentifier
     * @param string $passTypeIdentifier
     * @param string $serialNumber
     * @return Responsable
     */
    public function unregisterPass(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): Responsable {
        $authenticationToken = $this->getAuthenticationToken($request);

        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'), compact('authenticationToken'));

        return $handler->unregisterPass($deviceLibraryIdentifier, $passTypeIdentifier, $serialNumber);
    }

    /**
     * Get the list of updatable passes.
     *
     * Send the serial numbers for updated passes to a device.
     *
     * @param Request $request
     * @param string $deviceLibraryIdentifier
     * @param string $passTypeIdentifier
     * @return Responsable
     */
    public function getUpdatablePasses(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
    ): Responsable {
        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'));

        return $handler->getUpdatablePasses(
            $deviceLibraryIdentifier,
            $passTypeIdentifier,
            $request->query('passesUpdatedSince'),
        );
    }

    /**
     * Send an updated pass.
     *
     * Create and sign an updated pass, and send it to the device.
     *
     * @param Request $request
     * @param string $passTypeIdentifier
     * @param string $serialNumber
     * @return Responsable
     */
    public function getUpdatedPass(Request $request, string $passTypeIdentifier, string $serialNumber): Responsable
    {
        $authenticationToken = $this->getAuthenticationToken($request);

        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'), compact('authenticationToken'));

        return $handler->getUpdatedPass($passTypeIdentifier, $serialNumber);
    }

    /**
     * Log a message.
     *
     * Record a message on your server.
     *
     * @param Request $request
     * @return Responsable
     */
    public function log(Request $request): Responsable
    {
        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'));

        return $handler->log($request->all());
    }

    /**
     * Get the authentication token from the request headers.
     *
     * The value is the word ApplePass, followed by a space, followed by the authenticationToken key of the pass.
     *
     * @param Request $request
     * @return string
     */
    protected function getAuthenticationToken(Request $request): string
    {
        return str_replace('ApplePass ', '', $request->headers->get('Authorization', ''));
    }
}
