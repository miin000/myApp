@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <h1>{{ $song->title }}</h1>
            <div class="text-muted">
                <p class="mb-1">
                    Artist: {{ $song->artist->name }}
                    @if($song->album)
                        | Album: {{ $song->album->title }}
                    @endif
                </p>
                @if($song->genre)
                    <p class="mb-1">Genre: {{ $song->genre }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <div class="artist-image-container">
                <img src="{{ asset('storage/' . $song->artist->image) }}" alt="{{ $song->artist->name }}" class="artist-image rounded-circle">
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <audio id="audioPlayer" class="w-100" controls>
                <source src="{{ asset('storage/' . $song->file_path) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>

            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('songs.prev', $song->id) }}" class="btn btn-outline-primary">
                    <i class="bi bi-skip-backward-fill"></i> Previous
                </a>
                <a href="{{ route('songs.next', $song->id) }}" class="btn btn-outline-primary">
                    Next <i class="bi bi-skip-forward-fill"></i>
                </a>
            </div>
        </div>
    </div>

    @auth
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Add to Playlist</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse(Auth::user()->playlists as $playlist)
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('playlists.show', $playlist->id) }}" class="text-decoration-none">
                                <div class="card h-100 listPlay">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $playlist->name }}</h5>
                                        <p class="card-text small text-muted">
                                            {{ $playlist->songs->count() }} songs
                                        </p>
                                        <form action="{{ route('playlists.addSong', [$playlist->id, $song->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                Add to this playlist
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">You don't have any playlists yet.</p>
                        </div>
                    @endforelse
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <a href="{{ route('playlists.create') }}" class="btn btn-outline-primary">
                                    <i class="bi bi-plus-lg"></i> Create New Playlist
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
</div>

<style>
    .listPlay {
        transition: background-color 0.3s ease;
    }

    .listPlay:hover {
        background-color: #f0f0f0;
    }

    .listPlay button {
        position: relative;
        z-index: 2;
    }

    .artist-image-container {
        width: 200px; /* Adjust as needed */
        height: 200px; /* Adjust as needed */
        margin: 0 auto;
    }

    .artist-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensure image covers the container */
        animation: rotate 20s linear infinite; /* Rotate animation */
    }

    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>

@push('scripts')
<script>
    const audioPlayer = document.getElementById('audioPlayer');
    let isPlaying = false; // Track the playing state

    audioPlayer.addEventListener('timeupdate', () => {
        localStorage.setItem('audioPosition', audioPlayer.currentTime);
    });

    window.addEventListener('load', () => {
        const savedPosition = localStorage.getItem('audioPosition');
        if (savedPosition !== null) {
            audioPlayer.currentTime = parseFloat(savedPosition);
        }
    });
</script>
@endpush

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@endsection