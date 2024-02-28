<?php

namespace Pashkevich\Wallet\Facades;

use Illuminate\Support\Facades\Facade;
use Pashkevich\Wallet\Contracts\{Wallet as WalletContract, Factory};

/**
 * @method static WalletContract provider(string $provider)
 */
class Wallet extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Factory::class;
    }
}
