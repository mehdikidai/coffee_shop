<?php

use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\ProductsController as ProductControllerWeb;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\OrdersController;
use App\Http\Controllers\web\UsersController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home')->middleware('auth');

Route::get('/users', [UsersController::class,'index'])->name('users')->middleware('auth');;

Route::post('/users', [UsersController::class,'store'])->name('users.store')->middleware('auth');;

Route::put('/users/{id}', [UsersController::class,'update'])->name('users.update')->middleware('auth');;

Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware('auth');;

Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit')->middleware('auth');;

Route::patch('/users/{id}/toggle-blocked', [UsersController::class, 'toggleBlocked'])->name('users.toggleBlocked')->middleware('auth');;

Route::get('/products',[ProductControllerWeb::class,'index'])->name('products.index')->middleware('auth');;

Route::post('/products',[ProductControllerWeb::class,'store'])->name('products.store')->middleware('auth');;

Route::get('/products/{id}/edit',[ProductControllerWeb::class,'edit'])->name('products.edit')->middleware('auth');;

Route::delete('/products/{id}',[ProductControllerWeb::class,'destroy'])->name('products.destroy')->middleware('auth');;

Route::put('/products/{id}',[ProductControllerWeb::class,'update'])->name('products.update')->middleware('auth');;

Route::patch('/products/{id}/toggle-visibility', [ProductControllerWeb::class, 'toggleVisibility'])->name('products.toggleVisibility')->middleware('auth');;

Route::get('/orders',[OrdersController::class,'index'])->name('orders.index')->middleware('auth');;

Route::get('/orders/{id}',[OrdersController::class,'show'])->name('orders.show')->middleware('auth');;

Route::delete('/orders/{id}',[OrdersController::class,'destroy'])->name('orders.destroy')->middleware('auth');;

Route::get('/login',[AuthController::class,'pageLogin'])->name('login')->middleware('guest');

Route::post('/login',[AuthController::class,'login'])->name('auth.login')->middleware('guest');

Route::post('/logout',[AuthController::class,'logout'])->name('auth.logout')->middleware('auth');
