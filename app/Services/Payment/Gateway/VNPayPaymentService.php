<?php

namespace App\Services\Payment\Gateway;

use App\Interfaces\Payment\PaymentProcessInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class VNPayPaymentService implements PaymentProcessInterface
{
    public function payment($request)
    {
        try {
            date_default_timezone_set('Asia/Ho_Chi_Minh');

            $vnp_TmnCode = env('VNPAY_TMN_CODE');
            $vnp_HashSecret = env('VNPAY_SECRET_KEY');
            $vnp_Url = env('VNPAY_URL');
            $vnp_Returnurl = env('RETURN_URL_SUCCESS');
            $vnp_TxnRef = uniqid();
            $vnp_Amount = $request->amount;
            $vnp_Locale = 'vn';
            $vnp_BankCode = $request->bankCode ?? 'VNBANK';
            $vnp_IpAddr = $request->ip();

            $startTime = date('YmdHis');
            $expire = date('YmdHis', strtotime('+15 minutes'));

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => $startTime,
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => $expire,
                "vnp_BankCode" => $vnp_BankCode,
            );

            ksort($inputData);
            $query = "";
            $hashdata = "";

            foreach ($inputData as $key => $value) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $hashdata = ltrim($hashdata, '&');
            $query = rtrim($query, '&');

            $vnp_Url = $vnp_Url . "?" . $query;

            if (isset($vnp_HashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
                $vnp_Url .= '&vnp_SecureHashType=SHA512&vnp_SecureHash=' . $vnpSecureHash;
            }

            return $vnp_Url;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
