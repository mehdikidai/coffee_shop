<?php


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

Route::get('/', HomeController::class)->name('home')->middleware('auth');


Route::controller(UsersController::class)

    ->prefix('users')
    ->name('users.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::post('/',  'store')->name('store');
        Route::put('/{id}',  'update')->name('update');
        Route::delete('/{id}',  'destroy')->name('destroy');
        Route::get('/{id}/edit',  'edit')->name('edit');
        Route::patch('/{id}/toggle-blocked',  'toggleBlocked')->name('toggleBlocked');
    });


Route::controller(ProductControllerWeb::class)

    ->prefix('products')
    ->name('products.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::put('/{id}', 'update')->name('update');
        Route::patch('/{id}/toggle-visibility', 'toggleVisibility')->name('toggleVisibility');
    });



Route::controller(OrdersController::class)
    ->prefix('orders')
    ->name('orders.')
    ->middleware('auth')

    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });


Route::controller(CategoryController::class)
    ->prefix('categories')
    ->name('categories.')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::delete('/{category}', 'destroy')->name('destroy');
        Route::put('/{category}', 'update')->name('update');
        Route::get('/{category}/edit', 'edit')->name('edit');
    });



Route::controller(AuthController::class)->group(function () {

    Route::get('/login', 'pageLogin')->name('login')->middleware('guest');
    Route::post('/login', 'login')->name('auth.login')->middleware('guest');
    Route::post('/logout', 'logout')->name('auth.logout')->middleware('auth');
});


Route::controller(IngredientController::class)
    ->prefix('ingredients')
    ->name('ingredients.')
    ->middleware('auth')
    ->group(function () {
        route::get('/', 'index')->name('index');
        route::post('/', 'store')->name('store');
        route::get('/{ingredient}/edit', 'edit')->name('edit');
        route::delete('/{ingredient}', 'destroy')->name('destroy');
        route::put('/{ingredient}', 'update')->name('update');
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
    ->middleware('auth')
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/lang/{locale}', 'lang')->name('lang');
        Route::put('/', 'update')->name('update');

    });;
