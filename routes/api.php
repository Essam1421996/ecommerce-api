<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\WarehouseController;
use Illuminate\Support\Facades\Route;


// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Products
    Route::apiResource('products', ProductController::class);
    
    // Categories
    Route::apiResource('categories', CategoryController::class)->except(['update', 'destroy']);
    Route::apiResource('categories', CategoryController::class)->only(['update', 'destroy'])->middleware('can:manage_categories');
    
    // Orders
    Route::apiResource('orders', OrderController::class);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    
    // Warehouse
    Route::apiResource('warehouse', WarehouseController::class)->only(['index', 'show']);
    Route::post('/warehouse/{product}/adjust', [WarehouseController::class, 'adjustStock'])->name('warehouse.adjust');
});