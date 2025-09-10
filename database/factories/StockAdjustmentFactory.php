<?php

namespace Database\Factories;

use App\Models\StockAdjustment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockAdjustment>
 */
class StockAdjustmentFactory extends Factory
{
    protected $model = StockAdjustment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => $this->faker->numberBetween(-50, 100),
            'reason' => $this->faker->randomElement([
                'Initial stock',
                'Restock',
                'Damaged goods',
                'Returned items',
                'Inventory count',
                'Theft adjustment',
                'Expired products'
            ]),
            'adjusted_by' => User::factory(),
        ];
    }
}
