<?php

namespace App\Http\Controllers\Api\ServicePackage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServicePackage\CreateServicePackageRequest;
use App\Http\Requests\Api\ServicePackage\RegisterUserServiceRequest;
use App\Services\Api\ServicePackage\CreateServicePackageService;
use App\Services\Api\ServicePackage\GetServicePackageService;
use App\Services\Api\UserServicePackage\CreateUserServicePackageService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
            ], Response::HTTP_CREATED);
        }

        return $this->responseErrors(__('servicePackage.create_fail'));
    }

    /**
     * register service package for user
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerServicePackage(RegisterUserServiceRequest $request)
    {
        $userService = resolve(CreateUserServicePackageService::class)->setParams($request->validated())->handle();

        if ($userService->getStatusCode() !== Response::HTTP_CREATED) {
            return $this->responseErrors($userService->getData()->message, $userService->getStatusCode());
        }

        return $this->responseSuccess([
            'data' => $userService->getData()->data,
            'message' => $userService->getData()->message
        ], Response::HTTP_CREATED);
    }
}
