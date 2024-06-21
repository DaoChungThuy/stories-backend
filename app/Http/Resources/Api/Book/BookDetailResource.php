<?php

namespace App\Http\Resources\Api\Book;

use App\Http\Resources\Api\Author\AuthorResource;
use App\Http\Resources\Api\BaseResource;
use App\Http\Resources\Api\Chapter\ChapterResource;
use App\Http\Resources\Api\Genre\GenreResource;

class BookDetailResource extends BaseResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'followers' => $this->followers_count,
            'likes' => $this->book_likes_count,
            'total_chapters' => $this->chapters_count,
            'author' => AuthorResource::make($this->author),
            'genre' => GenreResource::make($this->genre),
            'chapters' => ChapterResource::collection($this->chapters),
            'is_follow' => auth()->user() ? $this->isFollowedByUser(auth()->user()->id) : false,
        ];
    }
}
