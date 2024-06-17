<?php

namespace App\Http\Requests\Api\Book;

use App\Enums\PackageType;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => [
                'string',
            ],
            'author_id' => [
                'exists:authors,id',
            ],
            'genre_id' => [
                'exists:genres,id',
            ],
            'description' => [
                'string',
            ],
            'cover_image' => [
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'package_type' => [
                Rule::in(PackageType::getValues())
            ],
        ];
    }
}
