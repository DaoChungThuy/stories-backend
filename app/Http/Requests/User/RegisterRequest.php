<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|string|unique:users',
            'email' => [
                'required',
                'regex:/^[a-zA-Z]+[a-zA-Z0-9\-]*@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,}$/ui',
                'unique:users'
            ],
            'password' => 'required|min:6|regex:/^[a-zA-Z]+[a-zA-Z0-9\-]*$/u',
            'full_name' => 'required|string',
            'avatar' => 'image|mimes:png,jpg,jpeg|max:2048'
        ];
    }
}
