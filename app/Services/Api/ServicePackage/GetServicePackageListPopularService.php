<?php

namespace App\Services\Api\ServicePackage;

use App\Interfaces\ServicePackage\ServicePackageRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class GetServicePackageListPopularService extends BaseService
{
    protected $servicePackage;

    public function __construct(ServicePackageRepositoryInterface $servicePackageRepositoryInterface)
    {
        $this->servicePackage = $servicePackageRepositoryInterface;
    }

    public function handle()
    {
        try {
            return $this->servicePackage->getServicePackagePopular($this->data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
