<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Api\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseRequest
{
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

    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be a string.',
            'username.unique' => 'Username already exists.',

            'email.required' => 'Email is required.',
            'email.regex' => 'The email format is invalid.',
            'email.unique' => 'Email already exists.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.regex' => 'Password must start with a letter. It cannot contain spaces or special characters.',

            'full_name.required' => 'Full name is required.',
            'full_name.string' => 'Full name must be a string.',

            'avatar.image' => 'Avatar must be an image file.',
            'avatar.mimes' => 'Avatar must be a file of type: png, jpg, jpeg.',
            'avatar.max' => 'Avatar may not be greater than 2048 kilobytes.',
        ];
    }
}
