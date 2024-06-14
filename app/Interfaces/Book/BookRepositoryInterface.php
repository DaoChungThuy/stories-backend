<?php

namespace App\Interfaces\Book;

use App\Interfaces\CrudRepositoryInterface;

interface BookRepositoryInterface extends CrudRepositoryInterface
{
    public function getBooks($userId);
}
