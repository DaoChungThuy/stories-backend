<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ServicePackage\ServicePackageController;
use App\Http\Controllers\Payment\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
    });
});

Route::group(['prefix' => 'service-package'], function () {
    Route::get('data', [ServicePackageController::class, 'getData']);
    Route::post('create', [ServicePackageController::class, 'create']);
});

Route::group(['prefix' => 'user-service-packages'], function () {
    Route::post('create', [ServicePackageController::class, 'registerServicePackage']);
});
