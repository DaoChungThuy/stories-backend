<?php

namespace App\Interfaces\UserServicePackage;

use App\Interfaces\CrudRepositoryInterface;

interface UserServicePackageRepositoryInterFace extends CrudRepositoryInterface
{
    public function checkUserService($user_id, $service_id);
}
