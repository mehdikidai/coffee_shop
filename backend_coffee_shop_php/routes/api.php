<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


Route::get('/categories', [CategoryController::class, 'index'])->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index'])->middleware('auth:sanctum');

Route::get('/categories/{categoryId}/products', [ProductController::class, 'showByCategoryId'])->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');

Route::get('/orders', [OrderController::class, 'salesToday']);
