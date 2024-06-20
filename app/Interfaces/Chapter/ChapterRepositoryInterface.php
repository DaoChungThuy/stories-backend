<?php

namespace App\Interfaces\Chapter;

use App\Interfaces\CrudRepositoryInterface;

interface ChapterRepositoryInterface extends CrudRepositoryInterface
{
    public function countChaptersByBookId($bookId);

    public function getChaptersByBookId($bookId);
}
