<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    // Quan hệ 1-n: Một playlist thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ n-n: Một playlist có thể chứa nhiều bài hát
    public function songs()
    {
        return $this->belongsToMany(Song::class, 'playlist_songs');
    }
}

