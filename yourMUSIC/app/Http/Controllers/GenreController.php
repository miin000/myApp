<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function show($genre)
    {
        $songs = Song::where('genre', $genre)
                    ->with('artist') // thêm relationship nếu cần
                    ->get();
        
        return view('genres.show', [
            'genre' => $genre,
            'songs' => $songs
        ]);
    }
}