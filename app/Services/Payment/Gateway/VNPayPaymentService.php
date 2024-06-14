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

            $vnpTmnCode = env('VNPAY_TMN_CODE');
            $vnpHashSecret = env('VNPAY_SECRET_KEY');
            $vnpUrl = env('VNPAY_URL');

            $vnpTxnRef = uniqid();
            $vnpReturnurl = route('registerService', [
                'serviceId' => $request->service['id'],
                'userId' => auth()->user()->id,
                'sessionId' => $vnpTxnRef,
            ]);
            $vnpAmount = $request->service['price'];
            $vnpLocale = 'vn';
            $vnpBankCode = $request->bankCode ?? 'VNBANK';
            $vnpIpAddr = $request->ip();

            $startTime = date('YmdHis');
            $expire = date('YmdHis', strtotime('+15 minutes'));

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnpTmnCode,
                "vnp_Amount" => $vnpAmount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => $startTime,
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnpIpAddr,
                "vnp_Locale" => $vnpLocale,
                "vnp_OrderInfo" => "Thanh toan GD:" . $vnpTxnRef,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => $vnpReturnurl,
                "vnp_TxnRef" => $vnpTxnRef,
                "vnp_ExpireDate" => $expire,
                "vnp_BankCode" => $vnpBankCode,
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

            $vnpUrl = $vnpUrl . "?" . $query;

            if (isset($vnpHashSecret)) {
                $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnpHashSecret);
                $vnpUrl .= '&vnp_SecureHashType=SHA512&vnp_SecureHash=' . $vnpSecureHash;
            }

            return $vnpUrl;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
