<?php

namespace App\Interfaces\Book;

use App\Interfaces\CrudRepositoryInterface;

interface BookRepositoryInterface extends CrudRepositoryInterface
{
    public function getMyBooks(int $userId);
    public function getBookByAuthor($authorId);
}
