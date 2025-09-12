<?php
namespace Modules\Pos\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Pos\App\Models\OrderItem;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $qty = $this->faker->randomFloat(2, 1, 3);
        $price = $this->faker->randomFloat(2, 10, 100);
        return [
            'sku' => 'SKU-'.strtoupper($this->faker->bothify('??##')),
            'name' => $this->faker->word(),
            'qty' => $qty,
            'price' => $price,
            'line_total' => $qty * $price,
        ];
    }
}
