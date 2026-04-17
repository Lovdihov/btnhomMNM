<x-music-layout title="Bảng xếp hạng - ThreeX Music">
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-white mb-6 border-l-4 border-yellow-500 pl-4">Top 20 Bài Hát</h2>
        <div class="bg-[#1e2038] rounded-2xl overflow-hidden shadow-xl">
            @foreach($topSongs as $index => $song)
                <div class="flex items-center justify-between p-4 bg-[#1e2038] hover:bg-white/10 rounded-xl mb-3 border border-gray-800/50 transition-all group shadow-sm hover:shadow-md cursor-pointer">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="relative w-14 h-14 flex-shrink-0">
                            <img src="{{ $song->cover_url }}" class="w-full h-full rounded-lg object-cover shadow-md">
                            <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        
                        <div class="flex flex-col overflow-hidden">
                            <h4 class="text-white font-bold text-base truncate group-hover:text-purple-400 transition-colors">
                                {{ $song->title }}
                            </h4>
                            <p class="text-sm text-gray-400 truncate">
                                {{ $song->artists->pluck('name')->join(', ') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:gap-4 pl-4">
                        
                        @php
                            $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($song->id);
                        @endphp

                        <button @class([
                            'p-2 rounded-full transition-all hover:scale-110',
                            'text-pink-500' => $isFavorited,
                            'text-gray-400 hover:text-pink-500' => !$isFavorited
                        ]) onclick="toggleFavorite({{ $song->id }}, this)">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <button onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $song->cover_url ?? 'https://via.placeholder.com/50' }}', '{{ addslashes($song->artists->pluck('name')->join(', ')) }}', {{ $song->id }})" 
                                class="bg-purple-600 text-white w-10 h-10 flex items-center justify-center rounded-full hover:bg-purple-500 hover:scale-110 transition-all shadow-lg shadow-purple-500/30">
                            <svg class="w-5 h-5 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                            </svg>
                        </button>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-music-layout>