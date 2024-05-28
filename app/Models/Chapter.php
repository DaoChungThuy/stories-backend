<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'chapters';

    protected $fillable = [
        'book_id',
        'chapter_number',
        'chapter_title',
        'chapter_content',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function chapterImages()
    {
        return $this->hasMany(ChapterImage::class);
    }

    public function userChapters()
    {
        return $this->hasMany(UserChapter::class);
    }
}
