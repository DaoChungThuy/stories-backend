<?php

namespace App\Repositories\ServicePackage;

use App\Interfaces\ServicePackage\ServicePackageRepositoryInterface;
use App\Models\ServicePackage;
use App\Repositories\BaseRepository;

class ServicePackageRepository extends BaseRepository implements ServicePackageRepositoryInterface
{
    public function __construct(ServicePackage $servicePackage)
    {
       $this->model = $servicePackage;
    }
}
