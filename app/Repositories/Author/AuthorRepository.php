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

    public function getAuthorByData($colum, $data, $compare = '=')
    {
        return $this->model->where($colum, $compare, $data);
    }

    /**
     * Find author by user id.
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAuthorByUserId($userId)
    {
        return $this->model->where('create_by_user_id', $userId)->first();
    }
}
