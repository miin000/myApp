{{-- @extends('layouts.app') <!-- Kế thừa từ layout app -->

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Song</h2>
    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form nhập bài hát -->
    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 shadow rounded">
        @csrf
        <div class="form-group mb-3">
            <label for="title" class="form-label">Song Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter song title" value="{{ old('title') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="artist" class="form-label">Artist</label>
            <input type="text" name="artist" id="artist" class="form-control" placeholder="Enter artist name" value="{{ old('artist') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="album" class="form-label">Album</label>
            <input type="text" name="album" id="album" class="form-control" placeholder="Enter album name" value="{{ old('album') }}">
        </div>
        <div class="form-group mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" name="genre" id="genre" class="form-control" placeholder="Enter genre" value="{{ old('genre') }}">
        </div>
        <div class="form-group mb-3">
            <label for="song_file" class="form-label">Upload Song File</label>
            <input type="file" name="song_file" id="song_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Upload Song</button>
    </form>

    <!-- Nút quay lại -->
    <a href="{{ route('songs.index') }}" class="btn btn-secondary mt-4">Back to Songs List</a>
</div>
@endsection --}}



{{-- @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Add New Song</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('songs.store') }}" method="POST" enctype="multipart/form-data" class="bg-light p-4 shadow rounded">
        @csrf

        <!-- Artist Selection -->
        <div class="form-group mb-3">
            <label for="artist_id" class="form-label">Artist</label>
            <select name="artist_id" id="artist_id" class="form-control" required>
                <option value="" disabled selected>Select Artist</option>
                @foreach ($artists as $artist)
                    <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Album Selection (Hidden Initially) -->
        <div class="form-group mb-3" id="album-select-group" style="display: none;">
            <label for="album_id" class="form-label">Album</label>
            <select name="album_id" id="album_id" class="form-control">
                <option value="" disabled selected>Select Album</option>
                 <!-- Album Options will be populated dynamically -->
            </select>
            <button type="button" class="btn btn-link btn-sm mt-2" id="create-new-album-btn"  >Create New Album</button>
        </div>

         <!-- New Album Input (Hidden Initially) -->
        <div class="form-group mb-3" id="new-album-input-group" style="display: none;">
            <label for="new_album_name" class="form-label">New Album Name</label>
            <input type="text" name="new_album_name" id="new_album_name" class="form-control" placeholder="Enter new album name">
             <button type="button" class="btn btn-link btn-sm mt-2" id="cancel-new-album-btn"  >Cancel</button>
        </div>

        <!-- Song Title and Genre -->
        <div class="form-group mb-3">
            <label for="title" class="form-label">Song Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter song title" value="{{ old('title') }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" name="genre" id="genre" class="form-control" placeholder="Enter genre" value="{{ old('genre') }}">
        </div>

        <!-- File Upload -->
        <div class="form-group mb-3">
            <label for="song_file" class="form-label">Upload Song File</label>
            <input type="file" name="song_file" id="song_file" class="form-control" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">Upload Song</button>
    </form>

    <a href="{{ route('songs.index') }}" class="btn btn-secondary mt-4">Back to Songs List</a>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const artistSelect = document.getElementById('artist_id');
        const albumSelectGroup = document.getElementById('album-select-group');
        const albumSelect = document.getElementById('album_id');
        const newAlbumInputGroup = document.getElementById('new-album-input-group');
        const createNewAlbumBtn = document.getElementById('create-new-album-btn');
        const cancelNewAlbumBtn = document.getElementById('cancel-new-album-btn');

        artistSelect.addEventListener('change', function () {
            const selectedArtistId = this.value;
            if (selectedArtistId) {
              fetch(`/get-albums/${selectedArtistId}`)
                 .then(response => response.json())
                 .then(albums => {
                   albumSelect.innerHTML = '<option value="" disabled selected>Select Album</option>';
                    if (albums.length > 0) {
                        albums.forEach(album => {
                            const option = document.createElement('option');
                            option.value = album.id;
                            option.textContent = album.name;
                            albumSelect.appendChild(option);
                        });
                        albumSelectGroup.style.display = 'block';
                        newAlbumInputGroup.style.display = 'none';
                    } else {
                         albumSelect.innerHTML = '<option value="" disabled selected>No albums found. Create new one.</option>';
                         albumSelectGroup.style.display = 'block';
                         newAlbumInputGroup.style.display = 'none';

                    }
                })
                  .catch(error => console.error('Error fetching albums:', error));
            } else {
                albumSelectGroup.style.display = 'none';
            }
        });

       createNewAlbumBtn.addEventListener('click',function(){
            albumSelectGroup.style.display = 'none';
            newAlbumInputGroup.style.display = 'block';
        });

        cancelNewAlbumBtn.addEventListener('click',function(){
            newAlbumInputGroup.style.display = 'none';
             if(artistSelect.value)
               albumSelectGroup.style.display = 'block';

        });


    });
</script>
@endsection --}}

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