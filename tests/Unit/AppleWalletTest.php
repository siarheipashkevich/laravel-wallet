<?php

namespace Pashkevich\Wallet\Tests\Unit;

use Pashkevich\Wallet\Tests\TestCase;
use Illuminate\Support\Facades\{App, Config};
use Pashkevich\Wallet\Handlers\Apple\WebhookHandler;

class AppleWalletTest extends TestCase
{
    public function testWebhookHandlerIsValid()
    {
        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'));

        $this->assertInstanceOf(WebhookHandler::class, $handler);
    }

    public function testValidAuthenticationToken()
    {
        $authenticationToken = 'abc';

        /** @var WebhookHandler $handler */
        $handler = App::make(Config::get('wallet.apple.webhook.handler'), compact('authenticationToken'));

        $this->assertEquals($authenticationToken, $handler->authenticationToken);
    }
}
