<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crawl\CrawlStoryController;

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for the admin section of your
| application. These routes are loaded by the RouteServiceProvider within
| a group which is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->group(function () {
    Route::post('/crawl_data', [CrawlStoryController::class, 'crawl']);
});
