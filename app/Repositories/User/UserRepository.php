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
    public function verifyEmail($token)
    {
        return $this->model->where('verification_token', $token)
            ->update([
                'verification_token' => null,
                'email_verified_at' => now()
            ]);
    }
}
