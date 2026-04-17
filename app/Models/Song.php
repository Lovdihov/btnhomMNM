<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    // Báo cho Laravel: Bài hát này thuộc về 1 Album
    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    // Báo cho Laravel: Bài hát này do nhiều Nghệ sĩ hát (qua bảng artist_song)
    public function artists()
    {
        return $this->belongsToMany(Artist::class)->withPivot('role');
    }

    // Lấy những user đã "thả tim" bài này
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'song_genres', 'song_id', 'genre_id');
    }

    protected $fillable = [
        'title',
        'album_id',
        'audio_url',
        'cover_url',
        'duration',
        'lyrics',
        'release_date',
        'status'
    ];
}
