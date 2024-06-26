<?php

namespace App\Repositories\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\Author;
use App\Models\Book;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
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
    /**
     * Find book by id.
     * @param int $id
     * @return Book
     */
    public function findBookById($id, $limitChapter)
    {
        return $this->model->with([
            'author',
            'chapters' => function ($chapter) use ($limitChapter) {
                $chapter->orderByDESC('chapter_number')->limit($limitChapter);
            },
            'genre'
        ])->withCount('followers', 'bookLikes', 'chapters')->find($id);
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
        return $this->model->whereHas('chapters')
            ->with('author')->orderByDesc('updated_at');
    }

    public function getBookByChapterId($id_chapter)
    {
        return $this->model->whereHas(
            'chapters',
            fn ($query) => $query->where('id', $id_chapter)
        )->first();
    }

    public function getBookByChapter($chapterId)
    {
        return $this->model->whereHas('chapters', function ($chapter) use ($chapterId) {
            $chapter->where('id', $chapterId);
        })->first();
    }
}
