<?php

namespace App\Http\Resources\Api\User;

use App\Enums\PackageType;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'role' => $this->role,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'verification_token' => $this->verification_token,
            'service_package' => $this->servicePackages()->orderByRaw('FIELD(type, ?, ?)', [
                PackageType::PREMIUM,
                PackageType::BASE,
            ])->first()
        ];
    }
}
