@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Edit Playlist</h1>
         <form action="{{ route('playlists.update',$playlist->id) }}" method="POST">
            @csrf
           @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Playlist Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$playlist->name}}" required>
                @error('name')
                     <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Playlist</button>
        </form>
    </div>
@endsection