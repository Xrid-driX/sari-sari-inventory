<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\POSController;

Route::get('/', function () {
    return view('/auth/login');
});

// Protected routes (must be logged in)
Route::middleware(['auth'])->group(function () {

    // Dashboard page
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');



    // User profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/products', [InventoryController::class, 'index'])->name('products.index');
    Route::get('/products/create', [InventoryController::class, 'create'])->name('products.create');
    Route::post('/products', [InventoryController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [InventoryController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [InventoryController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [InventoryController::class, 'destroy'])->name('products.destroy');

    Route::get('/sales', [SaleController::class, 'index'])
    ->middleware(['auth'])
    ->name('sales.index');

    Route::get('/pos', [POSController::class, 'index'])
    ->name('pos');

    });




require __DIR__.'/auth.php';

