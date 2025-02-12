<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Album;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $artists = Artist::withCount(['songs', 'albums'])
            ->orderBy('songs_count', 'desc')
            ->take(12)
            ->get();
            
        $albums = Album::with('artist')
            ->latest('release_date')
            ->take(12)
            ->get();
            
        return view('dashboard', compact('artists', 'albums'));
    }
}
