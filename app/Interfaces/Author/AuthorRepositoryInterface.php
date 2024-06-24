<?php

namespace App\Interfaces\Author;

use App\Interfaces\CrudRepositoryInterface;

interface AuthorRepositoryInterface extends CrudRepositoryInterface
{
    public function findAuthorByUserId($userId);

    public function getAuthorByData($colum, $data, $compare = '=');
}
