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

    /**
     * get service package popular with limit
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getServicePackagePopular($limit)
    {
        return $this->model
            ->withCount('userServicePackages')
            ->orderByDESC('user_service_packages_count')
            ->limit($limit)
            ->get();
    }
}
