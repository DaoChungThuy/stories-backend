<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Generate a JSON response for error messages.
     *
     * @param string
     * @param int
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseErrors($message = '', $statusCode = Response::HTTP_FORBIDDEN)
    {
        return response()->json([
            'code' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }

    /**
     * Generate a JSON response for success messages.
     *
     * @param string
     * @param int
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess($data, $statusCode = Response::HTTP_OK)
    {
        return response()->json(
            array_merge(['code' => $statusCode], $data),
            $statusCode
        );
    }
}
