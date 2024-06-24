<?php

namespace App\Repositories\ChapterImage;

use App\Interfaces\ChapterImage\ChapterImageRepositoryInterface;
use App\Models\ChapterImage;
use App\Repositories\BaseRepository;

class ChapterImageRepository extends BaseRepository implements ChapterImageRepositoryInterface
{
    public function __construct(ChapterImage $chapterImage)
    {
        $this->model = $chapterImage;
    }

    public function getChapterImageByData($colum, $data, $compare = '=')
    {
        return $this->model->where($colum, $compare, $data)->orderBy('image_number');
    }
}
