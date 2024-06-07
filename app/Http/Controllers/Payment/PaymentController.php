<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Payment\Gateway\StripePaymentService;
use App\Services\Payment\Gateway\VNPayPaymentService;
use App\Services\Payment\PaymentProcessorService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        if ($request->gateway == 'vnpay') {
            $paymentGateway = new PaymentProcessorService(new VNPayPaymentService());
        } else if ($request->gateway == 'stripe') {
            $paymentGateway = new PaymentProcessorService(new StripePaymentService());
        }

        $payment = $paymentGateway->setParams($request)->handle();

        if ($payment) {
            return $this->responseSuccess([
                'payment_url' => $payment
            ]);
        }
    }
}
