@extends('layouts.app')
@section('content')
       <h2>Edit Playlist</h2>
          @if(session('error'))
      <div class="alert danger">{{session('error')}}</div>
  @endif
  <form action="{{ route('playlists.update', $playlist) }}" method="POST"  style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    @csrf
           @method('PUT')
    <div class="form-group">
       <label for="name">Playlist Name:</label>
        <input type="text" id="name" name="name" value="{{$playlist->name}}" required>
        @error('name')<p class="error-message">{{$message}}</p>@enderror

</div>
     <button type="submit" class="btn btn-primary">Update</button>
     </form>
       @endsection
   