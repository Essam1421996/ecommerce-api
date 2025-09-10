<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
	public function __construct(private CategoryService $categoryService) {}

	public function index(): JsonResponse
	{
		$categories = $this->categoryService->getAllCategories();

		return response()->json([
			'success' => true,
			'message' => 'category list',
			'data' => CategoryResource::collection($categories->getCollection()),
			'pagination' => [
				'current_page' => $categories->currentPage(),
				'per_page' => $categories->perPage(),
				'total' => $categories->total(),
				'last_page' => $categories->lastPage(),
				'from' => $categories->firstItem(),
				'to' => $categories->lastItem(),
			],
		]);
	}

	public function store(CategoryRequest $request): JsonResponse
	{
		$category = $this->categoryService->createCategory($request->validated());
		return response()->json(new CategoryResource($category), 201);
	}

	public function show(int $id): JsonResponse
	{
		$category = $this->categoryService->getCategoryById($id);
		return response()->json(new CategoryResource($category));
	}

	public function update(CategoryRequest $request, int $id): JsonResponse
	{
		$category = $this->categoryService->updateCategory($id, $request->validated());
		return response()->json(new CategoryResource($category));
	}

	public function destroy(int $id): JsonResponse
	{
		$this->categoryService->deleteCategory($id);
		return response()->json(null, 204);
	}
}
