<?php

namespace App\Http\Resources\Api\Book;

use App\Http\Resources\Api\BaseResource;

class BookChapterResource extends BaseResource
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
            'title' => $this->title,
            'package_type' => $this->package_type,
            'chapters' => $this->chapters->sortBy('chapter_number'),
        ];
    }
}
