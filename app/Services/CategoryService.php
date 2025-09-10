<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
	public function getAllCategories()
	{
		$perPage = (int) request()->input('per_page', 15);
		return Category::paginate($perPage);
	}

	public function getCategoryById(int $id)
	{
		return Category::findOrFail($id);
	}

	public function createCategory(array $data)
	{
		return Category::create($data);
	}

	public function updateCategory(int $id, array $data)
	{
		$category = Category::findOrFail($id);
		$category->update($data);
		return $category;
	}

	public function deleteCategory(int $id): bool
	{
		$category = Category::findOrFail($id);
		return (bool) $category->delete();
	}
}
