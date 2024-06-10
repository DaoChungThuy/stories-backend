<?php

namespace App\Services\Api\UserServicePackage;

use App\Interfaces\UserServicePackage\UserServicePackageRepositoryInterFace;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CreateUserServicePackageService extends BaseService
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

            if ($existingServicePackage) {
                return response()->json([
                    'message' => __('user.service_package.register_conflict')
                ], Response::HTTP_CONFLICT);
            }

            $newUserService =  $this->userServiceRepository
                ->create([
                    'user_id' => auth()->user()->id,
                    'service_package_id' => $this->data,
                    'start_date' => now()
                ]);

            return response()->json([
                'data' => $newUserService,
                'message' => __('user.service_package.register_successfully')
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            
            return response()->json([
                'message' => __('user.service_package.register_error')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
