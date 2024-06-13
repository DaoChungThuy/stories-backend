<?php

use App\Http\Controllers\Api\Admin\AuthorManagement\AdminAuthorController;
use App\Http\Controllers\Api\Admin\BookManagement\AdminBookController;
use App\Http\Controllers\Api\Admin\GenreManagement\AdminGenreController;
use Illuminate\Support\Facades\Route;

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

Route::post('/crawl_book', [AdminBookController::class, 'crawlBooks']);
Route::delete('/delete_book/{book_id}', [AdminBookController::class, 'deleteBook']);
Route::get('/my_books', [AdminBookController::class, 'getMyBooks']);
Route::get('/book/{book_id}', [AdminBookController::class, 'getBook']);
Route::put('/update_book/{book_id}', [AdminBookController::class, 'updateBook']);

Route::get('/list_genre', [AdminGenreController::class, 'index']);

Route::get('/list_author', [AdminAuthorController::class, 'getListAuthors']);
