<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockAdjustment;
use App\Models\User;
use Illuminate\Database\Seeder;

class StockAdjustmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $users = User::whereIn('role', ['admin', 'seller'])->get();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->warn('Products or users not found. Please run ProductSeeder and UserSeeder first.');
            return;
        }

        // Create initial stock adjustments for some products
        $adjustments = [
            [
                'product_id' => $products->first()->id,
                'quantity' => 50,
                'reason' => 'Initial stock',
                'adjusted_by' => $users->first()->id,
            ],
            [
                'product_id' => $products->skip(1)->first()->id,
                'quantity' => 30,
                'reason' => 'Initial stock',
                'adjusted_by' => $users->first()->id,
            ],
            [
                'product_id' => $products->skip(2)->first()->id,
                'quantity' => 25,
                'reason' => 'Initial stock',
                'adjusted_by' => $users->first()->id,
            ],
        ];

        foreach ($adjustments as $adjustment) {
            StockAdjustment::create($adjustment);
        }

        // Create additional random stock adjustments
        StockAdjustment::factory(20)->create();
    }
}
