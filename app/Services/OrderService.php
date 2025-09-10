<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class OrderService
{
	public function getAllOrders()
	{
		$perPage = (int) request()->input('per_page', 15);
		return Order::with(['customer', 'orderItems.product'])->paginate($perPage);
	}

	public function getOrderById(int $id)
	{
		return Order::with(['customer', 'orderItems.product'])->findOrFail($id);
	}

	public function createOrder(array $data)
	{
		return DB::transaction(function () use ($data) {
			$order = Order::create([
				'customer_id' => auth()->id(),
				'total_amount' => 0,
				'status' => 'pending',
			]);

			$totalAmount = 0;
			foreach ($data['items'] as $item) {
				$product = Product::findOrFail($item['product_id']);
				$quantity = (int) $item['quantity'];
				$unitPrice = $product->price;

				$warehouse = Warehouse::firstOrCreate(['product_id' => $product->id], ['quantity' => 0]);
				if ($warehouse->quantity < $quantity) {
					throw new \Illuminate\Http\Exceptions\HttpResponseException(
						response()->json([
							'success' => false,
							'message' => 'Insufficient stock for product ID ' . $product->id,
							'available_stock' => $warehouse->quantity,
							'requested_quantity' => $quantity
						], 422)
					);
				}

				$warehouse->decrement('quantity', $quantity);

				$totalAmount += $quantity * $unitPrice;

				OrderItem::create([
					'order_id' => $order->id,
					'product_id' => $product->id,
					'quantity' => $quantity,
					'unit_price' => $unitPrice,
				]);
			}

			$order->update(['total_amount' => $totalAmount]);
			return $order->fresh(['customer', 'orderItems.product']);
		});
	}

	public function updateOrderStatus(int $id, array $data)
	{
		$order = Order::findOrFail($id);
		$order->update(['status' => $data['status']]);
		return $order->fresh(['customer', 'orderItems.product']);
	}

	public function cancelOrder(int $id): bool
	{
		$order = Order::findOrFail($id);
		$order->update(['status' => 'cancelled']);
		return (bool) $order->delete();
	}
}
