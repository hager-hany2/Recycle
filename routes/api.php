<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryControllerResource;
use App\Http\Controllers\FilterCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPointcontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportOrdercontroller;
use App\Http\Controllers\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return Auth::user();
});


Route::group(['middleware' => 'ChangeLang'], function () {

    // Authentication Routes
    Route::prefix('auth')->group(function () {
        Route::any('register', [RegisterController::class, 'index'])->name('auth.register');
        Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->group(function () {
        //store

        //product Routes
        Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');
        //category Routes
        Route::post('/categories/store', [CategoryControllerResource::class, 'store']);
        //ProductPoint Routes
        Route::post('ProductPoint', [ProductPointcontroller::class, 'store']);
        //Report index Routes
        Route::get('/report/order', ReportOrdercontroller::class);
    });
    Route::middleware(['auth:api'])->group(function () {
        // Payment Routes
        Route::prefix('payment')->group(function () {
            Route::post('/', [PaymentController::class, 'store'])->name('payment.store');
        });
        // Order Routes
        Route::post('/order/{id}', [OrderController::class, 'store'])->name('order.store');
    });

});


// Profile Routes
Route::middleware(['auth:api'])->prefix('profile')->group(function () {
    Route::get('/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/update/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

});
// Public Routes


//search Routes
Route::get('/search', [SearchController::class, 'search'])->name('search');
// index Route
Route::get('/categories/index', [CategoryControllerResource::class, 'index']);
Route::get('/products/index', [ProductController::class, 'index'])->name('products.index');
Route::get('ProductPoint/index', [ProductPointcontroller::class, 'index']);


// Get Products Points
Route::get('/products/points/all', [ProductPointcontroller::class, 'getProductsPoints'])->name('products.points.index');




// show by id
Route::get('/categories/{id}', [CategoryControllerResource::class, 'show'])->name('categories.show');
Route::get('/categories/{id}/products', [CategoryControllerResource::class, 'showProducts'])->name('categories.products.show');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('ProductPoint/{id}', [ProductPointcontroller::class, 'show']);
//filter
Route::get('/categories/products/{category_id}', [FilterCategoryController::class, 'filterCategory'])->name('categories.products.filter');




