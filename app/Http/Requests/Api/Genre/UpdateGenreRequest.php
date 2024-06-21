<?php

namespace App\Http\Requests\Api\Genre;

use App\Http\Requests\Api\BaseRequest;

class UpdateGenreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'genre_name' => [
                'required',
                'string',
                'max:255',
            ],
            'upload_cover_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
            ],
        ];
    }
}
