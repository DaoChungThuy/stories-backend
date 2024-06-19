<?php

namespace App\Http\Requests\Api\Chapter;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'book_id' => [
                'required',
                'exists:books,id',
            ],
            'chapter_number' => [
                'required',
                'numeric',
            ],
            'chapter_title' => [
                'string',
            ],
            'image' => [
                'required',
                'array',
            ],
            'image.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:2048',
            ],
        ];
    }
}
