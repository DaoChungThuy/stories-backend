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

    public function getMyBooks($userId)
    {
        return $this->model->whereHas('author', function ($author) use ($userId) {
            $author->where('create_by_user_id', $userId);
        })->orderByDesc('created_at');
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

    public function getBookByAuthor($authorId)
    {
        return $this->model->where('author_id', $authorId);
    }

    public function getBookByChapter($chapterId)
    {
        return $this->model->whereHas('chapters', function ($chapter) use ($chapterId) {
            $chapter->where('id', $chapterId);
        })->first();
    }
}
