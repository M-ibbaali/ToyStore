<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

// Admin Login Routes (Custom Path)
Route::get('/toystore-admin', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/toystore-admin', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search/suggestions', [ShopController::class, 'suggestions'])->name('search.suggestions');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');
Route::post('/product/{id}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->middleware('auth')->name('reviews.store');

// Static Pages
Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/fetch-mini', [CartController::class, 'fetchMiniCart'])->name('cart.fetch-mini');

// Checkout Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/success/{orderId}', [CheckoutController::class, 'success'])->name('order.success');
    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::get('/favorites/count', [FavoriteController::class, 'getFavoritesCount'])->name('favorites.count');
    Route::get('/favorites/list', [FavoriteController::class, 'getFavoritesList'])->name('favorites.list');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
    Route::post('/favorites/clear', [FavoriteController::class, 'clearAll'])->name('favorites.clear');
});



// User Dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    $totalOrders = \App\Models\Order::where('user_id', $user->id)->count();
    $pendingOrders = \App\Models\Order::where('user_id', $user->id)->where('status', 'pending')->count();
    $totalSpent = \App\Models\Order::where('user_id', $user->id)->where('payment_status', 'paid')->sum('total');
    $recentOrders = \App\Models\Order::where('user_id', $user->id)->latest()->take(5)->get();

    return view('dashboard', compact('totalOrders', 'pendingOrders', 'totalSpent', 'recentOrders'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Orders
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
});

// Admin Dashboard & Management Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('toystore-admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::delete('/products/image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.image.delete');
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Users
    Route::resource('users', AdminUserController::class);

    // Notifications
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/clear-all', [AdminNotificationController::class, 'clearAll'])->name('notifications.clearAll');
    Route::delete('/notifications/{id}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');

    // Contact Messages
    Route::resource('messages', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
});

require __DIR__.'/auth.php';
