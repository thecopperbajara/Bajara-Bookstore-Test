<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubcategoryController;
use App\Http\Controllers\Backend\UsersController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('guest:customer')->group(function () {
    Route::post('/user/login', [CustomerAuthController::class, 'store']);

    Route::get('/user/category', [HomeController::class, 'fetchCategory']);
    Route::get('/user/products', [HomeController::class, 'fetchProducts']);
    Route::get('/user/authors', [AuthController::class, 'fetchAuthors']);

    Route::get('/user/productById', [HomeController::class, 'productById']);
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/user/profile', [CustomerAuthController::class, 'profile']);
});

Route::middleware('auth:sanctum')->group(function () { 
    Route::get('/admin/profile', [AuthController::class, 'profile']);
    Route::get('/admin/logout', [AuthController::class, 'destroy']);

    Route::post('/user/addFavorite', [HomeController::class, 'markAsFavorite']);
    Route::post('/user/removeFromFavorites', [HomeController::class, 'removeFromFavorites']);
    Route::get('/user/isInWishlist/{bookId}', [HomeController::class, 'isInWishlist']);

});

Route::middleware('guest')->group(function () { 
    Route::post('/admin/login', [AuthController::class, 'store']);
    Route::post('/user/register', [HomeController::class, 'register']);
});

Route::group(['prefix'=>'admin', 'middleware'=> 'auth:sanctum'], function(){
    Route::resource('/category', CategoryController::class);
    Route::post('/category/{category}', [CategoryController::class, 'update']);

    Route::resource('/subcategory', SubcategoryController::class);
    Route::post('/subcategory/{subcategory}', [SubcategoryController::class, 'update']);
    Route::get('/categoryWiseSubcategory/{id}', [SubcategoryController::class, 'categoryIdWiseSubcategory']);

    Route::resource('/products', ProductController::class);
    Route::post('/products/{product}', [ProductController::class, 'update']);
    Route::get('/authors', [AuthController::class, 'fetchAuthors']);

    Route::resource('/users', UsersController::class);
    Route::post('/users/{user}', [UsersController::class, 'update']);
    Route::get('/fetchRoles', [UsersController::class, 'fetchRoles']);
});