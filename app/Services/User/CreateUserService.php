<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateUserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            if (isset($this->data['avatar'])) {
                $avatar = $this->data['avatar']->store('public/profile');
                $imageUrl = str_replace('public/', 'storage/', $avatar);
                $this->data['avatar'] = $imageUrl;
            }

            return $this->userRepository->create($this->data);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
