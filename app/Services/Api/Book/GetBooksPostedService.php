<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class GetBooksPostedService extends BaseService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            return $this->bookRepository->getBooks(auth()->user()->id)->get();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}