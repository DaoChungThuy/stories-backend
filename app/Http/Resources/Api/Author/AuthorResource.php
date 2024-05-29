<?php

namespace App\Http\Resources\Api\Author;

use App\Http\Resources\Api\BaseResource;

class AuthorResource extends BaseResource
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
            'create_by_user_id' => $this->create_by_user_id,
            'author_name' => $this->author_name,
            'avatar' => $this->avatar,
        ];
    }
}
