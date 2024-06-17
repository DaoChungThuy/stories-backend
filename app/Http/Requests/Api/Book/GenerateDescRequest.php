<?php

namespace App\Http\Requests\Api\Book;

use App\Http\Requests\Api\BaseRequest;

class GenerateDescRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_description' => [
                'required',
            ]
        ];
    }
}
