<?php

namespace App\Http\Requests\Api\Book;

use App\Enums\PackageType;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class CreateBookRequest extends BaseRequest
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
                'required',
                'string',
            ],
            'author_id' => [
                'required',
                'exists:authors,id',
            ],
            'genre_id' => [
                'required',
                'exists:genres,id',
            ],
            'description' => [
                'required',
                'string',
            ],
            'cover_image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'package_type' => [
                'required',
                Rule::in(PackageType::getValues())
            ],
        ];
    }
}
