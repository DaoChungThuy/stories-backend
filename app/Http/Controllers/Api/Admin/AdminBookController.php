<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crawl\CrawlBookRequest;
use App\Http\Requests\Api\Book\UpdateBookRequest;
use App\Http\Resources\Api\Book\BasicBookResource;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Api\Admin\Book\DeleteBookService;
use App\Services\Api\Admin\Book\FindBookByIdService;
use App\Services\Api\Admin\Book\GetMyBooksService;
use App\Services\Api\Admin\Book\UpdateBookService;
use App\Services\Crawl\CrawlDataService;
use Illuminate\Http\Request;

class AdminBookController extends Controller
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

    public function deleteBook($book_id)
    {
        $book = resolve(DeleteBookService::class)->setParams($book_id)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.delete_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.delete_success'),
        ]);
    }

    public function updateBook(UpdateBookRequest $updateBookRequest, $book_id)
    {
        $data = array_merge($updateBookRequest->validated(), ['book_id' => $book_id]);
        $book = resolve(UpdateBookService::class)->setParams($data)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.update_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.update_success'),
            'data' => new BookResource($book),
        ]);
    }

    public function getBook($book_id)
    {
        $book = resolve(FindBookByIdService::class)->setParams($book_id)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.get_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.get_success'),
            'data' => new BasicBookResource($book),
        ]);
    }
}
