<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\AdminController;


Route::get('home', [HomeController::class, 'home']);
Route::get('search/{keywords}', [HomeController::class, 'search']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::resource('products', ProductController::class,['only' => ['index','show']]);

Route::middleware('auth:sanctum')->group( function () {

    Route::resource('orders', OrderController::class,['only' => ['show','store', 'update']]);
    Route::get('/order/{id}/status/{status}',[OrderController::class,'updateStatus']);
    //customer routes
    Route::group(['prefix' => '/customer'], function() {
        Route::get('/orders',[CustomerController::class,'myOrders']);

    });



});

Route::middleware(['auth:sanctum','isAdmin'])->group( function () {



    Route::resource('products', ProductController::class,['only' => ['store','update']]);
    Route::post('storeImage', [ProductController::class,'storeImage']); 

    Route::resource('orders', OrderController::class,['only' => ['index','show','updateStatus']]);

    Route::group(['prefix' => 'admin'], function() {
        Route::get('/dashboard',[AdminController::class,'dashboard']);
        Route::get('/deliveried-orders',[AdminController::class,'deliveried_orders']);
        Route::get('/deliveried-order/{id}',[AdminController::class,'deliveried_order']);

    });
});


