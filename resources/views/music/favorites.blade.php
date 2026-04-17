<x-music-layout title="Yêu thích của tôi">

    {{-- Header --}}
    <div class="flex items-center gap-6 mb-10">
        <div class="p-5 bg-pink-600 rounded-3xl shadow-lg shadow-pink-600/20">
            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
            </svg>
        </div>
        <div>
            <h2 class="text-4xl font-black text-white">Yêu thích của tôi</h2>
            <p class="text-gray-400">{{ $artists->count() }} nghệ sĩ · {{ $songs->count() }} bài hát</p>
        </div>
    </div>

    {{-- ===================== PHẦN NGHỆ SĨ ===================== --}}
    <div class="mb-12">
        <div class="flex justify-between items-center mb-6 border-l-4 border-pink-500 pl-3">
            <h3 class="text-2xl font-bold text-white">Nghệ sĩ yêu thích</h3>
            <span class="text-sm text-gray-500">{{ $artists->count() }} nghệ sĩ</span>
        </div>

        @if($artists->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($artists as $artist)
                    <div class="relative bg-[#1e2038] rounded-xl p-4 text-center hover:bg-[#2a2d4f] transition-all duration-300 group shadow-lg">

                        {{-- Nút bỏ yêu thích --}}
                        <button onclick="toggleFavoriteArtist({{ $artist->id }}, this)"
                                class="absolute top-3 right-3 p-2 z-10 transition hover:scale-110 text-pink-500">
                            <i class="fas fa-heart text-lg"></i>
                        </button>

                        <a href="{{ route('music.artist_detail', $artist->id) }}" class="block">
                            <img src="{{ $artist->avatar_url ?? 'https://via.placeholder.com/128' }}"
                                 alt="{{ $artist->name }}"
                                 class="w-28 h-28 mx-auto rounded-full object-cover mb-3 border-2 border-transparent group-hover:border-pink-500 group-hover:scale-105 transition duration-500 shadow-lg">
                            <h3 class="font-bold text-white truncate group-hover:text-pink-400 transition">{{ $artist->name }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ number_format($artist->follower_count ?? 0) }} quan tâm</p>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-center bg-[#1e2038] rounded-2xl border border-dashed border-gray-700">
                <i class="fas fa-user-music fa-2x text-gray-600 mb-3 block"></i>
                <p class="text-gray-500 text-sm">Bạn chưa quan tâm nghệ sĩ nào.</p>
                <a href="{{ route('artists') }}" class="mt-3 inline-block text-purple-400 hover:text-purple-300 text-sm transition">Khám phá nghệ sĩ →</a>
            </div>
        @endif
    </div>

    {{-- ===================== PHẦN BÀI HÁT ===================== --}}
    <div>
        <div class="flex justify-between items-center mb-6 border-l-4 border-purple-500 pl-3">
            <h3 class="text-2xl font-bold text-white">Bài hát yêu thích</h3>
            <span class="text-sm text-gray-500">{{ $songs->count() }} bài hát</span>
        </div>

        @if($songs->count() > 0)
            <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-xl">
                <table class="w-full text-left text-gray-300">
                    <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-medium">#</th>
                            <th class="px-6 py-4 font-medium">Bài hát</th>
                            <th class="px-6 py-4 font-medium hidden md:table-cell">Nghệ sĩ</th>
                            <th class="px-6 py-4 font-medium text-center hidden md:table-cell">Lượt nghe</th>
                            <th class="px-6 py-4 font-medium text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($songs as $index => $song)
                            @php
                                $coverUrl = $song->cover_url ?? 'https://via.placeholder.com/50';
                                $artistNames = addslashes($song->artists->pluck('name')->join(', '));
                            @endphp
                            <tr class="hover:bg-white/10 transition-colors group">

                                <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-purple-400 transition">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative w-12 h-12 flex-shrink-0 group/img">
                                            <img src="{{ $coverUrl }}" class="w-full h-full object-cover rounded shadow-lg group-hover/img:brightness-50 transition" alt="Cover">
                                            <button onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                                                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 text-white transition">
                                                <i class="fas fa-play text-xs"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <div class="font-bold text-white group-hover:text-purple-400 transition truncate max-w-[180px]">{{ $song->title }}</div>
                                            <div class="text-xs text-gray-500 md:hidden">{{ $song->artists->pluck('name')->join(', ') }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 hidden md:table-cell text-sm text-gray-400">
                                    {{ $song->artists->pluck('name')->join(', ') }}
                                </td>

                                <td class="px-6 py-4 text-center hidden md:table-cell">
                                    <span class="text-xs bg-gray-800 px-2 py-1 rounded text-gray-400">{{ number_format($song->play_count) }}</span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-3">
                                        {{-- Nút bỏ yêu thích --}}
                                        <button onclick="toggleFavorite({{ $song->id }}, this)"
                                                class="text-pink-500 hover:text-gray-400 transition hover:scale-110">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        {{-- Nút phát --}}
                                        <button onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                                                class="text-gray-400 hover:text-purple-400 transition hover:scale-110">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 text-center bg-[#1e2038] rounded-2xl border border-dashed border-gray-700">
                <i class="fas fa-music fa-2x text-gray-600 mb-3 block"></i>
                <p class="text-gray-500 text-sm">Bạn chưa thêm bài hát yêu thích nào.</p>
                <a href="{{ route('songs') }}" class="mt-3 inline-block text-purple-400 hover:text-purple-300 text-sm transition">Khám phá bài hát →</a>
            </div>
        @endif
    </div>

</x-music-layout>