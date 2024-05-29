<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Mail\User\UserActiveEmail;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class RegisterUserService extends CreateUserService
{
    public function handle()
    {
        try {
            DB::beginTransaction();

            $user = parent::handle();

            $email = $this->data['email'];
            $token = md5(mt_rand(10000, 99999) . time());
            Mail::to($email)->send(new UserActiveEmail($token));
            $user = $this->userRepository->update(['hash_active' => $token], $user->id);

            DB::commit();

            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('failed send mail: ' . $th->getMessage());

            return false;
        }
    }
}
