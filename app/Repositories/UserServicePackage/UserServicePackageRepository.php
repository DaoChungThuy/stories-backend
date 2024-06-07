<?php

namespace App\Repositories\UserServicePackage;

use App\Enums\UserServiceStatus;
use App\Interfaces\UserServicePackage\UserServicePackageRepositoryInterFace;
use App\Models\UserServicePackage;
use App\Repositories\BaseRepository;
use phpDocumentor\Reflection\Types\Boolean;

class UserServicePackageRepository extends BaseRepository implements UserServicePackageRepositoryInterFace
{
    public function __construct(UserServicePackage $servicePackage)
    {
        $this->model = $servicePackage;
    }

    /**
     * Check if the user has registered for service package
     * @param $userId
     * @param $serviceId
     * @return true|false
     */
    public function checkUserService($userId, $serviceId)
    {
        return $this->model->where('user_id', $userId)
            ->where('service_package_id', $serviceId)
            ->where('status', str(UserServiceStatus::ACTIVE))
            ->exists();
    }
}
