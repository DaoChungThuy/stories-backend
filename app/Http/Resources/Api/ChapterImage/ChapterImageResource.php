<?php

namespace App\Http\Resources\Api\ChapterImage;

use App\Http\Resources\Api\BaseResource;

class ChapterImageResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chapter_id' => $this->chapter_id,
            'url' => $this->url,
            'image_number' => $this->image_number,
        ];
    }
}
