@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh sửa bài hát</h2>

    <form action="{{ route('songs.update', $song->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Tên bài hát</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $song->title }}" required>
        </div>

        <div class="form-group">
            <label for="artist_id">Ca sĩ</label>
            <select id="artist_id" name="artist_id" class="form-control">
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}" {{ $artist->id == $song->artist_id ? 'selected' : '' }}>
                        {{ $artist->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="album_id">Album</label>
            <select id="album_id" name="album_id" class="form-control">
                @foreach($albums as $album)
                    <option value="{{ $album->id }}" {{ $album->id == $song->album_id ? 'selected' : '' }}>
                        {{ $album->title }} - {{ $album->artist->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Thể loại</label>
            <input type="text" name="genre" id="genre" class="form-control" value="{{ $song->genre }}">
        </div>

        <div class="mb-3">
            <label for="song_file" class="form-label">Tập tin nhạc (MP3)</label>
            <input type="file" name="song_file" id="song_file" class="form-control">
            @if($song->file_path)
                <p>File hiện tại: <a href="{{ asset('storage/' . $song->file_path) }}" target="_blank">Nghe nhạc</a></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('songs.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
