<?php

namespace Pashkevich\Wallet\Contracts;

interface Factory
{
    public function provider(string $provider): Wallet;
}
