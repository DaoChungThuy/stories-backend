<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Log;

class GetTopBookService extends BaseService
{
    protected $BookRepository;
    const LIMIT = 5;

    public function __construct(BookRepositoryInterface $BookRepository)
    {
        $this->BookRepository = $BookRepository;
    }

    public function handle()
    {
        try {
            return $this->BookRepository->getTopBook($this->data, self::LIMIT)->get();
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return false;
        }
    }
}
