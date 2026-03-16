<?php

use App\Http\Controllers\GatewayController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Middleware\SessionMiddleware;
use \App\Http\Middleware\AuthenticateUser;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\TransactionController;
use \App\Http\Controllers\ClientController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => SessionMiddleware::class], function () {
    Route::apiResource('user', UserController::class);

    Route::apiResource('product', ProductController::class);

    Route::apiResource('transactions', TransactionController::class);
    Route::post('/transactions/{transactionId}/charge-back', [TransactionController::class, 'chargeBack']);

    Route::apiResource('clients', ClientController::class);

    Route::put('/gateway-status', [GatewayController::class, 'gatewayStatus']);
});


