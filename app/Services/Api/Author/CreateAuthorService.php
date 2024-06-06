<?php

namespace App\Services\Api\Author;

use App\Interfaces\Author\AuthorRepositoryInterface;
use App\Services\BaseService;
use App\Traits\UploadFileTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateAuthorService extends BaseService
{
    use UploadFileTrait;
    protected $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    public function handle()
    {
        try {
            if (!empty($this->data['avatar'])) {
                $this->data['avatar'] = $this->uploadFile($this->data['avatar']);
            }

            $author =  $this->authorRepository->create($this->data);

            return $author;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
