<?php

namespace App\Http\Requests\Api\Crawl;

use App\Enums\PackageType;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class CrawlBookRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'url' => [
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
            'package_type' => [
                'required',
                Rule::in(PackageType::getValues())
            ],
        ];
    }
}
