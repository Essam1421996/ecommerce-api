<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->authorizeResource(Product::class, 'product');
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->getAllProducts();

        return response()->json([
            'success' => true,
            'message' => 'product list',
            'data' => ProductResource::collection($products->getCollection()),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
        ]);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->productService->createProduct($request->validated());
        return response()->json(new ProductResource($product), 201);
    }

    public function show($id): JsonResponse
    {
        $product = $this->productService->getProductById($id);
        return response()->json(new ProductResource($product));
    }

    public function update(ProductRequest $request, $id): JsonResponse
    {
        $product = $this->productService->updateProduct($id, $request->validated());
        return response()->json(new ProductResource($product));
    }

    public function destroy($id): JsonResponse
    {
        $this->productService->deleteProduct($id);
        return response()->json(null, 204);
    }
}