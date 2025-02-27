<?php

use App\Http\Controllers\SongController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;  
use App\Http\Controllers\ArtistController;  
use App\Http\Controllers\AlbumController;  
use App\Http\Controllers\GenreController;  

Route::get('/', function () {  
    return view('welcome');  
})->name('welcome');  

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Routes for Songs
Route::resource('songs',SongController::class);
Route::get('/songs', [SongController::class, 'index'])->name('songs.index');
Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create');    
Route::post('/songs', [SongController::class, 'store'])->name('songs.store');
Route::get('/songs/{song}/next', [SongController::class, 'next'])->name('songs.next');
Route::get('/songs/{song}/prev', [SongController::class, 'prev'])->name('songs.prev');

//test
Route::get('/playtest', [SongController::class, 'playTest']);

// Playlist Routes
Route::resource('playlists',PlaylistController::class);
Route::post('playlists/{playlist}/songs/{song}',[PlaylistController::class,'addSong'])->name('playlists.addSong');
Route::delete('playlists/{playlist}/songs/{song}',[PlaylistController::class,'removeSong'])->name('playlists.removeSong');

// Album Routes
Route::resource('albums', AlbumController::class);
Route::get('/albums/{album}', [AlbumController::class, 'show'])->name('albums.show');

// Artist Routes
Route::resource('artists', ArtistController::class);
Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show');

//Genre
Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');