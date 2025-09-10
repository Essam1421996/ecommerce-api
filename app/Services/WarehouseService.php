<?php

namespace App\Services;

use App\Models\Warehouse;
use App\Models\StockAdjustment;

class WarehouseService
{
	public function getAllStock()
	{
		$perPage = (int) request()->input('per_page', 15);
		return Warehouse::with('product')->paginate($perPage);
	}

	public function getStockByProductId(int $productId)
	{
		return Warehouse::with('product')->where('product_id', $productId)->firstOrFail();
	}

	public function adjustStock(int $productId, int $quantity, string $reason = 'Manual adjustment')
	{
		$warehouse = Warehouse::firstOrCreate(['product_id' => $productId], ['quantity' => 0]);
		$warehouse->quantity += $quantity;
		$warehouse->save();

		StockAdjustment::create([
			'product_id' => $productId,
			'quantity' => $quantity,
			'reason' => $reason,
			'adjusted_by' => auth()->id(),
		]);

		return $warehouse->fresh('product');
	}
}
