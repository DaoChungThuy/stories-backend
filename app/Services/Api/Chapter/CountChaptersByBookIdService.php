<?php

namespace App\Services\Api\Chapter;

use App\Interfaces\Chapter\ChapterRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class CountChaptersByBookIdService extends BaseService
{
    protected $chapterRepository;

    public function __construct(ChapterRepositoryInterface $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }

    public function handle()
    {
        try {
            return $this->chapterRepository->countChaptersByBookId($this->data);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
