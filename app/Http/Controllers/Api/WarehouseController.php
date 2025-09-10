<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AdjustStockRequest;
use App\Http\Resources\WarehouseResource;
use App\Services\WarehouseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;


class WarehouseController extends Controller
{
    protected $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
        $this->middleware('can:manage_warehouse');
    }

    public function index(): JsonResponse
    {
        $stock = $this->warehouseService->getAllStock();

        return response()->json([
            'success' => true,
            'message' => 'stock list',
            'data' => WarehouseResource::collection($stock->getCollection()),
            'pagination' => [
                'current_page' => $stock->currentPage(),
                'per_page' => $stock->perPage(),
                'total' => $stock->total(),
                'last_page' => $stock->lastPage(),
                'from' => $stock->firstItem(),
                'to' => $stock->lastItem(),
            ],
        ]);
    }

    public function show($productId): JsonResponse
    {
        $stock = $this->warehouseService->getStockByProductId($productId);
        return response()->json(new WarehouseResource($stock));
    }

    public function adjustStock(AdjustStockRequest $request, $productId): JsonResponse
    {
        $stock = $this->warehouseService->adjustStock(
            $productId, 
            $request->input('quantity'),
            $request->input('reason', 'Manual adjustment')
        );
        
        return response()->json(new WarehouseResource($stock));
    }
}