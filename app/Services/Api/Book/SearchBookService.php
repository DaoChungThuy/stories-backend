<?php

namespace App\Services\Api\Book;

use App\Interfaces\Book\BookRepositoryInterface;
use App\Models\Author;
use App\Models\Book;
use App\Services\BaseService;
use Exception;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

class SearchBookService extends BaseService
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function handle()
    {
        try {
            $searchResults = (new Search())
                ->registerModel(Author::class, ['author_name'])
                ->registerModel(Book::class, function (ModelSearchAspect $modelSearchAspect) {
                    $modelSearchAspect
                        ->addSearchableAttribute('title')
                        ->addSearchableAttribute('description');
                })
                ->perform($this->data);

            $formattedResults = $searchResults->map(function ($result) {
                $resultData = null;
                switch ($result->type) {
                    case 'authors':
                        $resultData = Author::find($result->searchable->id)->toArray();
                        break;
                    case 'books':
                        $resultData = Book::find($result->searchable->id)->toArray();
                        break;
                }

                return [
                    'type' => $result->type,
                    'data' => $resultData,
                ];
            });

            return $formattedResults;
        } catch (Exception $e) {
            return false;
        }
    }
}
