<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Models\User;
use App\Services\BaseService;
use App\Traits\UploadFileTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateUserService extends BaseService
{
    use UploadFileTrait;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            if (isset($this->data['avatar'])) {
                $this->data['avatar'] = $this->uploadFile($this->data['avatar']);
            }

            return $this->userRepository->create($this->data);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
