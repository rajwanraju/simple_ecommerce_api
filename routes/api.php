<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('home', [HomeController::class, 'home']);
Route::get('search/{keywords}', [HomeController::class, 'search']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

    Route::resource('products', ProductController::class);


    Route::post('storeImage', [ProductController::class,'storeImage']);   
    Route::middleware('auth:sanctum')->group( function () {

    Route::resource('orders', OrderController::class);

    Route::get('/order/{id}/status/{status}',[OrderController::class,'updateStatus']);


    //customer routes
Route::group(['prefix' => '/customer'], function() {
    Route::get('/orders',[CustomerController::class,'myOrders']);

});



});
