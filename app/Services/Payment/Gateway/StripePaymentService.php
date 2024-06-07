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
            $request->validate([
                'amount' => 'required|integer',
            ]);
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'vnd',
                        'product_data' => [
                            'name' => 'canh',
                        ],
                        'unit_amount' => 20000,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => env('RETURN_URL'),
                'cancel_url' => env('RETURN_URL'),
            ]);
            dd($session->url);
            dump('Stripe Payment');
        } catch (Exception $e) {
            Log::info($e);
            dd($e);
            return false;
        }
    }
}
