<?php

namespace App\Http\Controllers\Payment;

use App\Enums\PaymentGetway;
use App\Http\Controllers\Controller;
use App\Services\Payment\Gateway\StripePaymentService;
use App\Services\Payment\Gateway\VNPayPaymentService;
use App\Services\Payment\PaymentProcessorService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        if ($request->gateway == PaymentGetway::ATM) {
            $paymentGateway = new PaymentProcessorService(new VNPayPaymentService());
        } else if ($request->gateway == PaymentGetway::STRIPE) {
            $paymentGateway = new PaymentProcessorService(new StripePaymentService());
        }

        $payment = $paymentGateway->setParams($request)->handle();

        if ($payment->getStatusCode() == Response::HTTP_OK) {
            return $this->responseSuccess([
                'payment_url' => $payment->getData()->payment_url
            ]);
        }

        return $this->responseErrors($payment->getData()->message, $payment->getStatusCode());
    }
}
