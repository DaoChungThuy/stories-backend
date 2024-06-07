<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\Book;
use App\Repositories\BaseRepository;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $book)
    {
        $this->model = $book;
    }
}
