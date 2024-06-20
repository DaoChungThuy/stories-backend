<?php

namespace App\Services\Api\ChapterImage;

use App\Interfaces\ChapterImage\ChapterImageRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetChapterImageByChapterIdService extends BaseService
{
    protected $chapterImageRepository;

    public function __construct(ChapterImageRepositoryInterface $chapterImageRepository)
    {
        $this->chapterImageRepository = $chapterImageRepository;
    }

    public function handle()
    {
        try {
            return $this->chapterImageRepository->getChapterImageByData('chapter_id', $this->data)->get();
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
