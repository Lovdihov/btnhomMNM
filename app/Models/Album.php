<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    // Một album chứa nhiều bài hát
    public function songs()
    {
        return $this->hasMany(Song::class, 'album_id');
    }

    protected $fillable = [
        'title',
        'release_date',
        'cover_url',
        'status'
    ];
}
