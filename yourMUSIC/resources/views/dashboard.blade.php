
<x-app-layout>
    <x-slot name="header">
        <p style="font-size: 48px; font-weight: bold; background: linear-gradient(to right, #800080, #FFD700, #00FF00, #0000FF); background-clip: text; -webkit-background-clip: text; color: transparent;">
            Your<span style="background: linear-gradient(to right, #0000FF, #00FF00, #FFD700, #800080); background-clip: text; -webkit-background-clip: text; color: transparent;">MUSIC</span>
        </p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Genres Section -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-bold">Genres</h2>
                            <button class="text-blue-500 hover:text-blue-700" onclick="scrollCarousel('genre-carousel', 'left')">
                                <i class="bi bi-chevron-left text-xl"></i>
                            </button>
                            <button class="text-blue-500 hover:text-blue-700" onclick="scrollCarousel('genre-carousel', 'right')">
                                <i class="bi bi-chevron-right text-xl"></i>
                            </button>
                        </div>
                        <div class="genre-carousel" id="genre-carousel">
                            <div class="genre-container">
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
                                                <p class="text-center text-sm text-gray-500">
                                                    {{ $genre->songs_count }} songs
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Artists Section -->
                    <div class="relative mb-8"> <!-- Thêm class relative -->
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-bold">Artists</h2>
                            <button class="text-blue-500 hover:text-blue-700" onclick="scrollCarousel('album-carousel', 'left')">
                                <i class="bi bi-chevron-left text-xl"></i>
                            </button>
                            <button class="text-blue-500 hover:text-blue-700" onclick="scrollCarousel('album-carousel', 'right')">
                                <i class="bi bi-chevron-right text-xl"></i>
                            </button>
                        </div>
                        <div class="artist-carousel" id="artist-carousel">
                            <div class="artist-container">
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
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-bold">Albums</h2>
                            <button class="text-blue-500 hover:text-blue-700" onclick="scrollCarousel('album-carousel', 'left')">
                                <i class="bi bi-chevron-left text-xl"></i>
                            </button>
                            <button class="text-blue-500 hover:text-blue-700" onclick="scrollCarousel('album-carousel', 'right')">
                                <i class="bi bi-chevron-right text-xl"></i>
                            </button>
                        </div>
                        <div class="album-carousel" id="album-carousel">
                            <div class="album-container">
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

    @push('scripts')
<script>
function scrollCarousel(carouselId, direction) {
    const carousel = document.getElementById(carouselId);
    const container = carousel.querySelector('.genre-container, .artist-container, .album-container');
    const cards = container.children;
    const cardWidth = cards[0].offsetWidth;
    const gap = 20; // Gap between cards as defined in CSS
    
    // Calculate the total width of visible area
    const visibleWidth = carousel.offsetWidth;
    
    // Calculate how many cards can be shown at once
    const cardsPerView = Math.floor(visibleWidth / (cardWidth + gap));
    
    // Calculate scroll amount based on card width and gap
    const scrollAmount = (cardWidth + gap) * cardsPerView;
    
    // Get current scroll position
    const currentScroll = carousel.scrollLeft;
    // Get maximum scroll position
    const maxScroll = container.scrollWidth - carousel.offsetWidth;
    
    if (direction === 'left') {
        // Scroll left by scrollAmount, but not less than 0
        const newScroll = Math.max(0, currentScroll - scrollAmount);
        carousel.scrollTo({
            left: newScroll,
            behavior: 'smooth'
        });
    } else {
        // Scroll right by scrollAmount, but not more than maxScroll
        const newScroll = Math.min(maxScroll, currentScroll + scrollAmount);
        carousel.scrollTo({
            left: newScroll,
            behavior: 'smooth'
        });
    }
    
    // Update button states
    updateScrollButtons(carouselId);
}

function updateScrollButtons(carouselId) {
    const carousel = document.getElementById(carouselId);
    const leftButton = carousel.previousElementSibling.querySelector('.bi-chevron-left').parentElement;
    const rightButton = carousel.previousElementSibling.querySelector('.bi-chevron-right').parentElement;
    
    // Check if we can scroll left
    if (carousel.scrollLeft <= 0) {
        leftButton.classList.add('opacity-50', 'cursor-not-allowed');
        leftButton.classList.remove('hover:text-blue-700');
    } else {
        leftButton.classList.remove('opacity-50', 'cursor-not-allowed');
        leftButton.classList.add('hover:text-blue-700');
    }
    
    // Check if we can scroll right
    if (carousel.scrollLeft >= carousel.scrollWidth - carousel.offsetWidth) {
        rightButton.classList.add('opacity-50', 'cursor-not-allowed');
        rightButton.classList.remove('hover:text-blue-700');
    } else {
        rightButton.classList.remove('opacity-50', 'cursor-not-allowed');
        rightButton.classList.add('hover:text-blue-700');
    }
}

// Initialize scroll buttons state when page loads
document.addEventListener('DOMContentLoaded', function() {
    ['genre-carousel', 'artist-carousel', 'album-carousel'].forEach(id => {
        updateScrollButtons(id);
        
        // Add scroll event listener to update button states while scrolling
        document.getElementById(id).addEventListener('scroll', () => {
            updateScrollButtons(id);
        });
    });
});
</script>
@endpush

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