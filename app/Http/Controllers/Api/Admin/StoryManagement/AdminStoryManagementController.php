<?php

namespace App\Http\Controllers\Api\Admin\StoryManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crawl\CrawlBookRequest;
use App\Http\Resources\Api\Book\BookResource;
use App\Services\Crawl\CrawlDataService;

class AdminStoryManagementController extends Controller
{
    public function crawlStory(CrawlBookRequest $request)
    {
        $story = resolve(CrawlDataService::class)->setParams($request->validated())->handle();

        if (!$story) {
            return $this->responseErrors(__('book.create_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('book.create_success'),
            'data' => new BookResource($story),
        ]);
    }
}
