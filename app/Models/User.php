<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Song;
use App\Models\PlayHistory;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Lấy danh sách các bài hát user này đã thả tim (qua bảng favorites)
    public function favoriteSongs()
    {
        return $this->belongsToMany(Song::class, 'favorites');
    }

    // Lấy lịch sử nghe nhạc của user
    public function playHistories()
    {
        return $this->hasMany(PlayHistory::class, 'user_id');
    }

    public function favoriteArtists()
    {
        return $this->belongsToMany(Artist::class, 'favorite_artists', 'user_id', 'artist_id');
    }
}
