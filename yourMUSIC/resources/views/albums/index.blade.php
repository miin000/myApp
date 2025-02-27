@extends('layouts.app')

@section('content')
<a href="{{ route('albums.edit', $album->id) }}" class="btn btn-warning">Edit Album</a>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <p class="text-muted"> {{ $album->songs->count() }} bài hát </p>
        </div>
    </div>

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
                        @forelse ($album->songs as $index => $song)
                            <li class="list-group-item d-flex justify-content-between align-items-center song-item"
                                data-song-id="{{ $song->id }}"
                                data-song-path="{{ asset('storage/' . $song->file_path) }}"
                                data-song-title="{{ $song->title }}">
                                <span class="text-primary fw-bold">#{{ $index + 1 }} - {{ $song->title }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-center">Chưa có bài hát nào trong album này.</li>
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
                        @if($album->songs->count() > 0)
                            <source src="{{ asset('storage/' . $album->songs->first()->file_path) }}" type="audio/mpeg">
                        @endif
                        Trình duyệt của bạn không hỗ trợ phát nhạc.
                    </audio>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .song-item:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const playlistPlayer = document.getElementById('playlistPlayer');
        const songItems = document.querySelectorAll('.song-item');
        const nowPlaying = document.getElementById('nowPlaying');

        songItems.forEach(item => {
            item.addEventListener('click', function() {
                const songPath = this.getAttribute('data-song-path');
                const songTitle = this.getAttribute('data-song-title');

                playlistPlayer.src = songPath;
                playlistPlayer.load();
                playlistPlayer.play();

                nowPlaying.textContent = "🎵 Đang phát: " + songTitle;
                nowPlaying.classList.add("text-success");
            });
        });
    });
</script>

@endsection