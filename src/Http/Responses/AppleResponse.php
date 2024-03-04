<?php

namespace Pashkevich\Wallet\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;

class AppleResponse implements Responsable
{
    public function __construct(public int $status = 200, public mixed $content = '', public array $headers = []) {}

    public function toResponse($request): Response
    {
        return new Response($this->content, $this->status, $this->headers);
    }
}
