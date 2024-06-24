<?php

namespace App\Interfaces\ChapterImage;

use App\Interfaces\CrudRepositoryInterface;

interface ChapterImageRepositoryInterface extends CrudRepositoryInterface
{
    public function getChapterImageByData($colum, $data, $compare = '=');
}
