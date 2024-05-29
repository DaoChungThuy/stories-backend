<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Services\Auth\VertifyEmailUserService;
use App\Services\User\RegisterUserService;
use Illuminate\Http\Request;
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
        $user = resolve(RegisterUserService::class)->setParams($request->all())->handle();

        return $this->responseSuccess([
            'message' => __('messages.user.success_register'),
        ], Response::HTTP_CREATED);
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
            return redirect('http://localhost:8080/');
        }

        return $this->responseErrors(__('messages.error_server'));
    }
}
