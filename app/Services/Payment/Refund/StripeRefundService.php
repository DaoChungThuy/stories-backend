<?php

namespace App\Services\Payment\Refund;

use App\Interfaces\Payment\RefundPaymentInteface;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Refund;
use Stripe\Stripe;

class StripeRefundService implements RefundPaymentInteface
{
    /**
     * refund money from stripe for user when erroer service
     * @param $id
     * @return bool
     */
    public function StripeRefund($id)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $session = Session::retrieve($id);
            $paymentIntentId = $session->payment_intent;
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            $chargeId = $paymentIntent->latest_charge;
            Refund::create([
                'charge' => $chargeId,
            ]);

            return true;
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
