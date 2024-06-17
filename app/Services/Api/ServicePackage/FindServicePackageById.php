<?php

namespace App\Services\Api\ServicePackage;

use App\Interfaces\ServicePackage\ServicePackageRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class FindServicePackageById extends BaseService
{
    protected $servicePackageRepository;

    public function __construct(ServicePackageRepositoryInterface $servicePackageRepository)
    {
        $this->servicePackageRepository = $servicePackageRepository;
    }

    public function handle()
    {
        try {
            return $this->servicePackageRepository->find($this->data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
