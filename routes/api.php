<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Author\AuthorController;
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
    Route::get('', [ServicePackageController::class, 'getData']);
    Route::post('', [ServicePackageController::class, 'create']);
    Route::get('data-popular', [ServicePackageController::class, 'getDataPopular']);
});

Route::group(['prefix' => 'user-service-packages'], function () {
    Route::post('', [ServicePackageController::class, 'registerServicePackage']);
});

Route::group(['prefix' => 'authors'], function () {
    Route::get('/book-posted', [AuthorController::class, 'bookPosted']);
    Route::get('/chapter-posted', [AuthorController::class, 'chapterPosted']);
});
