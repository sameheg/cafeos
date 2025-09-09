<?php

namespace App\Support {
    if (! function_exists(__NAMESPACE__ . '\\tenant')) {
        function tenant($key = null) {
            $tenant = \Tests\Unit\CurrencyFormatterTenantContext::$tenant;
            if (! $tenant) {
                return null;
            }
            return $key ? $tenant->{$key} : $tenant;
        }
    }
}

namespace Tests\Unit {

use App\Models\Tenant;
use App\Support\CurrencyFormatter;
use Modules\Pos\Models\MenuItem;
use Modules\Pos\Models\Order;
use NumberFormatter;
use Tests\TestCase;

class CurrencyFormatterTenantContext
{
    public static ?Tenant $tenant = null;
}

class CurrencyFormatterTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        CurrencyFormatterTenantContext::$tenant = null;
        app()->forgetInstance('tenant');
    }

    public function test_it_uses_tenant_currency_when_available(): void
    {
        $tenant = new Tenant(['id' => 1, 'currency' => 'EUR']);
        CurrencyFormatterTenantContext::$tenant = $tenant;

        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

        $this->assertSame(
            $formatter->formatCurrency(10, 'EUR'),
            CurrencyFormatter::format(10)
        );

        $menuItem = new MenuItem(['price' => 5]);
        $this->assertSame(
            $formatter->formatCurrency(5, 'EUR'),
            $menuItem->formatted_price
        );

        $order = new Order(['total' => 20]);
        $this->assertSame(
            $formatter->formatCurrency(20, 'EUR'),
            $order->formatted_total
        );
    }

    public function test_it_falls_back_to_app_currency_when_tenant_not_available(): void
    {
        CurrencyFormatterTenantContext::$tenant = null;
        config(['app.currency' => 'USD']);

        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);

        $this->assertSame(
            $formatter->formatCurrency(10, 'USD'),
            CurrencyFormatter::format(10)
        );
    }
}

}
