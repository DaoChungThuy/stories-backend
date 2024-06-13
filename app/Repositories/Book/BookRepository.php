<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\Author;
use App\Models\Book;
use App\Repositories\BaseRepository;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    public function getBooks($userId)
    {
        return Author::where('create_by_user_id', $userId)->with('books.chapters');
        // return $this->model->with('author');
        // return $this->model
        //     ->join('authors', 'authors.id', '=', 'books.author_id')
        //     ->where('authors.create_by_user_id', $userId)
        //     ->select('books.*');
    }
}
