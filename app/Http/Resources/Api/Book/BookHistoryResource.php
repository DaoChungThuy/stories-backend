<?php

namespace App\Http\Resources\Api\Book;

use App\Http\Resources\Api\BaseResource;

class BookHistoryResource extends BaseResource
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
            'author_id' => $this->author_id,
            'genre_id' => $this->genre_id,
            'description' => $this->description,
            'status' => $this->status,
            'cover_image' => $this->cover_image,
            'package_type' => $this->package_type,
            'story_type' => $this->story_type,
            'user_chapters' => $this->userChapters[0],
            'likes' => $this->book_likes_count,
        ];
    }
}
