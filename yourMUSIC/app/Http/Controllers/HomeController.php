<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Album;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách artists với số lượng songs và albums
        $artists = Artist::withCount(['songs', 'albums'])
            ->orderBy('songs_count', 'desc')
            ->take(12)
            ->get();
            
        // Lấy danh sách albums mới nhất
        $albums = Album::with('artist')
            ->latest('release_date')
            ->take(12)
            ->get();
            
        // Lấy danh sách thể loại và đếm số lượng bài hát
        $genres = Song::select('genre', DB::raw('count(*) as songs_count'))
            ->whereNotNull('genre')
            ->groupBy('genre')
            ->orderBy('songs_count', 'desc')
            ->take(12)
            ->get();
            
        return view('dashboard', compact('artists', 'albums', 'genres'));
    }
}