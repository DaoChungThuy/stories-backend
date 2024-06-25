<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{
    public function uploadFile(UploadedFile $file)
    {
        $imageName = 'img_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path_name = 'image/';

        if (Storage::disk('public')->put($path_name . $imageName, file_get_contents($file->getRealPath()))) {
            return $imageName;
        }

        return false;
    }
}
