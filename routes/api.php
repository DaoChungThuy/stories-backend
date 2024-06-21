<?php

use App\Http\Controllers\Api\Genre\GenreController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Book\BookController;
use App\Http\Controllers\Api\Author\AuthorController;
use App\Http\Controllers\Api\ChapterImage\ChapterImageController;
use App\Http\Controllers\Api\Chapter\ChapterController;
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
        Route::post('logout', [AuthController::class, 'logout']);
    });
    Route::post('/generate-desc', [BookController::class, 'generateBookDesc']);
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('genres', GenreController::class);
    });
});

Route::POST('payment', [PaymentController::class, 'payment']);

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

Route::middleware('checkLogin')->group(function () {
    Route::group(['prefix' => 'user-service-packages'], function () {
        Route::get('/{sessionId}/{serviceId}/{userId}', [ServicePackageController::class, 'registerServicePackage'])->name('registerService');
    });

    Route::group(['prefix' => 'authors'], function () {
        Route::get('', [AuthorController::class, 'getData']);
        Route::get('/book-posted', [AuthorController::class, 'bookPosted']);
        Route::post('register', [AuthorController::class, 'store']);
        Route::get('getBook/{authorId}', [BookController::class, 'getBookByAuthor']);
        Route::post('createBook', [BookController::class, 'store']);
        Route::put('updateBook/{bookId}', [BookController::class, 'update']);
        Route::delete('/book/{book_id}', [BookController::class, 'destroy']);
        Route::prefix('chapters')->group(function () {
            Route::get('/{bookId}', [ChapterController::class, 'index']);
            Route::post('/', [ChapterController::class, 'store']);
            Route::get('/getNumber/{bookId}', [ChapterController::class, 'countChaptersByBookId']);
        });
    });

    Route::group(['prefix' => 'payment'], function () {
        Route::post('', [PaymentController::class, 'payment']);
    });
});

Route::group(['prefix' => 'book'], function () {
    Route::get('/chapter/{chapterId}', [BookController::class, 'getBookChapters']);
    Route::get('/reading-history', [BookController::class, 'getHistory']);
    Route::get('/get-top-book/{days}', [BookController::class, 'getTopBook']);
    Route::get('/{id}/{limitChapter?}', [BookController::class, 'getData']);
});

Route::get('chapter-images/{chapter_id}', [ChapterImageController::class, 'index']);
