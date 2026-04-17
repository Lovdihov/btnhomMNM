<x-music-layout title="{{ $artist->name }} - ThreeX Music">
    <div class="container mx-auto px-4 py-8">

        {{-- Hero Banner --}}
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-gray-900 to-black p-8 md:p-12 mb-10 shadow-2xl">
            <div class="relative z-10 flex flex-col md:flex-row items-center md:items-end gap-8">

                <img src="{{ $artist->avatar_url ?? 'https://via.placeholder.com/200' }}"
                     alt="{{ $artist->name }}"
                     class="w-40 h-40 rounded-full object-cover shadow-2xl border-4 border-purple-500/50 flex-shrink-0">

                <div class="flex-1 text-center md:text-left">
                    <nav class="flex justify-center md:justify-start mb-3 text-sm text-gray-400">
                        <a href="{{ route('artists') }}" class="hover:text-purple-400 transition">Nghệ sĩ</a>
                        <span class="mx-2">/</span>
                        <span class="text-white">{{ $artist->name }}</span>
                    </nav>

                    <h1 class="text-5xl md:text-6xl font-black text-white mb-3 tracking-tight">
                        {{ $artist->name }}
                    </h1>

                    @if($artist->bio)
                        <p class="text-gray-400 text-base max-w-2xl mb-5 line-clamp-2">{{ $artist->bio }}</p>
                    @endif

                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-3">
                        <span class="bg-purple-500 text-white px-4 py-1 rounded-full text-sm font-bold shadow-lg shadow-purple-500/30">
                            {{ number_format($artist->follower_count) }} quan tâm
                        </span>
                        <span class="bg-white/10 text-white px-4 py-1 rounded-full text-sm font-medium border border-white/10">
                            {{ $songs->total() }} bài hát
                        </span>

                        @php
                            $isFavArtist = Auth::check() && Auth::user()->favoriteArtists->contains($artist->id);
                        @endphp
                        <button id="btn-fav-artist"
                                onclick="toggleFavoriteArtist({{ $artist->id }}, this)"
                                class="flex items-center gap-2 px-5 py-2 rounded-full text-sm font-bold border transition hover:scale-105
                                       {{ $isFavArtist
                                            ? 'bg-pink-500/20 border-pink-500 text-pink-400'
                                            : 'bg-white/10 border-gray-600 text-gray-300 hover:border-pink-500 hover:text-pink-400' }}">
                            <i class="{{ $isFavArtist ? 'fas' : 'far' }} fa-heart"></i>
                            {{ $isFavArtist ? 'Đang quan tâm' : 'Quan tâm' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Danh sách bài hát --}}
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-xl">
            <table class="w-full text-left text-gray-300">
                <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-medium">#</th>
                        <th class="px-6 py-4 font-medium">Bài hát</th>
                        <th class="px-6 py-4 font-medium hidden md:table-cell">Album</th>
                        <th class="px-6 py-4 font-medium text-center">Lượt nghe</th>
                        <th class="px-6 py-4 font-medium text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($songs as $index => $song)
                        @php
                            $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($song->id);
                            $coverUrl = $song->cover_url ?? 'https://via.placeholder.com/50';
                            $artistNames = addslashes($song->artists->pluck('name')->join(', '));
                        @endphp
                        <tr class="hover:bg-white/10 transition-colors group cursor-pointer">

                            <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-purple-400 transition">
                                {{ ($songs->currentPage() - 1) * $songs->perPage() + $index + 1 }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12 flex-shrink-0 group/img">
                                        <img src="{{ $coverUrl }}" class="w-full h-full object-cover rounded shadow-lg group-hover/img:brightness-50 transition" alt="Cover">
                                        <button onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 text-white transition hover:scale-110">
                                            <i class="fas fa-play text-xs"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white group-hover:text-purple-400 transition">{{ $song->title }}</div>
                                        <div class="text-xs md:hidden text-gray-500">{{ $song->artists->pluck('name')->join(', ') }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell">
                                @if($song->album)
                                    <span class="text-sm text-gray-400">{{ $song->album->title }}</span>
                                @else
                                    <span class="text-sm text-gray-600">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="text-xs bg-gray-800 px-2 py-1 rounded text-gray-400">{{ number_format($song->play_count) }}</span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    <button onclick="toggleFavorite({{ $song->id }}, this)"
                                            class="transition hover:scale-110 {{ $isFavorited ? 'text-pink-500' : 'text-gray-500 hover:text-pink-500' }}">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <button onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                                            class="text-gray-400 hover:text-purple-400 transition hover:scale-110">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-music fa-3x mb-4 opacity-20"></i>
                                    <p>Nghệ sĩ này chưa có bài hát nào.</p>
                                    <a href="{{ route('artists') }}" class="mt-4 inline-block text-purple-500 hover:underline">Quay lại danh sách nghệ sĩ</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">{{ $songs->links() }}</div>
    </div>
</x-music-layout>