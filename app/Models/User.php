<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'avatar',
        'full_name',
        'email',
        'password',
        'role',
        'hash_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAttributeImageURL()
    {
        // Storage::disk('local')->put('example.txt', 'Contents');
        return asset(Storage::get($this->avatar));
    }

    public function ahthors()
    {
        return $this->hasMany(Author::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function bookLikes()
    {
        return $this->hasMany(BookLike::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    public function userChapters()
    {
        return $this->hasMany(UserChapter::class);
    }
}
