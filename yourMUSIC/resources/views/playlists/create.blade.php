@extends('layouts.app')
@section('content')
     <h2>Create new playlist</h2>
  @if(session('error'))
     <div class="alert danger"> {{session('error')}}</div>
 @endif
<form action="{{ route('playlists.store') }}" method="POST" style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
   @csrf
 <div class="form-group">
   <label for="name">Playlist Name:</label>
      <input type="text" id="name" name="name" value="{{old('name')}}" required>
    @error('name') <p class="error-message">{{$message}}</p>@enderror
</div>
<button type="submit" class="btn btn-primary">Create</button>
</form>
   @endsection