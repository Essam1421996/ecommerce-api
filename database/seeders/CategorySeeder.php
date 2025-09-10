<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel for all ages',
            ],
            [
                'name' => 'Books',
                'description' => 'Books, magazines, and educational materials',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and gardening supplies',
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
            ],
            [
                'name' => 'Beauty & Health',
                'description' => 'Beauty products and health supplements',
            ],
            [
                'name' => 'Toys & Games',
                'description' => 'Toys, games, and entertainment',
            ],
            [
                'name' => 'Automotive',
                'description' => 'Car parts and automotive accessories',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create additional random categories
        Category::factory(5)->create();
    }
}
