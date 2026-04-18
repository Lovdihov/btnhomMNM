<x-music-layout title="Lịch sử nghe - ThreeX Music">
    <div class="flex items-center gap-6 mb-10">
        <div class="p-5 bg-blue-600 rounded-3xl shadow-lg shadow-blue-600/20">
            <i class="fas fa-history text-3xl text-white"></i>
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
                    @foreach($histories as $index => $history)
                        @php
                            $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($history->song->id);
                            $coverUrl = $history->song->cover_url ?? 'https://via.placeholder.com/50';
                            $artistNames = addslashes($history->song->artists->pluck('name')->join(', '));
                        @endphp
                        
                        <tr onclick="playSong('{{ $history->song->audio_url }}', '{{ addslashes($history->song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $history->song->id }})"
                            class="hover:bg-white/10 transition-colors group cursor-pointer">

                            <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-blue-400 transition">{{ $index + 1 }}</td>
                            
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12 flex-shrink-0 group/img">
                                        <img src="{{ $coverUrl }}" class="w-full h-full object-cover rounded shadow-lg group-hover/img:brightness-50 transition">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 text-white transition hover:scale-110">
                                            <i class="fas fa-play text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="font-bold text-white group-hover:text-blue-400 transition">{{ $history->song->title }}</div>
                                </div>
                            </td>

                            <td class="px-6 py-4 hidden md:table-cell"><span class="text-sm text-gray-400">{{ $history->song->artists->pluck('name')->join(', ') }}</span></td>
                            <td class="px-6 py-4 hidden md:table-cell"><span class="text-xs text-gray-500">{{ $history->created_at->format('d/m/Y H:i') }}</span></td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <button onclick="event.stopPropagation(); toggleFavorite({{ $history->song->id }}, this)" 
                                            class="p-2 hover:bg-white/10 rounded-lg transition group/fav">
                                        <i class="{{ $isFavorited ? 'fas text-pink-500' : 'far text-gray-400' }} fa-heart group-hover/fav:text-pink-500 text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="py-20 text-center text-gray-500 bg-[#1e2038] rounded-3xl">Lịch sử nghe trống.</div>
    @endif
</x-music-layout>