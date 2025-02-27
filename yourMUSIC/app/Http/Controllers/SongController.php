<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use Illuminate\Support\Facades\Storage;
use App\Models\Artist;
use App\Models\Album;
use Illuminate\Support\Facades\Log;


class SongController extends Controller
{
    public function index(Request $request)
    {
        $query = Song::with(['artist:id,name,image', 'album']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('artist', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('album', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
        }
        
        $songs = $query->get();
        return view('songs.index', compact('songs'));
    }
        
    public function create()
    {
        $artists = Artist::with('albums')->get();
        return view('songs.create', compact('artists'));
    }
    
    public function store(Request $request)
    {
        try {
            Log::info('Starting song upload process');
            
            // Validate request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'artist_name' => 'required|string|max:255',
                'album_name' => 'nullable|string|max:255',
                'genre' => 'nullable|string|max:255',
                'file_name' => 'required|string|max:255', // Chỉ nhập tên file, không upload
            ]);

            Log::info('Validation passed', $validated);

            // Tìm hoặc tạo artist
            $artist = Artist::firstOrCreate(['name' => $request->artist_name]);
            Log::info('Artist processed', ['artist_id' => $artist->id]);

            // Xử lý album nếu có
            $album = null;
            if ($request->album_name) {
                $album = Album::firstOrCreate([
                    'artist_id' => $artist->id,
                    'title' => $request->album_name
                ]);
                Log::info('Album processed', ['album_id' => $album->id]);
            }

            // Lưu tên file vào database
            $virtualPath = 'songs/' . $request->file_name; // Chỉ lưu tên, không upload

            // Tạo song record
            $song = new Song();
            $song->title = $request->title;
            $song->artist_id = $artist->id;
            $song->album_id = $album ? $album->id : null;
            $song->genre = $request->genre;
            $song->file_path = $virtualPath;  

            if (!$song->save()) {
                throw new \Exception('Failed to save song to database');
            }

            Log::info('Song saved successfully', ['song_id' => $song->id]);

            return redirect()
                ->route('songs.index')
                ->with('success', 'Song information saved successfully');

        } catch (\Exception $e) {
            Log::error('Error saving song', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to save song: ' . $e->getMessage()]);
        }
    }  
    
    public function show(Song $song)
    {
        $song->load(['artist', 'album']);
        return view('songs.play', compact('song'));
    }
    
    public function edit(Song $song)
    {

        $artists = Artist::with('albums')->get();
        $albums = Album::all(); // Lấy tất albums và artists
        $currentArtistAlbums = $song->artist ? $song->artist->albums : collect();

        return view('songs.edit', compact('song', 'artists', 'albums'));
    }

    public function update(Request $request, Song $song)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre' => 'nullable|string|max:255',
            'song_file' => 'nullable|file|mimes:mp3|max:10240',
        ]);

        if ($request->album_id) {
            $album = Album::findOrFail($request->album_id);
            if ($album->artist_id != $request->artist_id) {
                return back()->withErrors(['album_id' => 'Album không thuộc về nghệ sĩ đã chọn.']);
            }
        }

        if ($request->hasFile('song_file')) {
            if ($song->file_path) {
                Storage::disk('public')->delete($song->file_path);
            }

            $file = $request->file('song_file');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs('songs', $fileName, 'public');
            
            $song->file_path = $path;
        }

        $song->update([
            'title' => $request->title,
            'artist_id' => $request->artist_id,
            'album_id' => $request->album_id,
            'genre' => $request->genre,
        ]);

        return redirect()->route('songs.index')->with('success', 'Cập nhật bài hát thành công.');
    }

    public function destroy(Song $song)
    {
        
        if ($song->file_path) {
            Storage::disk('public')->delete($song->file_path);
        }

        $song->delete();
        return redirect()->route('songs.index')->with('success', 'Xóa bài hát thành công.');
    }
    
    public function next(Song $song)
    {
        // Tìm bài hát tiếp theo có id lớn hơn bài hiện tại
        $nextSong = Song::where('id', '>', $song->id)
            ->orderBy('id')
            ->first();
        
            // Nếu không có bài tiếp theo (đang ở bài cuối cùng)
        // thì quay lại bài đầu tiên trong danh sách
        if (!$nextSong) {
            $nextSong = Song::orderBy('id')
                ->first();
        }
        
        return redirect()->route('songs.show', $nextSong);
    }

    public function prev(Song $song)
    {
        // Tìm bài hát trước có id nhỏ hơn bài hiện tại
        $prevSong = Song::where('id', '<', $song->id)
            ->orderBy('id', 'desc')
            ->first();
        
        // Nếu không có bài trước đó (đang ở bài đầu tiên)
        // thì chuyển đến bài cuối cùng trong danh sách
        if (!$prevSong) {
            $prevSong = Song::orderBy('id', 'desc')
                ->first();
        }
        
        return redirect()->route('songs.show', $prevSong);
    }

    //test
    public function playTest()
    {
        $filePath = storage_path('app/public/songs/matketnot_dongdomic.mp3');
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return response()->file($filePath);
    }
    // phương thức checkArtist để trả về tên album chính xác
    public function checkArtist($artistName) 
    {
        $artist = Artist::where('name', $artistName)->first();
        if ($artist) {
            $albums = $artist->albums->map(function($album) {
                return [
                    'id' => $album->id,
                    'name' => $album->title  // Sử dụng title thay vì name
                ];
            });
            
            return response()->json([
                'exists' => true,
                'albums' => $albums
            ]);
        }
        return response()->json(['exists' => false]);
    }
}