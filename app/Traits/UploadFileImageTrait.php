<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

trait UploadFileImageTrait
{
    public function uploadFileImage(UploadedFile $file, $name)
    {
        try {
            $imageName = $name . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path_name = 'image/';
            Storage::disk('public')->put($path_name . $imageName, file_get_contents($file));

            return $imageName;
        } catch (\Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
