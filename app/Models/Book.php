<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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

    /**
     * Get full URL of cover image
     */
    public function getCoverImageAttribute($value)
    {
        return asset(Storage::url('image/'. $value));
    }

    /**
     * Get the comments for the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes for the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookLikes()
    {
        return $this->hasMany(BookLike::class);
    }

    /**
     * Get the genre for the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the chapters for the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    /**
     * Get the follower for the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    /**
     * Get the author for the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the user chapter for the book.
     * @return \Illuminate\Database\Eloquent\Relations\hasOneThrough
     */
    public function userChapters()
    {
        return $this->hasOneThrough(UserChapter::class, Chapter::class);
    }
}
