<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TenantsController;



Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index'])->middleware('auth:sanctum');

Route::get('/categories/{categoryId}/products', [ProductController::class, 'showByCategoryId'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'store']);

Route::post('/login/qr', [AuthController::class, 'loginByQrCode']);

Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');

Route::get('/orders', [OrderController::class, 'salesToday'])->middleware('auth:sanctum');

Route::post('/tenants',[TenantsController::class,'store']);

Route::get('/orders/{id}/invoice', [OrderController::class, 'printInvoice'])->middleware('auth:sanctum');

