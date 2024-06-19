<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

/**
 * Class GenerateDescBook.
 */
class FindBookByIdService extends BaseService
{
    protected $BookRepository;

    public function __construct(BookRepositoryInterface $BookRepository)
    {
        $this->BookRepository = $BookRepository;
    }

    public function handle()
    {
        try {
            return $this->BookRepository->findBookById($this->data);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
