<?php

namespace App\Interfaces\Author;

use App\Interfaces\CrudRepositoryInterface;

interface AuthorRepositoryInterface extends CrudRepositoryInterface
{
    public function getBooks($authorId);

    public function findAuthorByUserId($userId);

    public function getChaptersPosted($authorId);

    public function getFollowers($authorId);
}
