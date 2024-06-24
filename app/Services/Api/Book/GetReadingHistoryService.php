<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

/**
 * Class GenerateDescBook.
 */
class GetReadingHistoryService extends BaseService
{
    protected $BookRepository;

    public function __construct(BookRepositoryInterface $BookRepository)
    {
        $this->BookRepository = $BookRepository;
    }

    public function handle()
    {
        try {
            return $this->BookRepository->getReadingHistory(auth()->id())->get();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
