<?php

namespace App\Http\Controllers\Api\ServicePackage;

use App\Http\Controllers\Controller;
use App\Services\Api\ServicePackage\GetServicePackageService;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    /**
     * fetch service package list
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $servicePackage = resolve(GetServicePackageService::class)->handle();

        if ($servicePackage) {
            return $this->responseSuccess([
                'data' => $servicePackage
            ]);
        }

        return $this->responseErrors();
    }
}
