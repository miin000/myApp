@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Artist</h1>
    <form action="{{ route('artists.update', $artist->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $artist->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $artist->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image URL</label>
            <input type="text" name="image" class="form-control" value="{{ $artist->image }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Artist</button>
    </form>
</div>
@endsection