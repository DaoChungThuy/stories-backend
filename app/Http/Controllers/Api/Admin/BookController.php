<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\StoreBookRequest;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Api\Book\CreateBookService;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function store(StoreBookRequest $request)
    {
        $book = resolve(CreateBookService::class)->setParams($request->validated())->handle();

        if (!$book) {
            return $this->responseErrors(__('book.create_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.create_success'),
            'data' => new BookResource($book),
        ], Response::HTTP_CREATED);
    }
}
