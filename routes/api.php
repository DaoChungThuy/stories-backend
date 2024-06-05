<?php

use App\Http\Controllers\Api\Genre\GenreController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::POST('payment', [PaymentController::class, 'payment']);

Route::group(['prefix' => 'genre'], function () {
    Route::post('create', [GenreController::class, 'store']);
    Route::get('list', [GenreController::class, 'index']);
    Route::put('update/{id}', [GenreController::class, 'update']);
    Route::delete('delete/{id}', [GenreController::class, 'destroy']);
});
