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
<<<<<<< HEAD

    public function getChapterImageByData($colum, $data, $compare = '=')
    {
        return $this->model->where($colum, $compare, $data)->orderBy('image_number');
    }
=======
>>>>>>> f0272c0168485e334d727b6665d6b6cd9b7aafd7
}
