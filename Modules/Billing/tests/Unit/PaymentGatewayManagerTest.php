<?php

namespace Modules\Billing\Tests\Unit;

use Modules\Billing\Services\PaymentGatewayManager;
use PHPUnit\Framework\TestCase;

class PaymentGatewayManagerTest extends TestCase
{
    public function test_create_subscription_returns_payload(): void
    {
        $manager = new PaymentGatewayManager(['stripe' => []]);
        $result = $manager->createSubscription('stripe', ['plan' => 'basic']);

        $this->assertSame('stripe', $result['provider']);
        $this->assertSame(['plan' => 'basic'], $result['payload']);
    }

    public function test_unknown_provider_throws_exception(): void
    {
        $manager = new PaymentGatewayManager([]);
        $this->expectException(\RuntimeException::class);
        $manager->createSubscription('foo', []);
    }
}
