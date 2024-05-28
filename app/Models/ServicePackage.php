<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicePackage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_package_name',
        'price',
        'duration',
        'type',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_service_packages', 'user_id', 'service_package_id');
    }
}
