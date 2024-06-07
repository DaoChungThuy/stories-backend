<?php

namespace App\Http\Requests\Api\ServicePackage;

use App\Http\Requests\Api\BaseRequest;

class RegisterUserServiceRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'service_package_id' => 'required|integer|exists:service_packages,id',
        ];
    }
}
