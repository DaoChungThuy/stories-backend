<?php

namespace App\Interfaces\Book;

use App\Interfaces\CrudRepositoryInterface;

interface BookRepositoryInterface extends CrudRepositoryInterface
{
    public function findBookById(int $id);

    public function getReadingHistory(int $id);
}
