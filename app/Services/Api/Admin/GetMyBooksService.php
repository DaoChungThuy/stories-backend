<?php

namespace App\Services\Api\Admin;

use App\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetMyBooksService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            $book = $this->userRepository->getMyBooks(auth()->user()->id);

            return $book;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
