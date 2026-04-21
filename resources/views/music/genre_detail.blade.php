<x-music-layout title="{{ $genre->name }} - ThreeX Music">
    @php
        $allGenres = \App\Models\Genre::where('status', 1)->orderBy('id')->get();
        $index = $allGenres->search(function ($item) use ($genre) {
            return $item->id == $genre->id;
        });
        $colors = [
            'from-blue-700 to-blue-900', 
            'from-green-700 to-green-900', 
            'from-purple-700 to-purple-900', 
            'from-red-700 to-red-900',
            'from-yellow-700 to-yellow-900',
            'from-pink-700 to-pink-900',
            'from-indigo-700 to-indigo-900'
        ];
        $currentColor = $colors[$index % count($colors)];
    @endphp
    <div class="container mx-auto px-4 py-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r {{ $currentColor }} p-8 md:p-12 mb-10 shadow-2xl ">
            <div class="relative z-10 ">
                <nav class="flex mb-4 text-sm">
                    <a href="{{ route('genres') }}" class="text-white/80 hover:text-white transition font-medium">Thể loại</a>
                    <span class="mx-2 text-white/60">/</span>
                    <span class="text-white font-semibold">{{ $genre->name }}</span>
                </nav>
                <h1 class="text-5xl md:text-7xl font-black text-white mb-4 uppercase tracking-tighter">{{ $genre->name }}</h1>
            </div>
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
                            $coverUrl = $song->cover_url ?? 'https://via.placeholder.com/50';
                            $artistNames = addslashes($song->artists->pluck('name')->join(', '));
                        @endphp
                        
                        <tr onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})"
                            class="hover:bg-white/10 transition-colors group cursor-pointer">
                            <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-purple-400 transition">{{ ($songs->currentPage() - 1) * $songs->perPage() + $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative w-12 h-12 flex-shrink-0 group/img">
                                        <img src="{{ $coverUrl }}" class="w-full h-full object-cover rounded shadow-lg group-hover/img:brightness-50 transition">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/img:opacity-100 text-white transition hover:scale-110">
                                            <i class="fas fa-play text-xs"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-white group-hover:text-purple-400 transition">{{ $song->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell"><span class="text-sm font-medium text-gray-400">{{ $song->artists->pluck('name')->join(', ') }}</span></td>
                            <td class="px-6 py-4 text-center"><span class="text-xs bg-gray-800 px-2 py-1 rounded text-gray-400">{{ number_format($song->play_count) }}</span></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center gap-3 text-gray-400">
                                    <button onclick="event.stopPropagation(); toggleFavorite({{ $song->id }}, this)" 
                                        @class(['transition hover:scale-110', 'text-pink-500' => $isFavorited, 'text-gray-500 hover:text-pink-500' => !$isFavorited])>
                                        <i class="fas fa-heart text-lg"></i>
                                    </button>
                                    <div class="text-gray-400 hover:text-purple-500 transition hover:scale-110">
                                        <i class="fas fa-play-circle text-lg"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-20 text-center text-gray-500">Chưa có bài hát nào.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-8">{{ $songs->links() }}</div>
    </div>
</x-music-layout>