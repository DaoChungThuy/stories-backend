<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'genres';

    protected $fillable = [
        'genre_name',
        'cover_image',
    ];

    public function book()
    {
        return $this->hasMany(Book::class);
    }
}
