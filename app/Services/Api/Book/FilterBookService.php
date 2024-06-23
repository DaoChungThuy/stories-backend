<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Services\BaseService;
use Exception;

class FilterBookService extends BaseService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $query = $this->bookRepository->getInstance()
                ->when(!empty($this->data['selectedPackage']), function ($q) {
                    $q->where('package_type', $this->data['selectedPackage']);
                })
                ->when(!empty($this->data['selectedStoryType']), function ($q) {
                    $q->where('story_type', $this->data['selectedStoryType']);
                })
                ->when(!empty($this->data['selectedGenre']), function ($q) {
                    $q->where('genre_id', $this->data['selectedGenre']);
                });

            return $query->get();
        } catch (Exception $e) {
            return false;
        }
    }
}
