<?php

namespace App\Services\Payment;

use App\Interfaces\Payment\PaymentProcessInterface;
use App\Services\Api\ServicePackage\FindServicePackageById;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PaymentProcessorService extends BaseService
{
    protected $paymentGateway;

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
                $urlPayment = $this->paymentGateway->payment($this->data);

                if (!$urlPayment) return $this->errorResponse();

                return response()->json([
                    'payment_url' => $urlPayment
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
