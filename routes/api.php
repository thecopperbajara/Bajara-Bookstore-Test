<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SubcategoryController;
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
});

Route::middleware('auth:customer')->group(function () {
    Route::get('/user/profile', [CustomerAuthController::class, 'profile']);
});

Route::middleware('auth:sanctum')->group(function () { 
    Route::get('/admin/profile', [AuthController::class, 'profile']);
    Route::post('/admin/logout', [AuthController::class, 'destroy']);
});

Route::middleware('guest')->group(function () { 
    Route::post('/admin/login', [AuthController::class, 'store']);
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
});