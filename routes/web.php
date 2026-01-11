<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductdetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Home Route
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class,'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/login', [UserController::class,'loginPost'])->name('login.post');

Route::get('/register', [UserController::class,'register'])->name('register.form');
Route::post('/register', [UserController::class,'registerPost'])->name('register');

Route::post('/logout', [UserController::class,'logout'])->name('logout');
/*
|--------------------------------------------------------------------------
| Role-based Dashboard Routes
|--------------------------------------------------------------------------
*/
// ADMIN ROUTES
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class,'index'])->name('dashboard');
    Route::get('/orders', [AdminController::class,'orders'])->name('orders');
    Route::get('/users', [AdminController::class,'users'])->name('users');
    Route::get('/vendors', [AdminController::class,'vendors'])->name('vendors');

    // ===== CATEGORY =====
    Route::get('/add-category', [AdminController::class,'addcategory'])->name('category.add');
    Route::post('/add-category', [AdminController::class,'storeCategory'])->name('category.store');
    Route::get('/view-category', [AdminController::class,'viewcategory'])->name('category.view'); // make it consistent
    Route::get('/edit-category/{id}', [AdminController::class,'editcategory'])->name('category.edit');
    Route::post('/update-category/{id}', [AdminController::class,'updateCategory'])->name('category.update');
    Route::get('/delete-category/{id}', [AdminController::class,'deletecategory'])->name('category.delete');

    // ===== PRODUCTS =====
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');   // ✅ no "admin." prefix needed
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


     Route::get('/settings', [AdminController::class, 'settings'])->name('settings');

    // Update profile
    Route::post('/settings/profile', [AdminController::class, 'updateProfile'])->name('settings.profile');

    // Change password
    Route::post('/settings/password', [AdminController::class, 'changePassword'])->name('settings.password');

    // Update store settings
    Route::post('/settings/store', [AdminController::class, 'updateStore'])->name('settings.store');

    // Update notifications
    Route::post('/settings/notifications', [AdminController::class, 'updateNotifications'])->name('settings.notifications');

    // Update SEO & social
    Route::post('/settings/seo', [AdminController::class, 'updateSeo'])->name('settings.seo');

});







// SELLER / VENDOR ROUTES
Route::middleware(['auth', 'role:seller'])->prefix('vendor')->group(function () {
    Route::get('/dashboard', [VendorController::class,'index'])->name('seller.dashboard');
    Route::get('/add-product', [VendorController::class,'addproduct']);
    Route::get('/view-product', [VendorController::class,'viewproduct']);
    Route::get('/edit-product', [VendorController::class,'editproduct']);
    Route::get('/orders', [VendorController::class,'orders']);
    Route::get('/order-detail', [VendorController::class,'orderdetail']);
    Route::get('/users', [VendorController::class,'users']);
    Route::get('/profile', [VendorController::class,'profile']);
});

// USER ROUTES
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserController::class,'index'])->name('user.dashboard');
    Route::get('/order-history', [UserController::class,'history']);
    Route::get('/detail', [UserController::class,'detail']);
    Route::get('/settings', [UserController::class,'settings']);
});

/*
|--------------------------------------------------------------------------
| Product / Cart Routes (public)
|--------------------------------------------------------------------------
*/
Route::get('/category/{slug}', [CategoryController::class,'detail']);
Route::get('/category/electronics/{slug}', [SubcategoryController::class,'detail']);
Route::get('/category/electronics/tv/{slug}', [ProductdetailController::class,'detail']);
Route::get('/cart-list/{slug}', [CartController::class,'list']);
Route::get('/checkout/{slug}', [CheckoutController::class,'checkout']);
