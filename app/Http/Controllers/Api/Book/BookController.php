<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Book\GenerateDescRequest;
use App\Http\Resources\Api\Book\BookWithAuthorResource;
use App\Services\Api\Book\DeleteBookService;
use App\Http\Resources\Api\Book\BookDetailResource;
use App\Http\Resources\Api\Book\BookHistoryResource;
use App\Services\Api\Book\FindBookByIdService;
use App\Services\Api\Book\GenerateDescBookService;
use App\Http\Requests\Api\Book\CreateBookRequest;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Api\Book\CreateBookService;
use App\Services\Follow\CountFollowService;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Api\Book\GetBookByAuthorService;
use Illuminate\Http\Request;
use App\Services\Api\Book\GetReadingHistoryService;
use App\Http\Requests\Api\Book\UpdateBookRequest;
use App\Http\Requests\Api\Follow\FollowRequest;
use App\Services\Api\Book\FilterBookService;
use App\Services\Api\Book\SearchBookService;
use App\Http\Resources\Api\Book\TopBookResource;
use App\Services\Api\Book\CheckRolePackageService;
use App\Services\Api\Book\GetTopBookService;
use App\Services\Api\Book\GetBookListService;
use App\Http\Resources\Api\Book\BookChapterResource;
use App\Services\Api\Book\GetBookByChapterService;
use App\Services\Api\Book\UpdateBookService;
use App\Services\Follow\FolowBookService;

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

    public function getBookByAuthor(Request $request, $authorId)
    {
        $books = resolve(GetBookByAuthorService::class)->setParams($authorId)->handle();

        if (!$books) {
            return $this->responseErrors(__('book.get_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.get_success'),
            'data' => BookResource::apiPaginate($books, $request),
        ]);
    }

    public function update(UpdateBookRequest $updateBookRequest, $bookId)
    {
        $data = array_merge($updateBookRequest->validated(), ['id' => $bookId]);
        $book = resolve(UpdateBookService::class)->setParams($data)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.update_falsed'));
        }

        return $this->responseSuccess([
            'message' =>  __('book.update_success'),
            'data' => new BookResource($book),
        ]);
    }

    public function destroy($book_id)
    {
        $book = resolve(DeleteBookService::class)->setParams($book_id)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.delete_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.delete_success'),
        ]);
    }

    public function search(Request $request)
    {
        $books = resolve(SearchBookService::class)->setParams($request->input('keyword'))->handle();

        if (!$books) {
            return $this->responseErrors(__('book.search_fail'));
        }

        return $this->responseSuccess([
            'message' => __('book.search_success'),
            'data' => $books,
        ]);
    }

    public function filter(Request $request)
    {
        $books = resolve(FilterBookService::class)->setParams($request->all())->handle();

        if (!$books) {
            return $this->responseErrors(__('book.search_fail'));
        }
        
        return $this->responseSuccess([
            'message' => __('book.search_success'),
            'data' => $books,
        ]);
    }
    /**
     * Get book detail.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData($id, $limitChapter = 10)
    {
        $book = resolve(FindBookByIdService::class)->setParams([
            'id' => $id,
            'limitChapter' => $limitChapter
        ])->handle();

        if ($book) {
            return $this->responseSuccess([
                'data' => BookDetailResource::make($book)
            ]);
        }

        return $this->responseErrors(__('book.not_found'));
    }

    /**
     * Get reading history.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHistory()
    {
        $books = resolve(GetReadingHistoryService::class)->handle();

        if ($books) {
            return $this->responseSuccess([
                'data' => BookHistoryResource::collection($books)
            ]);
        }

        return $this->responseErrors(__('book.not_found'));
    }

    /**
     * Get top book.
     * @return \Illuminate\Http\JsonResponse
     * @param int $day
     */
    public function getTopBook($day)
    {
        $books = resolve(GetTopBookService::class)->setParams($day)->handle();

        if ($books) {
            return $this->responseSuccess([
                'data' => TopBookResource::collection($books)
            ]);
        }

        return $this->responseErrors(__('book.not_found'));
    }

    public function followBook(FollowRequest $request)
    {
        $book = resolve(FolowBookService::class)->setParams($request->validated())->handle();
        $follows = resolve(CountFollowService::class)->setParams($request->validated())->handle();


        if ($book) {
            return $this->responseSuccess([
                'message' => __('book.follow_success'),
                'follows' => $follows,
            ]);
        }

        return $this->responseErrors(__('book.follow_failed'));
    }

    public function getBookChapters($chapterId)
    {
        $book = resolve(GetBookByChapterService::class)->setParams($chapterId)->handle();

        if (!$book) {
            return $this->responseErrors(__('book.get_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.get_success'),
            'data' => new BookChapterResource($book),
        ]);
    }
    public function getBookList()
    {
        $book  = resolve(GetBookListService::class)->handle();

        if ($book) {
            return $this->responseSuccess([
                'data' => BookWithAuthorResource::collection($book),
            ]);
        }

        return $this->responseErrors(__('book.not_found'));
    }

    /**
     * check user has service or not
     * @param int $chapter_id
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkService($chapter_id, $type = null)
    {
        $check = resolve(CheckRolePackageService::class)->setParams([
            'chapter_id' => $chapter_id,
            'type' => $type,
        ])->handle();

        return response()->json([
            'status' => $check
        ]);
    }
}
