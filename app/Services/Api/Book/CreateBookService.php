<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use App\Traits\UploadFileTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateBookService extends BaseService
{
    use UploadFileTrait;
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            if (!empty($this->data['cover_image'])) {
                $this->data['cover_image'] = $this->uploadFile($this->data['cover_image']);
            }

            $book =  $this->bookRepository->create($this->data);

            return $book;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
