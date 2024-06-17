<?php

namespace App\Services\Api\Author;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetAuthorService extends BaseService
{
    protected $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle()
    {
        try {
           return $this->authorRepository->findAuthorByUserId(auth()->id());
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
