<?php

namespace Modules\Billing\Tests\Unit;

use Modules\Billing\Services\PaymentGatewayManager;
use PHPUnit\Framework\TestCase;

class PaymentGatewayManagerTest extends TestCase
{
    public function test_create_subscription_returns_payload(): void
    {
        $manager = new PaymentGatewayManager([
            'stripe' => ['accounts' => ['corp' => []]],
        ]);
        $result = $manager->createSubscription('stripe', ['plan' => 'basic'], 'corp');

        $this->assertSame('stripe', $result['provider']);
        $this->assertSame('corp', $result['account']);
        $this->assertSame(['plan' => 'basic'], $result['payload']);
    }

    public function test_unknown_provider_throws_exception(): void
    {
        $manager = new PaymentGatewayManager([]);
        $this->expectException(\RuntimeException::class);
        $manager->createSubscription('foo', []);
    }

    public function test_unknown_account_throws_exception(): void
    {
        $manager = new PaymentGatewayManager(['stripe' => ['accounts' => []]]);
        $this->expectException(\RuntimeException::class);
        $manager->createSubscription('stripe', [], 'missing');
    }
}
