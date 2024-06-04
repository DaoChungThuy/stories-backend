<?php

namespace App\Services\User;

use App\Mail\User\UserActiveEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterUserService extends CreateUserService
{
    public function handle()
    {
        try {
            DB::beginTransaction();

            $user = parent::handle();

            $token = Str::random(32);
            Mail::to($this->data['email'])->send(new UserActiveEmail($token));
            $user = $this->userRepository->update(['verification_token' => $token], $user->id);

            DB::commit();

            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('failed send mail: ' . $th->getMessage());

            return false;
        }
    }
}
