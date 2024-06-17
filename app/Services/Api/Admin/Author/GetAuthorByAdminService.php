<?php

namespace App\Services\Api\Admin\Author;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetAuthorByAdminService extends BaseService
{
    protected $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle()
    {
        try {
            $authors =  $this->authorRepository->getAuthorByData('create_by_user_id', auth()->user()->id)->get();

            return $authors;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
