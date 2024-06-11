<?php

namespace App\Services\Api\Admin;

use App\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetListAuthorsService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            $this->data['id'] = auth()->user()->id;
            $authors =  $this->userRepository->getListAuthors($this->data['id']);

            return $authors;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
