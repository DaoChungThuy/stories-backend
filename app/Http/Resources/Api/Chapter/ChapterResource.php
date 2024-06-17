<?php

namespace App\Http\Resources\Api\Chapter;

use App\Http\Resources\Api\BaseResource;

class ChapterResource extends BaseResource
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
            "id" => $this->id,
            "book_id" => $this->book_id,
            "chapter_number" => $this->chapter_number,
            "chapter_title" => $this->chapter_title,
            "chapter_content" => $this->chapter_content,
        ];
    }
}
