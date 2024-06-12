<?php

namespace App\Http\Controllers\Api\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Author\CreateAuthorRequest;
use App\Http\Resources\Api\Author\AuthorResource;
use App\Services\Api\Author\CreateAuthorService;
use App\Services\Api\Author\getAllChapterOfAuthorService;
use App\Services\Api\Author\GetBooksPostedService;
use App\Services\Api\Author\getFollowersService;

class AuthorController extends Controller
{
    public function store(CreateAuthorRequest $request)
    {
        $author = resolve(CreateAuthorService::class)->setParams($request->validated())->handle();

        if (!$author) {
            return $this->responseErrors(__('author.register_failed'));
        }

        return $this->responseSuccess([
            'message' => __('author.register_success'),
            'data' => new AuthorResource($author),
        ]);
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
                'data' => $books
            ]);
        }

        return $this->responseErrors(__('author.no_book_posted'));
    }

    /**
     * Get the chapters posted by the author.
     * @return \Illuminate\Http\Response
     */
    public function chapterPosted()
    {
        $chapters = resolve(getAllChapterOfAuthorService::class)->handle();

        if ($chapters) {
            return $this->responseSuccess([
                'data' => $chapters
            ]);
        }

        return $this->responseErrors(__('author.no_chapter_posted'));
    }

    /**
     * Get the followers of the author.
     * @return \Illuminate\Http\Response
     */
    public function getFollowers()
    {
        $follower = resolve(getFollowersService::class)->handle();

        if ($follower) {
            return $this->responseSuccess([
                'data' => $follower
            ]);
        }

        return $this->responseErrors(__('author.no_follower'));
    }
}
