<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     * @param LoginRequest $request
     * @return HttpResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth()->attempt($credentials)) {
            return $this->responseErrors(__('auth.unauthorized'), Response::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();

        if($user->email_verified_at == null) {
            return $this->responseErrors(__('auth.email_not_verified'), Response::HTTP_UNAUTHORIZED);
        }

        if($user->deleted_at != null) {
            return $this->responseErrors(__('auth.unauthorized'), Response::HTTP_UNAUTHORIZED);
        }

        return $this->responseSuccess([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
