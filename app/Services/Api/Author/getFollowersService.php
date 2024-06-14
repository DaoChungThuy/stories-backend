<?php

namespace App\Services\Api\Author;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class getFollowersService extends BaseService
{
    protected $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle()
    {
        try {
            $author = $this->authorRepository->findAuthorByUserId(auth()->user()->id);

            return $this->authorRepository->getFollowers($author->id);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
