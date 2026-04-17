<x-music-layout title="Nghệ sĩ - ThreeX Music">
    <h2 class="text-3xl font-bold text-white mb-8 border-l-4 border-purple-500 pl-4">Danh sách Nghệ sĩ</h2>
    <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
        @foreach($artists as $artist)
            @php
                $isFavArtist = Auth::check() && Auth::user()->favoriteArtists->contains($artist->id);
            @endphp
            <div class="relative bg-[#1e2038] rounded-xl p-6 text-center hover:bg-[#2a2d4f] transition duration-300 group cursor-pointer shadow-lg">

                {{-- Nút yêu thích --}}
                <button onclick="toggleFavoriteArtist({{ $artist->id }}, this)"
                        class="absolute top-3 right-3 p-2 z-10 transition hover:scale-110 {{ $isFavArtist ? 'text-pink-500' : 'text-gray-500 hover:text-pink-500' }}">
                    <i class="{{ $isFavArtist ? 'fas' : 'far' }} fa-heart text-lg"></i>
                </button>

                <a href="{{ route('music.artist_detail', $artist->id) }}" class="block">
                    <img src="{{ $artist->avatar_url ?? 'https://via.placeholder.com/128' }}"
                         class="w-32 h-32 mx-auto rounded-full object-cover mb-4 group-hover:scale-110 transition duration-500 border-2 border-transparent group-hover:border-purple-500">
                    <h3 class="text-lg font-bold text-white truncate group-hover:text-purple-400 transition">{{ $artist->name }}</h3>
                    <p class="text-sm text-gray-400">{{ number_format($artist->follower_count) }} quan tâm</p>
                </a>
            </div>
        @endforeach
    </div>

</x-music-layout>