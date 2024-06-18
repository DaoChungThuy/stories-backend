<?php

namespace App\Interfaces\Book;

use App\Interfaces\CrudRepositoryInterface;

interface BookRepositoryInterface extends CrudRepositoryInterface
{
    public function getMyBooks(int $userId);

    public function getBooks($userId);

    public function getBookByAuthor($authorId);

    public function findBookById(int $id);

    public function getReadingHistory(int $id);

    public function getTopBook($days, $limit);
}
