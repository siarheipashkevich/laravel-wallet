<?php

namespace Pashkevich\Wallet\Tests;

use Pashkevich\Wallet\WalletServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            WalletServiceProvider::class,
        ];
    }
}
