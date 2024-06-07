<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'service_package_name',
        'price',
        'duration',
        'type',
    ];

    /**
     * Get all of the user service packages for the service package
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userServicePackages()
    {
        return $this->hasMany(UserServicePackage::class);
    }
}
