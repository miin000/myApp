@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Song</h2>
    
    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Song Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="artist_name" class="form-label">Artist Name</label>
            <input type="text" class="form-control" id="artist_name" name="artist_name" required>
            <div id="artistStatus" class="form-text"></div>
        </div>

        <div class="mb-3">
            <label for="album_name" class="form-label">Album</label>
            <select class="form-select" id="album_select" name="album_name" style="display: none;">
                <option value="">-- Select Album --</option>
            </select>
            <input type="text" class="form-control" id="album_input" name="album_name" placeholder="Enter new album name">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="createNewAlbum">
                <label class="form-check-label" for="createNewAlbum">
                    Create new album
                </label>
            </div>
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre">
        </div>

        <div class="mb-3">
            <label for="song_file" class="form-label">Song File (MP3)</label>
            <input type="file" class="form-control" id="song_file" name="song_file" accept=".mp3" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload Song</button>
    </form>
</div>

@push('scripts')
<script>
let typingTimer;
const doneTypingInterval = 500;

document.getElementById('artist_name').addEventListener('keyup', function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(() => checkArtist(this.value), doneTypingInterval);
});

document.getElementById('createNewAlbum').addEventListener('change', function() {
    const albumSelect = document.getElementById('album_select');
    const albumInput = document.getElementById('album_input');
    
    if (this.checked) {
        albumSelect.style.display = 'none';
        albumInput.style.display = 'block';
    } else {
        albumSelect.style.display = 'block';
        albumInput.style.display = 'none';
    }
});

async function checkArtist(artistName) {
    if (!artistName) return;
    
    try {
        const response = await fetch(`/check-artist/${encodeURIComponent(artistName)}`);
        const data = await response.json();
        const statusDiv = document.getElementById('artistStatus');
        const albumSelect = document.getElementById('album_select');
        const createNewAlbumCheckbox = document.getElementById('createNewAlbum');
        
        if (data.exists) {
            statusDiv.textContent = 'Artist found! Select an existing album or create a new one.';
            statusDiv.className = 'text-success';
            
            // Populate albums dropdown
            albumSelect.innerHTML = '<option value="">-- Select Album --</option>';
            data.albums.forEach(album => {
                albumSelect.innerHTML += `<option value="${album.name}">${album.name}</option>`;
            });
            
            albumSelect.style.display = 'block';
            createNewAlbumCheckbox.parentElement.style.display = 'block';
        } else {
            statusDiv.textContent = 'New artist will be created';
            statusDiv.className = 'text-info';
            albumSelect.style.display = 'none';
            document.getElementById('album_input').style.display = 'block';
            createNewAlbumCheckbox.parentElement.style.display = 'none';
        }
    } catch (error) {
        console.error('Error checking artist:', error);
    }
}
</script>
@endpush
@endsection