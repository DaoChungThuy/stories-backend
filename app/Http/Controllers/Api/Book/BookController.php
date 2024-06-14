<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Book\UpdateBookRequest;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Api\Book\UpdateBookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function update(UpdateBookRequest $updateBookRequest, $bookId)
    {
        $data = array_merge($updateBookRequest->validated(), ['id' => $bookId]);
        $book = resolve(UpdateBookService::class)->setParams($data)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.update_falsed'));
        }

        return $this->responseSuccess([
            'message' =>  __('book.update_success'),
            'data' => new BookResource($book),
        ]);
    }
}
