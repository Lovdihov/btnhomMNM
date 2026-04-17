<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    // Một nghệ sĩ có thể hát nhiều bài hát
    public function songs()
    {
        return $this->belongsToMany(Song::class)->withPivot('role');
    }

    // Một nghệ sĩ có thể được yêu thích bởi nhiều người dùng
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_artists', 'artist_id', 'user_id');
    }

    protected $fillable = [
        'name',
        'slug',
        'avatar_url',
        'gender',
        'is_group',
        'status'
    ];
}
