<?php

namespace App\Http\Requests\Api\ServicePackage;

use App\Enums\PackageType;
use App\Http\Requests\Api\BaseRequest;
use Illuminate\Validation\Rule;

class CreateServicePackageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'service_package_name' => 'required|string|unique:service_packages',
            'price' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
            'type' => [
                'required',
                Rule::in(PackageType::getValues()),
            ],
        ];
    }
}
