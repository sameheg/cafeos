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
    }
}
