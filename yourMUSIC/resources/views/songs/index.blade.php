
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Song List</h1>

        <!-- Form tìm kiếm -->
        <form action="{{ route('songs.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by title, artist, album" value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search">Search</i></button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @if($songs->isEmpty())
            <p class="text-muted">No songs found.</p>
        @else
            @foreach ($songs as $song)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $song->title }}</h5>
                            <div class="text-muted mb-3">
                                <p class="mb-1"><i class="bi bi-person"></i> Artist: {{ $song->artist->name }}</p>
                                <p class="mb-1"><i class="bi bi-disc"></i> Album: {{ $song->album ? $song->album->title : 'Không có' }}</p>
                                @if($song->genre)
                                    <p class="mb-1"><i class="bi bi-music-note"></i> Genre: {{ $song->genre }}</p>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{route('songs.show', $song->id)}}" class="btn btn-primary flex-grow-1">
                                    <i class="bi bi-play-fill"></i> Play
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
