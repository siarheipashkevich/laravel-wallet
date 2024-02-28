<?php

namespace Pashkevich\Wallet;

use InvalidArgumentException;
use Illuminate\Support\Manager;
use Pashkevich\Wallet\Wallets\Apple\AppleWallet;
use Pashkevich\Wallet\Wallets\Google\GoogleWallet;
use Pashkevich\Wallet\Contracts\{Wallet, Factory};

class WalletManager extends Manager implements Factory
{
    public function provider(string $provider): Wallet
    {
        return $this->driver($provider);
    }

    public function createAppleDriver(): AppleWallet
    {
        return new AppleWallet($this->config->get('wallet.apple'));
    }

    public function createGoogleDriver(): GoogleWallet
    {
        return new GoogleWallet($this->config->get('wallet.google'));
    }

    public function getDefaultDriver(): void
    {
        throw new InvalidArgumentException('No Wallet provider was specified.');
    }
}
