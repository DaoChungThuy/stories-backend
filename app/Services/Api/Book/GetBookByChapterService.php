<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetBookByChapterService extends BaseService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $book =  $this->bookRepository->getBookByChapter($this->data);

            return $book;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
