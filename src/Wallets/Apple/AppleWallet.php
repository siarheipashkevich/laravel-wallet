<?php

namespace Pashkevich\Wallet\Wallets\Apple;

use Pashkevich\Wallet\Contracts\{Pass, Wallet};

class AppleWallet implements Wallet
{
    public function __construct(protected array $config) {}

    public function createPass(Pass $pass): mixed
    {
        return null;
    }
}
