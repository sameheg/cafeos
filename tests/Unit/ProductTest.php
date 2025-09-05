<?php

namespace Tests\Unit;

use App\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_relations(): void
    {
        $product = new Product();

        $this->assertInstanceOf(HasMany::class, $product->product_variations());
        $this->assertInstanceOf(BelongsTo::class, $product->brand());
        $this->assertInstanceOf(BelongsTo::class, $product->unit());
    }

    public function test_image_accessor(): void
    {
        $product = new Product();

        $this->assertStringEndsWith('/img/default.png', $product->image_url);
        $this->assertNull($product->image_path);
    }

    public function test_image_url_returns_default_when_empty(): void
    {
        config(['app.url' => 'http://example.com']);

        $product = new Product();

        $this->assertEquals('http://example.com/img/default.png', $product->getImageUrlAttribute());
    }

    public function test_scope_active_adds_condition(): void
    {
        $query = Product::query()->active();
        $sql = str_replace('`', '', $query->toSql());

        $this->assertStringContainsString('products.is_inactive = ?', $sql);
        $this->assertEquals([0], $query->getBindings());
    }
}

