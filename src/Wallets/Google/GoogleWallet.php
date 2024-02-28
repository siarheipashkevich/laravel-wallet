<?php

namespace Pashkevich\Wallet\Wallets\Google;

use Pashkevich\Wallet\Contracts\{Pass, Wallet};

class GoogleWallet implements Wallet
{
    public function __construct(protected array $config) {}

    public function createPass(Pass $pass): void
    {
        //
    }
}
