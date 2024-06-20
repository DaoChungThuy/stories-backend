<?php

namespace App\Services\Api\ChapterImage;

use App\Interfaces\ChapterImage\ChapterImageRepositoryInterface;
use App\Services\BaseService;
use App\Traits\UploadFileImageTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class AddListChapterImageService extends BaseService
{
    use UploadFileImageTrait;
    protected $chapterImageRepository;

    public function __construct(ChapterImageRepositoryInterface $chapterImageRepository)
    {
        $this->chapterImageRepository = $chapterImageRepository;
    }

    public function handle()
    {
        try {
            $imageNumber = 1;

            foreach ($this->data['image'] as $image) {
                $this->data['image_number'] = $imageNumber;
                $this->data['url'] = $this->uploadFileImage($image, 'image_chapter');
                $imageNumber++;
                $this->chapterImageRepository->create($this->data);
            }

            return true;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
