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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/send-email', [AuthController::class, 'sendEmail']);
Route::get('/user/vertify/{token}', [AuthController::class, 'vertifyEmail'])->name('vertifyEmailForUser');

Route::group(['prefix' => 'service-package'], function () {
    Route::get('data-popular', [ServicePackageController::class, 'getDataPopular']);
    Route::get('/{id}', [ServicePackageController::class, 'findPackage']);
    Route::get('', [ServicePackageController::class, 'getData']);
    Route::post('', [ServicePackageController::class, 'create']);
});

Route::group(['prefix' => 'user-service-packages'], function () {
    Route::post('', [ServicePackageController::class, 'registerServicePackage']);
});

Route::group(['prefix' => 'payment'], function () {
    Route::post('', [PaymentController::class, 'payment']);
});
