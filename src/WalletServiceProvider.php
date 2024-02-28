<?php

namespace Pashkevich\Wallet;

use Illuminate\Support\ServiceProvider;
use Pashkevich\Wallet\Contracts\Factory;
use Illuminate\Contracts\Foundation\Application;

class WalletServiceProvider extends ServiceProvider
{
    public function register(): void
    {
//        $this->mergeConfigFrom(__DIR__ . '/../config/wallet.php', 'wallet');

        $this->app->singleton(Factory::class, function (Application $app) {
            return new WalletManager($app);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/wallet.php' => config_path('wallet.php'),
        ]);

        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        if (config('wallet.apple.routes') === false) {
            return;
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/apple.php');
    }
}
