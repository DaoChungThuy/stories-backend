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

    /**
     * Get the books for the author.
     * @param $authorId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getBooks($authorId)
    {
        return $this->model->with('books')->find($authorId)->books;
    }

    /**
     * Find author by user id
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAuthorByUserId($userId)
    {
        return $this->model->where('create_by_user_id', $userId)->first();
    }

    /**
     * Get the chapters for the author.
     * @param $authorId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChaptersPosted($authorId)
    {
        return $this->model->with('chapters')->find($authorId)->chapters;
    }
}
