<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\Author;
use App\Models\Book;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

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

    public function sortByReads($direction)
    {
        return $this->model->select('books.*', DB::raw('COUNT(user_chapter.id) as num_reads'))
            ->join('chapters', 'chapters.book_id', '=', 'books.id')
            ->join('user_chapter', 'user_chapter.chapter_id', '=', 'chapters.id')
            ->groupBy('books.id', 'books.title', 'books.author_id', 'books.genre_id', 'books.description', 'books.status', 'books.cover_image', 'books.package_type', 'books.story_type', 'books.deleted_at', 'books.created_at', 'books.updated_at')
            ->orderBy('num_reads', $direction);
    }

    public function getInstance()
    {
        return $this->model;
    }
}
