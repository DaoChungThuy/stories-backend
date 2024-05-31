<?php

namespace App\Services\Email;

use App\Interfaces\User\UserRepositoryInterface;
use App\Mail\User\UserActiveEmail;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            $user = $this->userRepository->findByEmail($this->data['email']);
            $token = md5(mt_rand(10000, 99999) . time());

            if ($user) {
                $this->userRepository->update(['hash_active' => $token], $user->id);

                Mail::to($this->data['email'])->send(new UserActiveEmail($token));

                return true;
            }

            return false;
        } catch (\Throwable $th) {
            Log::info($th);

            return false;
        }
    }
}
