<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Customers or products not found. Please run UserSeeder and ProductSeeder first.');
            return;
        }

        // Create specific orders with realistic data
        $orders = [
            [
                'customer_id' => $customers->first()->id,
                'total_amount' => 1019.98,
                'status' => 'completed',
                'items' => [
                    ['product_id' => $products->first()->id, 'quantity' => 1, 'unit_price' => 999.99],
                    ['product_id' => $products->skip(1)->first()->id, 'quantity' => 1, 'unit_price' => 19.99],
                ]
            ],
            [
                'customer_id' => $customers->skip(1)->first()->id,
                'total_amount' => 69.98,
                'status' => 'processing',
                'items' => [
                    ['product_id' => $products->skip(2)->first()->id, 'quantity' => 1, 'unit_price' => 49.99],
                    ['product_id' => $products->skip(3)->first()->id, 'quantity' => 1, 'unit_price' => 19.99],
                ]
            ],
            [
                'customer_id' => $customers->first()->id,
                'total_amount' => 47.98,
                'status' => 'shipped',
                'items' => [
                    ['product_id' => $products->skip(4)->first()->id, 'quantity' => 2, 'unit_price' => 12.99],
                    ['product_id' => $products->skip(5)->first()->id, 'quantity' => 1, 'unit_price' => 34.99],
                ]
            ],
        ];

        foreach ($orders as $orderData) {
            $order = Order::create([
                'customer_id' => $orderData['customer_id'],
                'total_amount' => $orderData['total_amount'],
                'status' => $orderData['status'],
            ]);

            foreach ($orderData['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }
        }

        // Create additional random orders
        Order::factory(15)->create()->each(function ($order) use ($products) {
            $orderItems = $products->random(rand(1, 3));
            $totalAmount = 0;

            foreach ($orderItems as $product) {
                $quantity = rand(1, 3);
                $unitPrice = $product->price;
                $totalAmount += $quantity * $unitPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                ]);
            }

            $order->update(['total_amount' => $totalAmount]);
        });
    }
}
