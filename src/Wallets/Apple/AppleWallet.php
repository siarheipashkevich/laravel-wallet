<?php

namespace Pashkevich\Wallet\Wallets\Apple;

use Pashkevich\Wallet\Contracts\Wallet;

class AppleWallet implements Wallet
{
    public function __construct(protected array $config) {}
}
