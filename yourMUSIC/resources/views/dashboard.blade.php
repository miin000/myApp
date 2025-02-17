<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('welcome') }}" style="text-decoration: none;">
            <p style="font-size: 48px; font-weight: bold; background: linear-gradient(to right, #800080, #FFD700, #00FF00, #0000FF); background-clip: text; -webkit-background-clip: text; color: transparent;">
                Your<span style="background: linear-gradient(to right, #0000FF, #00FF00, #FFD700, #800080); background-clip: text; -webkit-background-clip: text; color: transparent;">MUSIC</span>
            </p>
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Genres Section -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Genres</h2>
                        <div class="scrollable-section" id="genre-carousel">
                            <div class="content-container">
                                @foreach($genres as $genre)
                                    <a href="{{ route('genres.show', ['genre' => $genre->genre]) }}" class="block">
                                        <div class="genre-card hover:scale-105 transition-transform duration-200">
                                            <div class="genre-image">
                                                <div class="w-[150px] h-[150px] rounded bg-gradient-to-r from-pink-400 to-orange-500 flex items-center justify-center">
                                                    <span class="text-3xl text-white">{{ strtoupper(substr($genre->genre, 0, 1)) }}</span>
                                                </div>
                                            </div>
                                            <div class="genre-name">
                                                <p class="text-center mt-2 font-semibold truncate">{{$genre->genre}}</p>
                                                <p class="text-center text-sm text-gray-500">{{ $genre->songs_count }} songs</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Artists Section -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-4">Artists</h2>
                        <div class="scrollable-section" id="artist-carousel">
                            <div class="content-container">
                                @foreach($artists as $artist)
                                    <a href="{{ route('artists.show', $artist) }}" class="block">
                                        <div class="artist-card hover:scale-105 transition-transform duration-200">
                                            <div class="artist-image">
                                                @if($artist->image)
                                                    <img src="{{ asset('storage/' . $artist->image) }}" alt="{{$artist->name}}" class="rounded-full">
                                                @else
                                                    <div class="w-[150px] h-[150px] rounded-full bg-gradient-to-r from-purple-400 to-blue-500 flex items-center justify-center">
                                                        <span class="text-3xl text-white">{{ strtoupper(substr($artist->name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="artist-name">
                                                <p class="text-center mt-2 font-semibold truncate">{{$artist->name}}</p>
                                                <p class="text-center text-sm text-gray-500">{{ $artist->songs->count() }} songs</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Albums Section -->
                    <div>
                        <h2 class="text-2xl font-bold mb-4">Albums</h2>
                        <div class="scrollable-section" id="album-carousel">
                            <div class="content-container">
                                @foreach($albums as $album)
                                    <a href="{{ route('albums.show', $album) }}" class="block">
                                        <div class="album-card hover:scale-105 transition-transform duration-200">
                                            <div class="album-image">
                                                @if($album->cover_image)
                                                    <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{$album->title}}" class="rounded">
                                                @else
                                                    <div class="w-[150px] h-[150px] rounded bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center">
                                                        <span class="text-3xl text-white">{{ strtoupper(substr($album->title, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="album-name">
                                                <p class="text-center mt-2 font-semibold truncate">{{$album->title}}</p>
                                                <p class="text-center text-sm text-gray-500">{{ $album->songs->count() }} songs</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    /* Base styles for scrollable sections */
    .scrollable-section {
        width: 100%;
        overflow-x: auto;
        padding-bottom: 20px;
        white-space: nowrap;
        scrollbar-width: thin;
        -ms-overflow-style: none;
        scroll-behavior: smooth;
    }

    /* Custom scrollbar styling */
    .scrollable-section::-webkit-scrollbar {
        height: 8px;
    }

    .scrollable-section::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .scrollable-section::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
        transition: background 0.3s ease;
    }

    .scrollable-section::-webkit-scrollbar-thumb:hover {
        background: #666;
    }

    /* Content container styles */
    .content-container {
        display: inline-flex;
        gap: 20px;
        padding: 10px 0;
    }

    /* Card styles */
    .genre-card, .artist-card, .album-card {
        text-align: center;
        min-width: 150px;
        max-width: 200px;
    }

    /* Image styles */
    .genre-image img, .artist-image img, .album-image img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .artist-image img {
        border-radius: 50%;
    }

    /* Link styles */
    .scrollable-section a {
        text-decoration: none;
        color: inherit;
        display: inline-block;
    }

    /* Hover effects */
    .genre-card:hover, .artist-card:hover, .album-card:hover {
        transform: translateY(-5px);
        transition: transform 0.2s ease-in-out;
        cursor: pointer;
    }

    /* Name styles */
    .genre-name, .artist-name, .album-name {
        margin-top: 8px;
    }

    /* Ensure text remains wrapped */
    .genre-name p, .artist-name p, .album-name p {
        white-space: normal;
    }
    </style>
</x-app-layout>

<style>
.artist-carousel, .album-carousel {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 20px;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.artist-carousel::-webkit-scrollbar, .album-carousel::-webkit-scrollbar {
    display: none;
}

.artist-container, .album-container {
    display: inline-flex;
    gap: 20px;
    padding: 10px;
}

.artist-card, .album-card {
    text-align: center;
    min-width: 150px;
    max-width: 200px;
}

.artist-image img, .album-image img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Smooth scrolling */
.artist-carousel, .album-carousel {
    scroll-behavior: smooth;
}

/* Hover effects */
.artist-card:hover, .album-card:hover {
    transform: translateY(-5px);
    transition: transform 0.2s ease-in-out;
}

.artist-carousel a, .album-carousel a {
    text-decoration: none;
    color: inherit;
}

.artist-card:hover, .album-card:hover {
    transform: translateY(-5px);
    transition: transform 0.2s ease-in-out;
    cursor: pointer;
}

.genre-carousel {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 20px;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.genre-carousel::-webkit-scrollbar {
    display: none;
}

.genre-container {
    display: inline-flex;
    gap: 20px;
    padding: 10px;
}

.genre-card {
    text-align: center;
    min-width: 150px;
    max-width: 200px;
}

.genre-image img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.genre-carousel a {
    text-decoration: none;
    color: inherit;
}

.genre-card:hover {
    transform: translateY(-5px);
    transition: transform 0.2s ease-in-out;
    cursor: pointer;
}
</style>