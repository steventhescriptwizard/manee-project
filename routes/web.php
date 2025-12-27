<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('web.about');
})->name('about');

Route::get('/cart', function () {
    return view('web.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('web.checkout');
})->name('checkout');

Route::get('/order/success', function () {
    return view('web.order-success');
})->name('order.success');

use App\Http\Controllers\Web\ProductController;

Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/category/{slug}', [App\Http\Controllers\Web\CategoryController::class, 'show'])->name('categories.show');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::delete('products/{product}/images/{image}', [App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('products.variants', App\Http\Controllers\Admin\ProductVariantController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('warehouses', App\Http\Controllers\Admin\WarehouseController::class);
    Route::resource('discounts', App\Http\Controllers\Admin\DiscountController::class);
    Route::get('/inventory', [App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
});

