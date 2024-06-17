<?php

namespace App\Services\Api\Admin\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class DeleteBookService extends BaseService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $this->bookRepository->delete($this->data);

            return true;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
