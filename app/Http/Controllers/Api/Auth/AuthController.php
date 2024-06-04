<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\RegisterRequest;
use App\Services\Auth\VertifyEmailUserService;
use App\Services\Email\SendEmailService;
use App\Services\User\RegisterUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * sign up account for user
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = resolve(RegisterUserService::class)->setParams($request->validated())->handle();

            if ($user) {
                return $this->responseSuccess([
                    'message' => __('messages.user.success_register'),
                ], Response::HTTP_CREATED);
            }

            return $this->responseErrors(__('messages.user.register_error'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return $this->responseErrors(__('messages.error_server'));
        }
    }

    /**
     * vertify email
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vertifyEmail($token)
    {
        $check = resolve(VertifyEmailUserService::class)->setParams($token)->handle();

        if ($check) {
            return redirect(env('VUE_URL'));
        }

        return $this->responseErrors(__('messages.error_server'));
    }

    /**
     * send email vertify for user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        try {
            $user = resolve(SendEmailService::class)->setParams($request->all())->handle();

            if ($user) {
                return $this->responseSuccess([
                    'message' => __('messages.send_email_success'),
                ]);
            }

            return $this->responseErrors(__('messages.send_email_error'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return $this->responseErrors(__('messages.error_server'));
        }
    }
}
