<?php

namespace App\Services\Api\UserServicePackage;

use App\Interfaces\UserServicePackage\UserServicePackageRepositoryInterFace;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckUserServicePackage extends BaseService
{
    protected $userServiceRepository;

    public function __construct(UserServicePackageRepositoryInterFace $userServiceRepository)
    {
        $this->userServiceRepository = $userServiceRepository;
    }

    public function handle()
    {
        try {
            $existingServicePackage  = $this->userServiceRepository
                ->checkUserService(auth()->user()->id, $this->data);

            if ($existingServicePackage) return true;

            return false;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
