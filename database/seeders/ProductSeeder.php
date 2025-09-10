<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $sellers = User::where('role', 'seller')->get();

        if ($categories->isEmpty() || $sellers->isEmpty()) {
            $this->command->warn('Categories or sellers not found. Please run CategorySeeder and UserSeeder first.');
            return;
        }

        // Create specific products for each category
        $products = [
            // Electronics
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with advanced camera system',
                'price' => 999.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'seller_id' => $sellers->first()->id,
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Premium Android smartphone with AI features',
                'price' => 899.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'seller_id' => $sellers->first()->id,
            ],
            [
                'name' => 'MacBook Pro 16"',
                'description' => 'Professional laptop for creators and developers',
                'price' => 2499.99,
                'category_id' => $categories->where('name', 'Electronics')->first()->id,
                'seller_id' => $sellers->first()->id,
            ],

            // Clothing
            [
                'name' => 'Classic White T-Shirt',
                'description' => '100% cotton comfortable t-shirt',
                'price' => 19.99,
                'category_id' => $categories->where('name', 'Clothing')->first()->id,
                'seller_id' => $sellers->first()->id,
            ],
            [
                'name' => 'Denim Jeans',
                'description' => 'Classic blue denim jeans for everyday wear',
                'price' => 49.99,
                'category_id' => $categories->where('name', 'Clothing')->first()->id,
                'seller_id' => $sellers->first()->id,
            ],

            // Books
            [
                'name' => 'The Great Gatsby',
                'description' => 'Classic American novel by F. Scott Fitzgerald',
                'price' => 12.99,
                'category_id' => $categories->where('name', 'Books')->first()->id,
                'seller_id' => $sellers->first()->id,
            ],
            [
                'name' => 'Clean Code',
                'description' => 'A Handbook of Agile Software Craftsmanship',
                'price' => 34.99,
                'category_id' => $categories->where('name', 'Books')->first()->id,
                'seller_id' => $sellers->first()->id,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create additional random products
        Product::factory(20)->create();
    }
}
