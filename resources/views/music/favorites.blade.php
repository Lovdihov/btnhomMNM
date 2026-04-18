<x-music-layout title="Yêu thích của tôi">
    <div class="flex items-center gap-6 mb-10">
        <div class="p-5 bg-pink-600 rounded-3xl shadow-lg shadow-pink-600/20">
            <i class="fas fa-heart text-3xl text-white"></i>
        </div>
        <div>
            <h2 class="text-4xl font-black text-white">Yêu thích của tôi</h2>
            <p class="text-gray-400">{{ $artists->count() }} nghệ sĩ · {{ $songs->count() }} bài hát</p>
        </div>
    </div>

    {{-- Phần Nghệ Sĩ (Giữ nguyên) --}}
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6 border-l-4 border-pink-500 pl-3">
            <h3 class="text-2xl font-bold text-white">Nghệ sĩ yêu thích</h3>
        </div>
        @if($artists->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($artists as $artist)
                    <div class="relative bg-[#1e2038] rounded-xl p-4 text-center hover:bg-[#2a2d4f] transition-all duration-300 group shadow-lg">
                        <button onclick="toggleFavoriteArtist({{ $artist->id }}, this)" class="absolute top-3 right-3 p-2 z-10 transition hover:scale-110 text-pink-500">
                            <i class="fas fa-heart text-lg"></i>
                        </button>
                        <a href="{{ route('music.artist_detail', $artist->id) }}" class="block">
                            <img src="{{ $artist->avatar_url ?? 'https://via.placeholder.com/128' }}" class="w-28 h-28 mx-auto rounded-full object-cover mb-3">
                            <h3 class="font-bold text-white truncate group-hover:text-pink-400 transition">{{ $artist->name }}</h3>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-center text-gray-500 bg-[#1e2038] rounded-2xl">Chưa quan tâm nghệ sĩ nào.</div>
        @endif
    </div>

    {{-- Phần Bài Hát --}}
    <div>
        <div class="flex justify-between items-center mb-6 border-l-4 border-purple-500 pl-3">
            <h3 class="text-2xl font-bold text-white">Bài hát yêu thích</h3>
        </div>
        @if($songs->count() > 0)
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-xl">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Bài hát</th>
                            <th class="px-6 py-4 hidden md:table-cell">Nghệ sĩ</th>
                            <th class="px-6 py-4 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($songs as $index => $song)
                            @php
                                $coverUrl = $song->cover_url ?? 'https://via.placeholder.com/50';
                                $artistNames = addslashes($song->artists->pluck('name')->join(', '));
                            @endphp
                            
                            <tr onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                                class="hover:bg-white/10 transition-colors group cursor-pointer">
                                
                                <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-purple-400">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $coverUrl }}" class="w-12 h-12 object-cover rounded shadow-lg group-hover:brightness-50 transition">
                                        <div class="font-bold text-white group-hover:text-purple-400 transition">{{ $song->title }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell text-sm text-gray-400">{{ $song->artists->pluck('name')->join(', ') }}</td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-3">
                                        <button onclick="event.stopPropagation(); toggleFavorite({{ $song->id }}, this)" class="text-pink-500 hover:text-gray-400 transition hover:scale-110">
                                            <i class="fas fa-heart text-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 text-center text-gray-500 bg-[#1e2038] rounded-2xl">Chưa thêm bài hát yêu thích nào.</div>
        @endif
    </div>
</x-music-layout>