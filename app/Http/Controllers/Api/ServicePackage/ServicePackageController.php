<?php

namespace App\Http\Controllers\Api\ServicePackage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServicePackage\CreateServicePackageRequest;
use App\Http\Requests\Api\ServicePackage\RegisterUserServiceRequest;
use App\Services\Api\ServicePackage\CreateServicePackageService;
use App\Services\Api\ServicePackage\GetServicePackageListPopularService;
use App\Services\Api\ServicePackage\GetServicePackageService;
use App\Services\Api\UserServicePackage\RegisterPackageService;
use Symfony\Component\HttpFoundation\Response;

class ServicePackageController extends Controller
{
    const LIMIT_SERVICE_POPULAR = 5;

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

        return $this->responseErrors(__('servicePackage.not_found'));
    }

    /**
     * create service package
     * @param CreateServicePackageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateServicePackageRequest $request)
    {
        $servicePackage = resolve(CreateServicePackageService::class)
            ->setParams($request->validated())
            ->handle();

        if ($servicePackage) {
            return $this->responseSuccess([
                'message' => __('servicePackage.create_success'),
                'data' => $servicePackage
            ]);
        }

        return $this->responseErrors(__('servicePackage.create_fail'));
    }

    /**
     * register service package for user
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerServicePackage(RegisterUserServiceRequest $request)
    {
        $userService = resolve(RegisterPackageService::class)->setParams($request->validated())->handle();

        if ($userService->getStatusCode() !== Response::HTTP_OK) {
            return $this->responseErrors($userService->getData()->message, $userService->getStatusCode());
        }

        return $this->responseSuccess([
            'data' => $userService->getData()->data,
            'message' => $userService->getData()->message
        ]);
    }

    /**
     * fetch service package list popular with limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataPopular()
    {
        $servicePackage = resolve(GetServicePackageListPopularService::class)->setParams(self::LIMIT_SERVICE_POPULAR)->handle();

        if ($servicePackage) {
            return $this->responseSuccess([
                'data' => $servicePackage
            ]);
        }

        return $this->responseErrors(__('servicePackage.not_found'));
    }
}
