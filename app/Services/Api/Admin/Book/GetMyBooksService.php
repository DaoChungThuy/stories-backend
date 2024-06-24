<?php

namespace App\Services\Api\Admin\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetMyBooksService extends BaseService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $book = $this->bookRepository->getMyBooks(auth()->id());

            return $book;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
