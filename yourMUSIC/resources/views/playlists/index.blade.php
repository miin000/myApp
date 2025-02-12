
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">My Playlists</h2>
                    <a href="{{ route('playlists.create') }}" class="btn btn-light">
                        <i class="fas fa-plus me-2"></i>Create New Playlist
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($playlists->count() > 0)
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach ($playlists as $playlist)
                                <div class="col">
                                    <div class="card h-100 playlist-card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $playlist->name }}</h5>
                                            <p class="card-text text-muted">
                                                {{ $playlist->songs_count ?? 0 }} songs
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                                            <a href="{{ route('playlists.show', $playlist->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>View
                                            </a>
                                            @if(Auth::user()->id == $playlist->user_id)
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('playlists.edit', $playlist->id) }}" class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('playlists.destroy', $playlist->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this playlist?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                                            <i class="fas fa-trash me-1"></i>Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info text-center" role="alert">
                            You haven't created any playlists yet. 
                            <a href="{{ route('playlists.create') }}" class="alert-link">Create your first playlist!</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.playlist-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.playlist-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}
</style>

@endsection