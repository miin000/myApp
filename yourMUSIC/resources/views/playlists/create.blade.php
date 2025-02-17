@extends('layouts.app')
@section('content')
     <h1 style=" text-align: center;">Create new playlist</h1>
  @if(session('error'))
     <div class="alert danger"> {{session('error')}}</div>
 @endif
<form action="{{ route('playlists.store') }}" method="POST" style="max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
   @csrf
   <div class="form-group">
      <label for="name">Playlist Name:</label>
      <input type="text" style="width: 300px;" id="name" name="name" value="{{old('name')}}" required>
      <button type="submit" style="position:relative;" class="btn btn-primary">Create</button>
      @error('name') <p class="error-message">{{$message}}</p>@enderror
   </div>
   <img src="../storage/images/test.png" alt="">
</form>
   @endsection