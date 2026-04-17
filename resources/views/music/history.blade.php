<x-music-layout title="Lịch sử nghe - ThreeX Music">
    <div class="flex items-center gap-6 mb-10">
        <div class="p-5 bg-blue-600 rounded-3xl shadow-lg shadow-blue-600/20">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <h2 class="text-4xl font-black text-white">Lịch sử nghe</h2>
            <p class="text-gray-400">{{ $histories->count() }} bài hát đã nghe gần đây</p>
        </div>
    </div>

    @if($histories->count() > 0)
        <div class="bg-white/5 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden shadow-xl">
            <table class="w-full text-left text-gray-300">
                <thead class="bg-white/5 text-gray-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-medium">#</th>
                        <th class="px-6 py-4 font-medium">Bài hát</th>
                        <th class="px-6 py-4 font-medium hidden md:table-cell">Nghệ sĩ</th>
                        <th class="px-6 py-4 font-medium hidden md:table-cell">Nghe lúc</th>
                        <th class="px-6 py-4 font-medium text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($histories as $index => $history)
                        @php
                            $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($history->song->id);
                            $coverUrl = $history->song->cover_url ?? 'https://via.placeholder.com/50';
                            $artistNames = addslashes($history->song->artists->pluck('name')->join(', '));
                        @endphp
                        <tr class="hover:bg-white/10 transition-colors group cursor-pointer">

                            <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-blue-400 transition">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12 flex-shrink-0 group/img">
                                        <img src="{{ $coverUrl }}" class="w-full h-full object-cover rounded shadow-lg group-hover/img:brightness-50 transition" alt="Cover">
                                        <button onclick="playSong('{{ $history->song->audio_url }}', '{{ addslashes($history->song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $history->song->id }})"
                                                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 text-white transition hover:scale-110">
                                            <i class="fas fa-play text-xs"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white group-hover:text-blue-400 transition">{{ $history->song->title }}</div>
                                        <div class="text-xs md:hidden text-gray-500">{{ $history->song->artists->pluck('name')->join(', ') }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="text-sm text-gray-400">{{ $history->song->artists->pluck('name')->join(', ') }}</span>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="text-xs text-gray-500">{{ $history->created_at->format('d/m/Y') }}</span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <button onclick="toggleFavorite({{ $history->song->id }}, this)" 
                                            class="p-2 hover:bg-white/10 rounded-lg transition group/fav"
                                            title="{{ $isFavorited ? 'Bỏ yêu thích' : 'Thêm yêu thích' }}">
                                        <i class="{{ $isFavorited ? 'fas text-pink-500' : 'far text-gray-400' }} fa-heart group-hover/fav:text-pink-500"></i>
                                    </button>
                                    <button onclick="playSong('{{ $history->song->audio_url }}', '{{ addslashes($history->song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $history->song->id }})"
                                            class="p-2 hover:bg-white/10 rounded-lg transition text-blue-400 hover:text-blue-300"
                                            title="Phát nhạc">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                Chưa có lịch sử nghe
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="py-20 text-center bg-[#1e2038] rounded-3xl border-2 border-dashed border-gray-800">
            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-gray-500 text-lg">Lịch sử nghe trống. Hãy nghe một số bài hát!</p>
            <a href="{{ route('welcome') }}" class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                Khám phá nhạc
            </a>
        </div>
    @endif
</x-music-layout>