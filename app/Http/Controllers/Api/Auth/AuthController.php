<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserRegisterRequest;
use App\Services\Auth\VertifyEmailUserService;
use App\Services\Email\SendEmailService;
use App\Services\User\RegisterUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Services\Auth\LogoutService;

class AuthController extends Controller
{
    /**
     * sign up account for user
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request)
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
            return redirect(env('VUE_URL_LOGIN'));
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

    /**
     * Get a JWT via given credentials.
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth()->attempt($credentials)) {
            return $this->responseErrors(__('auth.unauthorized'), Response::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();

        if ($user->email_verified_at == null) {
            return $this->responseErrors(__('auth.email_not_verified'), Response::HTTP_UNAUTHORIZED);
        }

        if ($user->deleted_at != null) {
            return $this->responseErrors(__('auth.unauthorized'), Response::HTTP_UNAUTHORIZED);
        }

        return $this->responseSuccess([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    /**
     * Logout the user and invalidate the current JWT token.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $result = resolve(LogoutService::class)->handle();

            if ($result) {
                return $this->responseSuccess([
                    'message' => __('auth.logout_success'),
                ], Response::HTTP_OK);
            }

            return $this->responseErrors(__('auth.logout_fail'), Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return $this->responseErrors(__('messages.error_server'));
        }
    }
}
