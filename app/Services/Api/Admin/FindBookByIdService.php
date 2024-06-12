<?php

namespace App\Services\Api\Admin;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use App\Traits\UploadFileImageTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class FindBookByIdService extends BaseService
{
    use UploadFileImageTrait;

    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $book =  $this->bookRepository->find($this->data);

            return $book;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
