<?php

namespace App\Http\Resources\Api\Author;

use App\Http\Resources\Api\BaseResource;

class BookResource extends BaseResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "author_id" => $this->author_id,
            "genre_id" => $this->genre_id,
            "description" => $this->description,
            "status" => $this->status,
            "cover_image" => $this->cover_image,
            "package_type" => $this->package_type,
            "story_type" => $this->story_type,
            "followers" => $this->followers->count(),
            "chapters" => $this->chapters,
            "book_likes" => $this->bookLikes->count(),
        ];
    }
}
