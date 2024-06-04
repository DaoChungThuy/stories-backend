<?php

namespace App\Http\Requests\Api\Author;

use App\Http\Requests\Api\BaseRequest;

class CreateAuthorRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'create_by_user_id' => [
                'required',
                'exists:users,id',
            ],
            'author_name' => [
                'required',
                'string',
                'max:255',
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
            ],
        ];
    }
}
