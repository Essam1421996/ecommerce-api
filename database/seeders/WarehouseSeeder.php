<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('Products not found. Please run ProductSeeder first.');
            return;
        }

        // Create warehouse entries for all products
        foreach ($products as $product) {
            Warehouse::create([
                'product_id' => $product->id,
                'quantity' => rand(0, 100), // Random stock quantity
            ]);
        }
    }
}
