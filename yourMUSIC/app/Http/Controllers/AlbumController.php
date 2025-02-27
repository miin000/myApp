<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = album::withCount(['songs', 'albums'])->get();
        return view('albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('albums', 'public');
        }

        album::create($validated);

        return redirect()->back()->with('success', 'album created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(album $album)
    {
        // Eager load songs để tránh N+1 query
        $album->load('songs');
        
        return view('albums.index', [
            'album' => $album
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Album $album)
    {
        $artists = Artist::all();
        return view('albums.edit', compact('album', 'artists'));
    }

    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'cover_image' => 'nullable|string|max:255', // Nhập đường dẫn ảnh
            'release_date' => 'nullable|date',
        ]);

        $album->update($validated);

        return redirect()->route('albums.show', $album->id)
            ->with('success', 'Album updated successfully');
    }
}
