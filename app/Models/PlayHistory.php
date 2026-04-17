<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayHistory extends Model
{
    protected $table = 'play_history';
    protected $fillable = ['user_id', 'song_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}