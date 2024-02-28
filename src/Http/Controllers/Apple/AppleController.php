<?php

namespace Pashkevich\Wallet\Http\Controllers\Apple;

use Illuminate\Http\{Request, Response};

class AppleController
{
    public function registerPass(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): Response {
        $authenticationToken = $this->getAuthenticationToken($request);

        $pushToken = $request->get('pushToken');

        return new Response();
    }

    public function unregisterPass(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
        string $serialNumber,
    ): Response {
        $authenticationToken = $this->getAuthenticationToken($request);

        return new Response();
    }

    public function getUpdatablePasses(
        Request $request,
        string $deviceLibraryIdentifier,
        string $passTypeIdentifier,
    ): Response {
        $passesUpdatedSince = $request->query('passesUpdatedSince');

        return new Response();
    }

    public function getUpdatedPass(Request $request, string $passTypeIdentifier, string $serialNumber): Response
    {
        $authenticationToken = $this->getAuthenticationToken($request);

        return new Response();
    }

    public function log(Request $request): Response
    {
        $log = $request->all();

        return new Response();
    }

    protected function getAuthenticationToken(Request $request): string
    {
        return str_replace('ApplePass ', '', $request->headers->get('Authorization', ''));
    }
}
