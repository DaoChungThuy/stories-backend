<?php

namespace App\Http\Resources\Api\Genre;

use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
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
            'genre_name' => $this->genre_name,
            'cover_image' => $this->cover_image,
        ];
    }
}
