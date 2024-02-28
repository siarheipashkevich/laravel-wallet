<?php

namespace Pashkevich\Wallet;

use Illuminate\Support\ServiceProvider;
use Pashkevich\Wallet\Contracts\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;

class WalletServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/wallet.php', 'wallet');

        $this->app->singleton(Factory::class, function (Application $app) {
            return new WalletManager($app);
        });
    }

    public function boot(): void
    {
        //
    }

    public function provides(): array
    {
        return [Factory::class];
    }
}
