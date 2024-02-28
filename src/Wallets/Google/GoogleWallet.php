<?php

namespace Pashkevich\Wallet\Wallets\Google;

use Pashkevich\Wallet\Contracts\Wallet;

class GoogleWallet implements Wallet
{
    public function __construct(protected array $config) {}
}
