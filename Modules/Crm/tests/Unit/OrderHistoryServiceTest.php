<?php

namespace Modules\Crm\Tests\Unit;

use Modules\Crm\Contracts\OrderHistoryServiceInterface;
use Modules\Crm\Providers\CrmServiceProvider;
use Tests\TestCase;

class OrderHistoryServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(CrmServiceProvider::class);
    }

    public function test_service_resolves(): void
    {
        $service = $this->app->make(OrderHistoryServiceInterface::class);
        $this->assertNotNull($service);
    }
}
