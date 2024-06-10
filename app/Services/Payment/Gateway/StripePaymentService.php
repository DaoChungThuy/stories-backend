<?php

namespace App\Services\Payment\Gateway;

use App\Interfaces\Payment\PaymentProcessInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripePaymentService implements PaymentProcessInterface
{
    public function payment($request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'vnd',
                        'product_data' => [
                            'name' => $request->service['service_package_name'],
                        ],
                        'unit_amount' => $request->service['price'],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => env('RETURN_URL_SUCCESS'),
                'cancel_url' => env('RETURN_URL_ERROR'),
            ]);

            return $session->url;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
