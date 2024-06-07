<?php

namespace App\Services\Api\ServicePackage;

use App\Interfaces\ServicePackage\ServicePackageRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class GetServicePackageService extends BaseService
{
    protected $servicePackageRepository;

    public function __construct(ServicePackageRepositoryInterface $servicePackageRepository)
    {
        $this->servicePackageRepository = $servicePackageRepository;
    }

    public function handle()
    {
        try {
            return $this->servicePackageRepository->all();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
