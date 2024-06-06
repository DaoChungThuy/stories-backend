<?php

namespace App\Repositories\Author;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Models\Author;
use App\Repositories\BaseRepository;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    public function __construct(Author $author)
    {
        $this->model = $author;
    }
}