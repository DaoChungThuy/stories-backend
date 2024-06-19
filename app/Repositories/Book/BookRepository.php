<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\Author;
use App\Models\Book;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

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

    /**
     * Find book by id.
     * @param int $id
     * @return Book
     */
    public function findBookById($id)
    {
        return $this->model->with([
            'author',
            'chapters' => function ($chapter) {
                $chapter->orderByDESC('chapter_number');
            },
            'genre'
        ])->withCount('followers', 'bookLikes')->find($id);
    }

    /**
     * Get reading history.
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getReadingHistory($id)
    {
        return $this->model->whereHas('userChapters', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->with('userChapters.chapter')
            ->withCount('bookLikes');
    }

    /**
     * Get top book.
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getTopBook($days, $limit)
    {
        return $this->model->withCount([
            'bookLikes' => fn ($query) => $query->where('created_at', '>=', now()->subDays($days))
        ])->with(['chapters' => fn ($query) => $query->orderByDESC('chapter_number')])
            ->orderByDesc('book_likes_count')->limit($limit);
    }

    public function getBookList()
    {
        return $this->model->with('author')->orderByDesc('updated_at');
    }
}
