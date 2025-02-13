<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist_id',
        'album_id',
        'genre',
        'file_path'
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // Quan hệ n-n: Một bài hát có thể nằm trong nhiều playlist
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class, 'playlist_songs');
    }
}

