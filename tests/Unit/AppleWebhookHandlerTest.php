<?php

namespace Pashkevich\Wallet\Tests\Unit;

use Pashkevich\Wallet\Tests\TestCase;
use Illuminate\Support\Facades\{App, Config};
use Pashkevich\Wallet\Tests\Fixtures\AppleWebhookHandler;

class AppleWebhookHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('wallet.apple.webhook.handler', AppleWebhookHandler::class);
    }

    public function testCorrectWebhookHandler()
    {
        /** @var AppleWebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'));

        $this->assertInstanceOf(AppleWebhookHandler::class, $handler);
    }
}
