<?php

namespace Pashkevich\Wallet\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApplePassResponse implements Responsable
{
    public function __construct(public string $pass, public string $name, public array $headers = []) {}

    public function toResponse($request): BinaryFileResponse
    {
        return response()->file($this->pass, [
            'Content-Description' => 'File Transfer',
            'Content-Type' => 'application/vnd.apple.pkpass',
            'Content-Disposition' => sprintf('attachment; filename="%s.pkpass"', $this->name),
            'Content-Transfer-Encoding' => 'binary',
//            'Connection' => 'Keep-Alive',
            'Expires' => '0',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Last-Modified' => gmdate('D, d M Y H:i:s T'),
            'Pragma' => 'public', // 'Pragma' => 'no-cache',
            ...$this->headers,
        ]);
    }
}
