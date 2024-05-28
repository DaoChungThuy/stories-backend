<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChapterImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chapter_images';

    protected $fillable = [
        'chapter_id',
        'url',
        'image_number',
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
