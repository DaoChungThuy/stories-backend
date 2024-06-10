<?php

namespace App\Services\Payment;

use App\Interfaces\Payment\PaymentProcessInterface;
use App\Services\Api\ServicePackage\FindServicePackageById;
use App\Services\Api\UserServicePackage\CreateUserServicePackageService;
use App\Services\Api\UserServicePackage\RegisterPackageService;
use App\Services\BaseService;
use App\Services\User\UpdateUserService;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PaymentProcessorService extends BaseService
{
    protected $paymentGateway;
    protected $updateUserService;

    public function __construct(PaymentProcessInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function handle()
    {
        try {
            $service = resolve(FindServicePackageById::class)->setParams($this->data['id'])->handle();

            if (!$service) return $this->errorResponse();

            if ($service) {
                $this->data['service'] = $service;
                $url_payment = $this->paymentGateway->payment($this->data);

                if ($url_payment) {
                    $userService = resolve(RegisterPackageService::class)->setParams($this->data['id'])->handle();
                    if ($userService->getStatusCode() != Response::HTTP_OK) return $userService;
                }

                return response()->json([
                    'payment_url' => $url_payment
                ], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            Log::info($e);

            return $this->errorResponse();
        }
    }

    /**
     * response error
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse()
    {
        return response()->json(['message' => __('payment.error')], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
