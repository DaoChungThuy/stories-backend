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
}
