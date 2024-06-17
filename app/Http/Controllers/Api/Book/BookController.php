<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Book\GenerateDescRequest;
use App\Services\Api\Book\GenerateDescBookService;
use App\Http\Requests\Api\Book\CreateBookRequest;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Api\Book\CreateBookService;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    public function generateBookDesc(GenerateDescRequest $request)
    {
        $oldDescription = explode("\n", $request->input('old_description'));
        $filteredLines = array_filter($oldDescription, 'trim');
        $oldDescription = implode("\n", $filteredLines);

        $newDescription = resolve(GenerateDescBookService::class)->generateDesc($oldDescription);

        if (!$newDescription) {
            return $this->responseErrors([
                'message' => __('book.generate_desc_fail'),
            ]);
        }

        $textNewDescription = $oldDescription;

        foreach ($newDescription['candidates'] as $candidate) {
            if ($candidate['finishReason'] === 'STOP') {
                foreach ($candidate['content']['parts'] as $part) {
                    if (isset($part['text'])) {
                        $textNewDescription = $part['text'];
                        break 2;
                    }
                }
            }
        }

        $textNewDescription = preg_replace('/##|\*/', '', $textNewDescription);

        return $this->responseSuccess([
            'message' => __('book.generate_desc_success'),
            'data' => $newDescription,
        ]);
    }

    public function store(CreateBookRequest $createBookRequest)
    {
        $book = resolve(CreateBookService::class)->setParams($createBookRequest->validated())->handle();

        if (!$book) {
            return $this->responseErrors(__('book.create_falsed'), Response::HTTP_BAD_REQUEST);
        }

        return $this->responseSuccess([
            'message' =>  __('book.create_success'),
            'data' => new BookResource($book),
        ]);
    }
}
