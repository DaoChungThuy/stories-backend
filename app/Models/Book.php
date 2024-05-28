<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author_id',
        'genre_id',
        'description',
        'status',
        'cover_image',
        'package_type',
        'story_type',
    ];

    public function comments()
    {
        // return $this->hasMany(Comment::class);
    }

    public function bookLikes()
    {
        // return $this->hasMany(BookLike::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function followers()
    {
        // return $this->hasMany(Follower::class);
    }

    public function author()
    {
        // return $this->belongsTo(Author::class);
    }
}
