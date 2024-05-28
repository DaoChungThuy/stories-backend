<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserChapter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_chapters';

    protected $fillable = [
        'user_id',
        'chapter_id',
    ];

    public function Chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
