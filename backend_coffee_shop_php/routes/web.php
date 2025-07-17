<?php

use App\Enum\UserRole;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\SheetController;
use App\Http\Controllers\web\UsersController;
use App\Http\Controllers\web\OrdersController;
use App\Http\Controllers\web\ReviewController;
use App\Http\Controllers\web\SettingController;
use App\Http\Controllers\web\CategoryController;
use App\Http\Controllers\web\StockLogController;
use App\Http\Controllers\web\IngredientController;
use App\Http\Controllers\web\UserActivityLogController;
use App\Http\Controllers\web\ProductsController as ProductControllerWeb;

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
        Route::get('/{id}',  'show')->middleware("role:$admin")->name('show');
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
        Route::get('/{id}', 'show')->middleware("role:$admin")->name('show');
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



Route::get('/orders/{id}/invoice', [OrdersController::class, 'printInvoice'])
    ->name('orders.invoice')
    ->middleware(["auth", "role:$admin"]);

// Route::get('/orders/{id}/invoice', [OrdersController::class, 'printInvoiceTest'])
//     ->name('orders.invoice')
//     ->middleware(["auth","role:$admin"]);



Route::controller(CategoryController::class)
    ->prefix('categories')
    ->name('categories.')
    ->middleware(["auth"])
    ->group(function () use ($admin) {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->middleware("role:$admin")->name('store');
        Route::delete('/{category}', 'destroy')->middleware("role:$admin")->name('destroy');
        Route::put('/{category}', 'update')->middleware("role:$admin")->name('update');
        Route::get('/{category}', 'show')->middleware("role:$admin")->name('show');
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
        route::get('/{ingredient}', 'show')->middleware("role:$admin")->name('show');
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
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

Route::controller(SettingController::class)
    ->prefix('setting')
    ->name('setting.')
    ->middleware(["auth"])
    ->group(function () use ($admin) {
        Route::get('/', 'index')->name('index');
        Route::get('/lang/{locale}', 'lang')->withoutMiddleware('auth')->name('lang');
        Route::put('/', 'update')->middleware("role:$admin")->name('update');
    });;


Route::controller(ReviewController::class)
    ->prefix('reviews')
    ->name('reviews.')
    ->group(function () use ($admin) {
        Route::get('/', 'index')->middleware(["auth", "role:$admin"])->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{review}', 'show')->middleware(["auth", "role:$admin"])->name('show');
        Route::delete('/{review}', 'destroy')->middleware(["auth", "role:$admin"])->name('destroy');
        Route::patch('/{id}/approve', 'approve')->middleware(["auth", "role:$admin"])->name('approve');
    });


Route::controller(SheetController::class)
    ->prefix('sheet')
    ->name('sheet.')
    ->group(function () use ($admin): void {
        Route::get('/', 'index')->middleware(["auth", "role:$admin"])->name('index');
    });


Route::controller(UserActivityLogController::class)
    ->prefix('user-activity-logs')
    ->name('user-activity-logs.')
    ->group(function ()  use ($admin): void {
        Route::get('/', 'index')->middleware(["auth", "role:$admin"])->name('index');
    });
