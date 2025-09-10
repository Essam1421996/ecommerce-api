<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;


class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();

        return response()->json([
            'success' => true,
            'message' => 'order list',
            'data' => OrderResource::collection($orders->getCollection()),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'last_page' => $orders->lastPage(),
                'from' => $orders->firstItem(),
                'to' => $orders->lastItem(),
            ],
        ]);
    }

    public function store(OrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->validated());
        return response()->json(new OrderResource($order), 201);
    }

    public function show($id): JsonResponse
    {
        $order = $this->orderService->getOrderById($id);
        return response()->json(new OrderResource($order));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, $id): JsonResponse
    {
        $order = $this->orderService->updateOrderStatus($id, $request->validated());
        return response()->json(new OrderResource($order));
    }

    public function destroy($id): JsonResponse
    {
        $this->orderService->cancelOrder($id);
        return response()->json(null, 204);
    }
}