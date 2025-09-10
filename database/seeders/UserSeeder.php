<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@ecommerce.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create seller users
        User::create([
            'name' => 'John Seller',
            'email' => 'john@seller.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);

        User::create([
            'name' => 'Jane Seller',
            'email' => 'jane@seller.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);

        // Create customer users
        User::create([
            'name' => 'Alice Customer',
            'email' => 'alice@customer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Bob Customer',
            'email' => 'bob@customer.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create additional random users
        User::factory(10)->create();
    }
}
