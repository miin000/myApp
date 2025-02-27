@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Album</h1>
    <form action="{{ route('albums.update', $album->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $album->title }}" required>
        </div>
        <div class="mb-3">
            <label for="artist_id" class="form-label">Artist</label>
            <select name="artist_id" class="form-control" required>
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}" {{ $album->artist_id == $artist->id ? 'selected' : '' }}>{{ $artist->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="cover_image" class="form-label">Cover Image URL</label>
            <input type="text" name="cover_image" class="form-control" value="{{ $album->cover_image }}">
        </div>
        <div class="mb-3">
            <label for="release_date" class="form-label">Release Date</label>
            <input type="date" name="release_date" class="form-control" value="{{ $album->release_date }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Album</button>
    </form>
</div>
@endsection