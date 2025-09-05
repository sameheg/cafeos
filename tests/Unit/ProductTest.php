<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductTest extends TestCase
{
    public function test_product_relations()
    {
        $product = new Product();
        $this->assertInstanceOf(HasMany::class, $product->product_variations());
        $this->assertInstanceOf(BelongsTo::class, $product->brand());
        $this->assertInstanceOf(BelongsTo::class, $product->unit());
    }

    public function test_image_accessor()
    {
        $product = new Product();
        $this->assertStringEndsWith('/img/default.png', $product->image_url);
        $this->assertNull($product->image_path);
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
