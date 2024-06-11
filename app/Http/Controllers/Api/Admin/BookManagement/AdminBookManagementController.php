<?php

namespace App\Http\Controllers\Api\Admin\BookManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crawl\CrawlBookRequest;
use App\Http\Resources\Api\Book\BasicBookResource;
use App\Http\Resources\Api\Book\BookResource;
use App\Models\Book;
use App\Services\Api\Admin\DeleteBookService;
use App\Services\Api\Admin\GetMyBooksService;
use App\Services\Crawl\CrawlDataService;
use Illuminate\Http\Request;

class AdminBookManagementController extends Controller
{
    public function crawlBooks(CrawlBookRequest $request)
    {
        $book = resolve(CrawlDataService::class)->setParams($request->validated())->handle();

        if (!$book) {
            return $this->responseErrors(__('book.create_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.create_success'),
            'data' => new BookResource($book),
        ]);
    }

    public function getMyBooks(Request $request)
    {
        $book = resolve(GetMyBooksService::class)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.get_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.get_success'),
            'data' => BasicBookResource::apiPaginate($book, $request),
        ]);
    }

    public function deleteBook($id)
    {
        $book = resolve(DeleteBookService::class)->setParams($id)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.delete_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.delete_success'),
        ]);
    }
}
