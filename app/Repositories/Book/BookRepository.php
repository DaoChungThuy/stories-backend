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

    /**
     * Get books by user id
     * @param $userId
     */
    public function getBooks($userId)
    {
        return $this->model->whereHas('author', function ($author) use ($userId) {
            $author->where('create_by_user_id', $userId);
        })->with('followers', 'chapters', 'bookLikes');
    }
}
