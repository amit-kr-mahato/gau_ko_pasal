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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class,'index'])->name('admin.dashboard');
    Route::get('/orders', [AdminController::class,'orders'])->name('admin.orders');
    Route::get('/users', [AdminController::class,'users'])->name('admin.users');
    Route::get('/vendors', [AdminController::class,'vendors'])->name('admin.vendors');
    // Add category
    Route::get('/add-category', [AdminController::class,'addcategory'])->name('admin.category.add');
    Route::post('/add-category', [AdminController::class,'storeCategory'])->name('admin.category.store');
 // View Category
    Route::get('/view-category', [AdminController::class,'viewcategory'])->name('admin.viewcategory');

    // Edit Category
    Route::get('/edit-category/{id}', [AdminController::class,'editcategory'])->name('admin.category.edit');
    Route::post('/update-category/{id}', [AdminController::class,'updateCategory'])->name('admin.category.update');

    // Delete Category
    Route::get('/delete-category/{id}', [AdminController::class,'deletecategory'])->name('admin.category.delete');

    // Route::get('/view-category', [AdminController::class,'viewcategory'])->name('admin.category.view');
    // Route::get('/edit-category', [AdminController::class,'editcategory'])->name('admin.category.edit');
    Route::get('/order-detail', [AdminController::class,'orderdetail'])->name('admin.order.detail');
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
