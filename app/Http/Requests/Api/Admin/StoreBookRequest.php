<?php

namespace App\Http\Requests\Api\Admin;

use App\Enums\PackageType;
use App\Enums\StatusStory;
use App\Enums\StoryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
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
                'max:255',
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
                'nullable',
                'string',
            ],
            'status' => [
                'required',
                Rule::in(StatusStory::getValues())
            ],
            'cover_image' => [
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
            'package_type' => [
                'required',
                Rule::in(PackageType::getValues())
            ],
            'story_type' => [
                'required',
                Rule::in(StoryType::getValues())
            ]
        ];
    }
}
