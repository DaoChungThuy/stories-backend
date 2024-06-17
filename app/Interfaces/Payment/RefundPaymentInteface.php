<?php

namespace App\Interfaces\Payment;

interface RefundPaymentInteface
{
    public function StripeRefund($id);
}
