<?php

namespace App\Services\Api\Author;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class getAllChapterOfAuthorService extends BaseService
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

            return $this->authorRepository->getChaptersPosted($author->id);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
