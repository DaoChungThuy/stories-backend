<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Services\Follow\FolowBookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function followBook(Request $request)
    {
        $book = resolve(FolowBookService::class)->setParams($request->validate([
            'book_id' => 'required|integer|exists:books,id',
        ]))->handle();

        if ($book) {
            return $this->responseSuccess([
                'message' => __('book.follow_success'),
            ]);
        }

        return $this->responseErrors(__('book.follow_failed'));
    }
}
