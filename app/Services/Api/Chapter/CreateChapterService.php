<?php

namespace App\Services\Api\Chapter;

use App\Interfaces\Chapter\ChapterRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateChapterService extends BaseService
{
    protected $chapterRepository;

    public function __construct(ChapterRepositoryInterface $chapterRepository)
    {
        $this->chapterRepository = $chapterRepository;
    }

    public function handle()
    {
        try {
            $chapter =  $this->chapterRepository->create($this->data);

            return $chapter;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
