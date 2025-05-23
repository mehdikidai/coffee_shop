<?php

use App\Http\Controllers\web\ProductsController as ProductControllerWeb;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\UsersController;
use Illuminate\Support\Facades\Route;


Route::get('/', HomeController::class)->name('home');




Route::get('/users', [UsersController::class,'index'])->name('users');

Route::post('/users', [UsersController::class,'store'])->name('users.store');

Route::put('/users/{id}', [UsersController::class,'update'])->name('users.update');

Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');

Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');





Route::get('/products',[ProductControllerWeb::class,'index'])->name('products.index');

Route::post('/products',[ProductControllerWeb::class,'store'])->name('products.store');

Route::get('/products/{id}/edit',[ProductControllerWeb::class,'edit'])->name('products.edit');

Route::delete('/products/{id}',[ProductControllerWeb::class,'destroy'])->name('products.destroy');

Route::put('/products/{id}',[ProductControllerWeb::class,'update'])->name('products.update');

Route::patch('/products/{id}/toggle-visibility', [ProductControllerWeb::class, 'toggleVisibility'])->name('products.toggleVisibility');

