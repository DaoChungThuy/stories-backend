<?php

namespace App\Services\Api\UserServicePackage;

use App\Interfaces\UserServicePackage\UserServicePackageRepositoryInterFace;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RegisterPackageService extends BaseService
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
                ->checkUserService($this->data['user_id'], $this->data['service_package_id']);

            if ($existingServicePackage) {
                return response()->json([
                    'message' => __('user.service_package.register_conflict')
                ], Response::HTTP_BAD_REQUEST);
            }

            $newUserService =  $this->userServiceRepository
                ->create([...$this->data, 'start_date' => now()]);

            return response()->json([
                'data' => $newUserService,
                'message' => __('user.service_package.register_successfully')
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json([
                'message' => __('user.service_package.register_error')
            ], Response::HTTP_FORBIDDEN);
        }
    }
}