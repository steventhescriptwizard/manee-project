<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('web.about');
})->name('about');

Route::get('/faq', function () {
    return view('web.faq');
})->name('faq');

Route::get('/order-tracking', [App\Http\Controllers\Web\OrderTrackingController::class, 'index'])->name('order.tracking');

use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\ShopController;
use App\Http\Controllers\Web\WishlistController;

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

use App\Http\Controllers\Web\CheckoutController;

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::post('/checkout/check-discount', [CheckoutController::class, 'checkDiscount'])->name('checkout.check-discount');
Route::post('/checkout/check-discount', [CheckoutController::class, 'checkDiscount'])->name('checkout.check-discount');
    Route::get('/order/success', function () {
        if (!session('order_number')) {
            return redirect()->route('cart')->with('info', 'Silakan lakukan pemesanan terlebih dahulu.');
        }
        return view('web.order-success');
    })->name('order.success');
});

Route::post('/midtrans-callback', [App\Http\Controllers\Web\MidtransController::class, 'callback'])->name('midtrans.callback');

use App\Http\Controllers\Web\ProductController;

Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/category/{slug}', [App\Http\Controllers\Web\CategoryController::class, 'show'])->name('categories.show');

use App\Http\Controllers\Web\ReviewController;
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Web\Customer\DashboardController as CustomerDashboardController;

use App\Http\Controllers\Web\Customer\AddressController as CustomerAddressController;

Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [CustomerDashboardController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [CustomerDashboardController::class, 'showOrder'])->name('orders.show');
    
    // Address CRUD
    Route::get('/address', [CustomerAddressController::class, 'index'])->name('address');
    Route::post('/address', [CustomerAddressController::class, 'store'])->name('address.store');
    Route::put('/address/{address}', [CustomerAddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{address}', [CustomerAddressController::class, 'destroy'])->name('address.destroy');
    Route::patch('/address/{address}/set-primary', [CustomerAddressController::class, 'setPrimary'])->name('address.set-primary');
    
    Route::get('/payment', [CustomerDashboardController::class, 'payments'])->name('payment');
    
    // Notifications
    Route::get('/notifications', [App\Http\Controllers\Web\Customer\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\Web\Customer\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\Web\Customer\NotificationController::class, 'destroy'])->name('notifications.destroy');
    
    // Order Completion
    Route::post('/orders/{id}/complete', [CustomerDashboardController::class, 'completeOrder'])->name('orders.complete');
    
    // Invoice Download
    Route::get('/orders/{id}/invoice', [App\Http\Controllers\Web\InvoiceController::class, 'download'])->name('orders.invoice');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::delete('products/{product}/images/{image}', [App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('products.variants', App\Http\Controllers\Admin\ProductVariantController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('warehouses', App\Http\Controllers\Admin\WarehouseController::class);
    Route::resource('discounts', App\Http\Controllers\Admin\DiscountController::class);
    Route::resource('taxes', App\Http\Controllers\Admin\TaxController::class);
    Route::resource('reviews', App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'update', 'destroy']);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('customers', App\Http\Controllers\Admin\CustomerController::class);
    Route::resource('orders', App\Http\Controllers\Admin\OrderController::class);
    Route::get('/inventory', [App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/search', [App\Http\Controllers\Admin\SearchController::class, 'index'])->name('search');
});

