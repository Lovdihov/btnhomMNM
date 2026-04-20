<x-music-layout title="{{ $album->title }} - ThreeX Music">
    <div class="container mx-auto px-4 py-8">

        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-gray-900 to-black p-8 md:p-12 mb-10 shadow-2xl">
            <div class="relative z-10 flex flex-col md:flex-row items-center md:items-end gap-8">
                <img src="{{ $album->cover_url ?? 'https://via.placeholder.com/200' }}" class="w-48 h-48 rounded-xl object-cover shadow-2xl border border-gray-700 flex-shrink-0">
                <div class="flex-1 text-center md:text-left">
                    <nav class="flex justify-center md:justify-start mb-3 text-sm text-gray-400">
                        <a href="{{ route('albums') }}" class="hover:text-green-400 transition">Album</a>
                        <span class="mx-2">/</span>
                        <span class="text-white">{{ $album->title }}</span>
                    </nav>
                    <h1 class="text-5xl md:text-6xl font-black text-white mb-3 tracking-tight">{{ $album->title }}</h1>
                    <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 mt-6">
                        <span class="bg-green-600 text-white px-4 py-1 rounded-full text-sm font-bold shadow-lg shadow-green-600/30">{{ number_format($album->play_count ?? 0) }} lượt nghe</span>
                        <span class="bg-white/10 text-white px-4 py-1 rounded-full text-sm font-medium border border-white/10">{{ $songs->total() }} bài hát</span>
                    </div>
                </div>
            </div>
            <div class="absolute right-0 top-0 bottom-0 w-2/3 opacity-20 pointer-events-none" style="background-image: url('{{ $album->cover_url }}'); background-size: cover; background-position: center; filter: blur(40px); mask-image: linear-gradient(to left, black, transparent);"></div>
        </div>

        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-xl">
            <table class="w-full text-left text-gray-300">
                <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-medium">#</th>
                        <th class="px-6 py-4 font-medium">Bài hát</th>
                        <th class="px-6 py-4 font-medium hidden md:table-cell">Nghệ sĩ</th>
                        <th class="px-6 py-4 font-medium text-center">Lượt nghe</th>
                        <th class="px-6 py-4 font-medium text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($songs as $index => $song)
                        @php
                            $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($song->id);
                            $coverUrl = $song->cover_url ?? $album->cover_url ?? 'https://via.placeholder.com/50';
                            $artistNames = addslashes($song->artists->pluck('name')->join(', '));
                        @endphp
                        
                        {{-- Click vào thẻ TR để phát nhạc --}}
                        <tr onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                            class="hover:bg-white/10 transition-colors group cursor-pointer">

                            <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-green-400 transition">
                                {{ ($songs->currentPage() - 1) * $songs->perPage() + $index + 1 }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12 flex-shrink-0 group/img">
                                        <img src="{{ $coverUrl }}" class="w-full h-full object-cover rounded shadow-lg group-hover/img:brightness-50 transition" alt="Cover">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 text-white transition hover:scale-110">
                                            <i class="fas fa-play text-xs"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white group-hover:text-green-400 transition">{{ $song->title }}</div>
                                        <div class="text-xs md:hidden text-gray-500">{{ $song->artists->pluck('name')->join(', ') }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="text-sm text-gray-400">{{ $song->artists->pluck('name')->join(', ') }}</span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="text-xs bg-gray-800 px-2 py-1 rounded text-gray-400">{{ number_format($song->play_count) }}</span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    {{-- Chặn click nổi bọt --}}
                                    <button onclick="event.stopPropagation(); toggleFavorite({{ $song->id }}, this)"
                                            class="transition hover:scale-110 {{ $isFavorited ? 'text-pink-500' : 'text-gray-500 hover:text-pink-500' }}">
                                        <i class="fas fa-heart text-lg"></i>
                                    </button>
                                    <div class="text-gray-400 hover:text-green-400 transition hover:scale-110">
                                        <i class="fas fa-play-circle text-lg"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-gray-500">
                                Album này hiện chưa có bài hát nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">{{ $songs->links() }}</div>
    </div>
</x-music-layout>