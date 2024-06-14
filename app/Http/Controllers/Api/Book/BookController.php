<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Book\CreateBookRequest;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Api\Book\CreateBookService;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function store(CreateBookRequest $createBookRequest)
    {
        $book = resolve(CreateBookService::class)->setParams($createBookRequest->validated())->handle();

        if (!$book) {
            return $this->responseErrors(__('book.create_falsed'), Response::HTTP_BAD_REQUEST);
        }

        return $this->responseSuccess([
            'message' =>  __('book.create_success'),
            'data' => new BookResource($book),
        ]);
    }
}
