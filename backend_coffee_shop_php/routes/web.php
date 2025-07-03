<?php

use App\Enum\UserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\UsersController;
use App\Http\Controllers\web\OrdersController;
use App\Http\Controllers\web\CategoryController;
use App\Http\Controllers\web\IngredientController;
use App\Http\Controllers\web\ProductsController as ProductControllerWeb;
use App\Http\Controllers\web\SettingController;
use App\Http\Controllers\web\StockLogController;

$admin = UserRole::ADMIN->value;
$barista = UserRole::BARISTA->value;


Route::get('/', HomeController::class)->name('home')->middleware(["auth"]);

Route::controller(UsersController::class)

    ->prefix('users')
    ->name('users.')
    ->middleware(["auth"])
    ->group(function () use ($admin) {

        Route::get('/', 'index')->name('index');
        Route::post('/',  'store')->middleware("role:$admin")->name('store');
        Route::put('/{id}',  'update')->middleware("role:$admin")->name('update');
        Route::delete('/{id}',  'destroy')->middleware("role:$admin")->name('destroy');
        Route::get('/{id}/edit',  'edit')->middleware("role:$admin")->name('edit');
        Route::patch('/{id}/toggle-blocked',  'toggleBlocked')->middleware("role:$admin")->name('toggleBlocked');
    });


Route::controller(ProductControllerWeb::class)

    ->prefix('products')
    ->name('products.')
    ->middleware(["auth"])
    ->group(function () use ($admin) {

        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->middleware("role:$admin")->name('store');
        Route::get('/{id}/edit', 'edit')->middleware("role:$admin")->name('edit');
        Route::delete('/{id}', 'destroy')->middleware("role:$admin")->name('destroy');
        Route::put('/{id}', 'update')->middleware("role:$admin")->name('update');
        Route::patch('/{id}/toggle-visibility', 'toggleVisibility')->middleware("role:$admin")->name('toggleVisibility');
    });



Route::controller(OrdersController::class)
    ->prefix('orders')
    ->name('orders.')
    ->middleware(["auth"])

    ->group(function () use ($admin) {

        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->middleware("role:$admin")->name('show');
        Route::delete('/{id}', 'destroy')->middleware("role:$admin")->name('destroy');
    });


Route::controller(CategoryController::class)
    ->prefix('categories')
    ->name('categories.')
    ->middleware(["auth"])
    ->group(function () use ($admin) {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->middleware("role:$admin")->name('store');
        Route::delete('/{category}', 'destroy')->middleware("role:$admin")->name('destroy');
        Route::put('/{category}', 'update')->middleware("role:$admin")->name('update');
        Route::get('/{category}/edit', 'edit')->middleware("role:$admin")->name('edit');
    });



Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'pageLogin')->name('login')->middleware('guest');
    Route::post('/login', 'login')->name('auth.login')->middleware('guest');
    Route::post('/logout', 'logout')->name('auth.logout')->middleware('auth');
});


Route::controller(IngredientController::class)
    ->prefix('ingredients')
    ->name('ingredients.')
    ->middleware(["auth"])
    ->group(function () use ($admin) {
        route::get('/', 'index')->name('index');
        route::post('/', 'store')->middleware("role:$admin")->name('store');
        route::get('/{ingredient}/edit', 'edit')->middleware("role:$admin")->name('edit');
        route::delete('/{ingredient}', 'destroy')->middleware("role:$admin")->name('destroy');
        route::put('/{ingredient}', 'update')->middleware("role:$admin")->name('update');
    });


Route::controller(StockLogController::class)
    ->prefix('stock')
    ->name('stock.log.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/log', 'index')->name('index');
        Route::get('/add', 'showAddToStock')->name('show.add.to.stock');
        Route::post('/', 'store')->name('store');
    });

Route::controller(SettingController::class)
    ->prefix('setting')
    ->name('setting.')
    ->middleware(["auth"])
    ->group(function () use ($admin) {
        Route::get('/', 'index')->name('index');
        Route::get('/lang/{locale}', 'lang')->name('lang');
        Route::put('/', 'update')->middleware("role:$admin")->name('update');
    });;
