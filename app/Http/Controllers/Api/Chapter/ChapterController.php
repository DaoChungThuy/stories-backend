<?php

namespace App\Http\Controllers\Api\Chapter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chapter\ChapterRequest;
use App\Http\Resources\Api\Chapter\DetailChapterResource;
use App\Services\Api\Chapter\CountChaptersByBookIdService;
use App\Services\Api\Chapter\CreateChapterService;
use App\Services\Api\Chapter\GetChaptersByBookIdService;
use App\Services\Api\ChapterImage\AddListChapterImageService;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index(Request $request, $bookId)
    {
        $chapters = resolve(GetChaptersByBookIdService::class)->setParams($bookId)->handle();

        if (!$chapters) {
            return $this->responseErrors(__('chapter.get_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('chapter.get_success'),
            'data' => DetailChapterResource::apiPaginate($chapters, $request),
        ]);
    }

    public function store(ChapterRequest $request)
    {
        $chapter = resolve(CreateChapterService::class)->setParams($request->validated())->handle();
        $data = array_merge($request->validated(), ['chapter_id' => $chapter->id]);
        $addImage = resolve(AddListChapterImageService::class)->setParams($data)->handle();

        if (!$addImage) {
            return $this->responseErrors(__('chapter.create_falsed'));
        }

        return $this->responseSuccess([
            'message' => __('chapter.create_success'),
            'data' => new DetailChapterResource($chapter),
        ]);
    }

    public function countChaptersByBookId($bookId)
    {
        $number =  resolve(CountChaptersByBookIdService::class)->setParams($bookId)->handle();

        if ($number >= 0) {
            return $this->responseSuccess([
                'message' => __('chapter.get_success'),
                'data' => $number,
            ]);
        }

        return $this->responseErrors(__('chapter.get_falsed'));
    }
}
