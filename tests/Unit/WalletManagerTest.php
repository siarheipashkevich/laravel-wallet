<?php

namespace Pashkevich\Wallet\Tests\Unit;

use InvalidArgumentException;
use Illuminate\Support\Facades\App;
use Pashkevich\Wallet\WalletManager;
use Pashkevich\Wallet\Tests\TestCase;
use Pashkevich\Wallet\Contracts\Factory;
use Pashkevich\Wallet\Wallets\Apple\AppleWallet;
use Pashkevich\Wallet\Wallets\Google\GoogleWallet;

class WalletManagerTest extends TestCase
{
    public function testItCanInstantiateTheAppleWalletProvider()
    {
        /** @var WalletManager $manager */
        $manager = App::make(Factory::class);

        $this->assertInstanceOf(AppleWallet::class, $manager->provider('apple'));
    }

    public function testItCanInstantiateTheGoogleWalletProvider()
    {
        /** @var WalletManager $manager */
        $manager = App::make(Factory::class);

        $this->assertInstanceOf(GoogleWallet::class, $manager->provider('google'));
    }

    public function testItCanNotInstantiateTheUnknownWalletProvider()
    {
        /** @var WalletManager $manager */
        $manager = App::make(Factory::class);

        $provider = 'unknown';

        $this->assertThrows(
            fn () => $manager->provider($provider),
            InvalidArgumentException::class,
            "Driver [$provider] not supported.",
        );
    }
}
