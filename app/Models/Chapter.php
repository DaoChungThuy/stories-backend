<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'book_id',
        'chapter_number',
        'chapter_title',
        'chapter_content',
    ];

    /**
     * Get the Images for the chapter.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapterImages()
    {
        return $this->hasMany(ChapterImage::class);
    }
}
