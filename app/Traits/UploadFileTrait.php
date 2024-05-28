<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{
    public function uploadFile(UploadedFile $file)
    {
        $imageName = 'author_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path_name = 'public/image/author/avatar/';

        if (Storage::disk('local')->put($path_name . $imageName, file_get_contents($file->getRealPath()))) {
            return $path_name . $imageName;
        }

        return false;
    }
}
