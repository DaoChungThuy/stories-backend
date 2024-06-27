<?php

namespace App\Http\Controllers\Api\ServicePackage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServicePackage\CreateServicePackageRequest;
use App\Http\Requests\Api\ServicePackage\RegisterUserServiceRequest;
use App\Models\ServicePackage;
use App\Services\Api\ServicePackage\CreateServicePackageService;
use App\Services\Api\ServicePackage\FindServicePackageById;
use App\Services\Api\ServicePackage\GetServicePackageListPopularService;
use App\Services\Api\ServicePackage\GetServicePackageService;
use App\Services\Api\UserServicePackage\RegisterPackageService;
use App\Services\Payment\Refund\StripeRefundService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ServicePackageController extends Controller
{
    const LIMIT_SERVICE_POPULAR = 5;

    /**
     * fetch service package by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function findPackage($id)
    {
        $servicePackage = resolve(FindServicePackageById::class)->setParams($id)->handle();

        if ($servicePackage) {
            return $this->responseSuccess([
                'data' => $servicePackage
            ]);
        }

        return $this->responseErrors(__('servicePackage.not_found'));
    }

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
     * @param int $serviceId
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerServicePackage($sessionId, $serviceId, $userId)
    {
        $userService = resolve(RegisterPackageService::class)->setParams([
            'service_id' => $serviceId,
            'user_id' => $userId
        ])->handle();

        if ($userService->getStatusCode() !== Response::HTTP_OK) {
            // resolve(StripeRefundService::class)->StripeRefund($sessionId);
            Log::error($userService->getData()->message);

            return redirect(env('RETURN_URL_ERROR')  . '&message=' . $userService->getData()->message);
        }

        $service = ServicePackage::find($serviceId);

        return redirect(env('RETURN_URL_SUCCESS') . '&role=' . $service->type);
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
