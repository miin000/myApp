{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Playlist: {{ $playlist->name }}</h1>

    <div class="row">
        <!-- Song List -->
        <div class="col-md-6">
            <h2>Songs in this playlist</h2>
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            <ul class="list-group">
                @forelse ($playlist->songs as $song)
                    <li class="list-group-item d-flex justify-content-between align-items-center song-item"
                       data-song-id="{{ $song->id }}"
                       data-song-path="{{ asset('storage/' . $song->file_path) }}">
                        {{ $song->title }}
                        <form action="{{ route('playlists.removeSong',[$playlist->id,$song->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </li>
                @empty
                    <li class="list-group-item">No songs in this playlist yet.</li>
                @endforelse
            </ul>
        </div>
        <!-- Music Player  -->
        <div class="col-md-6">
            <h2>Music Player</h2>
            <div class="card">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <audio id="playlistPlayer" controls>
                        {{-- Automatically populate first song from list for demo --}}
                        {{-- @if($playlist->songs->count() > 0)
                          <source src="{{ asset($playlist->songs->first()->file_path) }}" type="audio/mpeg">
                         @endif
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playlistPlayer = document.getElementById('playlistPlayer');
        const songItems = document.querySelectorAll('.song-item');

        songItems.forEach(item => {
            item.addEventListener('click', function() {
                const songPath = this.getAttribute('data-song-path');
                const newSource = document.createElement('source');
                newSource.setAttribute('src', songPath);
                newSource.setAttribute('type', 'audio/mpeg');

                playlistPlayer.innerHTML = ''; //remove all old source elements
                playlistPlayer.appendChild(newSource);
                playlistPlayer.load(); //refresh audio player
                playlistPlayer.play();
            });
        });
    });

</script>
@endsection --}}
@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4 text-center">🎵 Playlist: {{ $playlist->name }}</h1>

    <div class="row">
        <!-- Danh sách bài hát -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📜 Danh sách bài hát</h5>
                </div>
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success m-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    <ul class="list-group list-group-flush">
                        @forelse ($playlist->songs as $index => $song)
                            <li class="list-group-item d-flex justify-content-between align-items-center song-item"
                                data-song-id="{{ $song->id }}"
                                data-song-path="{{ asset('storage/' . $song->file_path) }}">
                                <span class="text-primary fw-bold">#{{ $index + 1 }} - {{ $song->title }}</span>
                                <form action="{{ route('playlists.removeSong',[$playlist->id,$song->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">❌ Xóa</button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-center">Chưa có bài hát nào trong playlist.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Trình phát nhạc -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">🎶 Trình phát nhạc</h5>
                </div>
                <div class="card-body text-center">
                    <h6 id="nowPlaying" class="text-muted mb-3">Chưa có bài hát nào được chọn</h6>
                    <audio id="playlistPlayer" controls class="w-100">
                        @if($playlist->songs->count() > 0)
                            <source src="{{ asset('storage/' . $playlist->songs->first()->file_path) }}" type="audio/mpeg">
                        @endif
                        Trình duyệt của bạn không hỗ trợ phát nhạc.
                    </audio>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playlistPlayer = document.getElementById('playlistPlayer');
        const songItems = document.querySelectorAll('.song-item');
        const nowPlaying = document.getElementById('nowPlaying');

        songItems.forEach(item => {
            item.addEventListener('click', function() {
                const songPath = this.getAttribute('data-song-path');
                const songTitle = this.querySelector('span').innerText;

                // Cập nhật trình phát
                playlistPlayer.src = songPath;
                playlistPlayer.load();
                playlistPlayer.play();

                // Cập nhật bài hát đang phát
                nowPlaying.textContent = "🎵 Đang phát: " + songTitle;
                nowPlaying.classList.add("text-success");
            });

            // Hover để highlight bài hát
            item.addEventListener('mouseover', () => {
                item.classList.add('bg-light');
            });

            item.addEventListener('mouseleave', () => {
                item.classList.remove('bg-light');
            });
        });
    });
</script>

@endsection
