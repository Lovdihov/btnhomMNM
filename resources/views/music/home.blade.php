<x-music-layout title="Trang chủ - ThreeX Music">

    {{-- Bài hát mới nhất --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-6 border-l-4 border-blue-500 pl-3">
            <h2 class="text-2xl font-bold text-white">Bài hát mới nhất</h2>
            <a href="{{ route('songs') }}" class="text-sm text-gray-400 hover:text-white transition">Xem tất cả →</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($latestSongs as $song)
                @php
                    $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($song->id);
                    // ✅ FIX: Dùng null-coalescing để tránh lỗi khi cover_url null
                    $coverUrl = $song->cover_url ?? 'https://via.placeholder.com/300';
                    $artistNames = addslashes($song->artists->pluck('name')->join(', '));
                @endphp

                <div class="relative bg-[#1e2038] rounded-xl p-4 hover:bg-[#2a2d4f] hover:-translate-y-1 transition-all duration-300 group cursor-pointer shadow-lg shadow-black/20">

                    <button @class([
                        'absolute top-6 right-6 bg-black/60 rounded-full p-2 hover:text-pink-500 z-10 transition',
                        'text-pink-500' => $isFavorited,
                        'text-gray-300' => !$isFavorited
                    ]) onclick="toggleFavorite({{ $song->id }}, this)">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    
                    <div onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                         class="relative mb-4 overflow-hidden rounded-lg cursor-pointer group">
                        <img src="{{ $coverUrl }}" alt="{{ $song->title }}" 
                             class="w-full aspect-square object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300">
                            <button class="bg-purple-600 rounded-full p-3 transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-white truncate">{{ $song->title }}</h3>
                    <p class="text-sm text-gray-400 truncate">{{ $song->artists->pluck('name')->join(', ') }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Album Hot --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-6 border-l-4 border-green-500 pl-3">
            <h2 class="text-2xl font-bold text-white">Album Hot</h2>
            <a href="{{ route('albums') }}" class="text-sm text-gray-400 hover:text-white transition">Xem tất cả →</a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($topAlbums as $album)
                @php
                    $albumCover = $album->cover_url ?? 'https://via.placeholder.com/300';
                @endphp
                
                <a href="{{ route('album_detail', $album->id) }}" 
                class="block bg-[#1e2038] rounded-xl p-4 hover:bg-[#2a2d4f] transition duration-300 group shadow-lg shadow-black/20">
                    
                    <div class="relative mb-4 overflow-hidden rounded-lg shadow-md">
                        <img src="{{ $albumCover }}" alt="{{ $album->title }}" 
                            class="w-full aspect-square object-cover group-hover:scale-110 transition duration-700">
                        
                        <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition duration-300"></div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-white truncate group-hover:text-green-400 transition">
                        {{ $album->title }}
                    </h3>
                    <p class="text-sm text-gray-400 mt-1">
                        {{ $album->release_date ? date('Y', strtotime($album->release_date)) : 'N/A' }} 
                        • {{ number_format($album->play_count) }} lượt nghe
                    </p>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Nghệ Sĩ Nổi Bật --}}
    <div class="mb-10">
        <div class="flex justify-between items-center mb-6 border-l-4 border-purple-500 pl-3">
            <h2 class="text-2xl font-bold text-white">Nghệ Sĩ Nổi Bật</h2>
            <a href="{{ route('artists') }}" class="text-sm text-gray-400 hover:text-white transition">Xem tất cả →</a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($topArtists as $artist)
                @php
                    $isFavArtist = Auth::check() && Auth::user()->favoriteArtists->contains($artist->id);
                    $avatarUrl = $artist->avatar_url ?? 'https://via.placeholder.com/128';
                @endphp
                <div class="relative bg-[#1e2038] rounded-xl p-6 text-center hover:bg-[#2a2d4f] transition duration-300 group shadow-lg">
                    
                    <button onclick="toggleFavoriteArtist({{ $artist->id }}, this)" 
                            class="absolute top-3 right-3 p-2 z-10 transition hover:scale-110 {{ $isFavArtist ? 'text-pink-500' : 'text-gray-500 hover:text-pink-500' }}">
                        <i class="{{ $isFavArtist ? 'fas' : 'far' }} fa-heart text-xl"></i>
                    </button>

                    <a href="{{ route('music.artist_detail', $artist->id) }}" class="block cursor-pointer">
                        <img src="{{ $avatarUrl }}" alt="{{ $artist->name }}" 
                             class="w-32 h-32 mx-auto rounded-full object-cover mb-4 shadow-lg group-hover:scale-110 transition duration-500 border-2 border-transparent group-hover:border-purple-500">
                        <h3 class="text-lg font-bold text-white truncate group-hover:text-purple-400 transition">{{ $artist->name }}</h3>
                        <p class="text-sm text-gray-400">{{ number_format($artist->follower_count) }} quan tâm</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-music-layout>