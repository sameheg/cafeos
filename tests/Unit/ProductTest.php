<?php

namespace Tests\Unit;

use App\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_image_url_returns_default_when_empty()
    {
        config(['app.url' => 'http://example.com']);
        $product = new Product();
        $this->assertEquals('http://example.com/img/default.png', $product->getImageUrlAttribute());
    }

    public function test_scope_active_adds_condition()
    {
        $query = Product::query()->active();
        $sql = str_replace('`', '', $query->toSql());
        $this->assertStringContainsString('products.is_inactive = ?', $sql);
        $this->assertEquals([0], $query->getBindings());
    }
}
