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
                if ($result->type === 'authors') {
                    $author = Author::find($result->title);
                    return [
                        'type' => $result->type,
                        'author' => $author->toArray(),
                    ];
                } elseif ($result->type === 'books') {
                    $book = Book::find($result->title);
                    return [
                        'type' => $result->type,
                        'book' => $book->toArray(),
                    ];
                }
            });

            return $formattedResults;
        } catch (Exception $e) {
            return false;
        }
    }
}
