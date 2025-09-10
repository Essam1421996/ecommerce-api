<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
	public function getAllProducts()
	{
		$perPage = (int) request()->input('per_page', 15);
		return Product::with(['category', 'seller'])->paginate($perPage);
	}

	public function getProductById(int $id)
	{
		return Product::with(['category', 'seller'])->findOrFail($id);
	}

	public function createProduct(array $data)
	{
		$data['seller_id'] = auth()->id();
		return Product::create($data);
	}

	public function updateProduct(int $id, array $data)
	{
		$product = Product::findOrFail($id);
		$product->update($data);
		return $product->fresh(['category', 'seller']);
	}

	public function deleteProduct(int $id): bool
	{
		$product = Product::findOrFail($id);
		return (bool) $product->delete();
	}
}
