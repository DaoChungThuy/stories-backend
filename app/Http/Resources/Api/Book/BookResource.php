<?php

namespace App\Http\Resources\Api\Book;

use App\Http\Resources\Api\BaseResource;

class BookResource extends BaseResource
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
            'author_name' => $this->author->author_name,
            'genre_name' => $this->genre->genre_name,
            'description' => $this->description,
            'status' => $this->status,
            'cover_image' => $this->cover_image,
            'package_type' => $this->package_type,
            'story_type' => $this->story_type,
        ];
    }
}
