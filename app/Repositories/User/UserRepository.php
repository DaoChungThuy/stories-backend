<?php

namespace App\Repositories\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * vertify email for user
     * @param string $token
     * @return bool
     */
    public function vertifyEmail($token)
    {
        return $this->model->where('verification_token', $token)
            ->update([
                'verification_token' => null,
                'email_verified_at' => now()
            ]);
    }

    public function getListAuthors($id)
    {
        return $this->model->findOrFail($id)->authors()->get();
    }

    public function getMyBooks($id)
    {
        return $this->model->findOrFail($id)->authors()
            ->join('books', 'authors.id', '=', 'books.author_id')
            ->select('books.*')
            ->orderByDesc('created_at');
    }
}
