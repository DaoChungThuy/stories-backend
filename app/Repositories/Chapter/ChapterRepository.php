<?php

namespace App\Repositories\Chapter;

use App\Interfaces\Chapter\ChapterRepositoryInterface;
use App\Models\Chapter;
use App\Repositories\BaseRepository;

class ChapterRepository extends BaseRepository implements ChapterRepositoryInterface
{
    public function __construct(Chapter $chapter)
    {
        $this->model = $chapter;
    }

    public function countChaptersByBookId($bookId)
    {
        return $this->model->where('book_id', $bookId)->count();
    }

    public function getChaptersByBookId($bookId)
    {
        return $this->model->where('book_id', $bookId);
    }
}
