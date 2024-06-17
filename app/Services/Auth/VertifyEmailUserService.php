<?php

namespace App\Services\Auth;

use App\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class VertifyEmailUserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            return $this->userRepository->verifyEmail($this->data);
        } catch (\Throwable $th) {
            Log::error($th);

            return false;
        }
    }
}
