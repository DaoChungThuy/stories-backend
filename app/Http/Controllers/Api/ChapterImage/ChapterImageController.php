<?php

namespace App\Http\Controllers\Api\ChapterImage;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ChapterImage\ChapterImageResource;
use App\Services\Api\ChapterImage\GetChapterImageByChapterIdService;

class ChapterImageController extends Controller
{
    public function index($chapter_id)
    {
        $chapterImages = resolve(GetChapterImageByChapterIdService::class)->setParams($chapter_id)->handle();

        if (!$chapterImages) {
            return $this->responseErrors(__('chapter.get_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('chapter.get_success'),
            'data' => ChapterImageResource::collection($chapterImages),
        ]);
    }
}
