<?php

namespace App\Http\Controllers\Api\Author;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Author\CreateAuthorRequest;
use App\Http\Resources\Api\Author\AuthorResource;
use App\Http\Resources\Api\Author\BookResource;
use App\Services\Api\Author\CreateAuthorService;
use App\Services\Api\Author\GetAuthorService;
use App\Services\Api\Book\GetBooksPostedService;
use App\Services\Api\Author\getFollowersService;
use App\Services\User\UpdateUserService;

class AuthorController extends Controller
{
    public function store(CreateAuthorRequest $request)
    {
        $author = resolve(CreateAuthorService::class)->setParams($request->validated())->handle();

        if ($author) {
            resolve(UpdateUserService::class)->setParams(['user_id' => auth()->user()->id, 'role' => UserRole::AUTHOR])->handle();

            return $this->responseSuccess([
                'message' => __('author.register_success'),
                'data' => new AuthorResource($author),
            ]);
        }

        return $this->responseErrors(__('author.register_failed'));
    }

    /**
     * Get the books posted by the author.
     * @return \Illuminate\Http\Response
     */
    public function bookPosted()
    {
        $books = resolve(GetBooksPostedService::class)->handle();

        if ($books) {
            return $this->responseSuccess([
                'data' => BookResource::collection($books),
            ]);
        }

        return $this->responseErrors(__('author.no_book_posted'));
    }

    /**
     * Get the author data
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $author = resolve(GetAuthorService::class)->handle();

        if ($author) {
            return $this->responseSuccess([
                'data' => AuthorResource::make($author),
            ]);
        }

        return $this->responseErrors(__('author.not_found'));
    }
}
