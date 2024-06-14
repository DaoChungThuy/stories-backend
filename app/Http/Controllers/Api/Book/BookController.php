<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Api\Book\GetBookByAuthorService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getBookByAuthor(Request $request, $authorId)
    {
        $books = resolve(GetBookByAuthorService::class)->setParams($authorId)->handle();

        if (!$books) {
            return $this->responseErrors(__('author.register_failed'));
        }

        return $this->responseSuccess([
            'message' => __('author.register_success'),
            'data' => BookResource::apiPaginate($books, $request),
        ]);
    }
}
