<?php

namespace App\Services\Payment\Gateway;

use App\Interfaces\Payment\PaymentProcessInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class FincodePaymentService implements PaymentProcessInterface
{
    public function payment($request)
    {
        try {
            dump('Fincode Payment' . $request);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
