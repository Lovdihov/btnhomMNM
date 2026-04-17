<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function songs() {
        // Một thể loại có nhiều bài hát
        return $this->belongsToMany(Song::class, 'song_genres', 'genre_id', 'song_id');
    }
}