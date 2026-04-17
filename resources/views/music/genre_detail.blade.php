<x-music-layout title="{{ $genre->name }} - ThreeX Music">
    <div class="container mx-auto px-4 py-8">
        
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-gray-900 to-black p-8 md:p-12 mb-10 shadow-2xl">
            <div class="relative z-10">
                <nav class="flex mb-4 text-sm text-gray-400">
                    <a href="{{ route('genres') }}" class="hover:text-orange-500 transition">Thể loại</a>
                    <span class="mx-2">/</span>
                    <span class="text-white">{{ $genre->name }}</span>
                </nav>
                <h1 class="text-5xl md:text-7xl font-black text-white mb-4 uppercase tracking-tighter">
                    {{ $genre->name }}
                </h1>
                <p class="text-gray-400 text-lg max-w-2xl">
                    Khám phá những bản nhạc {{ $genre->name }} hay nhất được chọn lọc dành riêng cho bạn.
                </p>
                <div class="mt-6 flex items-center gap-4">
                    <span class="bg-orange-500 text-white px-4 py-1 rounded-full text-sm font-bold shadow-lg shadow-orange-500/30">
                        {{ $songs->total() }} Bài hát
                    </span>
                    <button class="bg-white/10 hover:bg-white/20 text-white backdrop-blur-md px-6 py-2 rounded-full font-medium transition flex items-center gap-2 border border-white/10">
                        <i class="fas fa-play"></i> Phát tất cả
                    </button>
                </div>
            </div>
            
            <div class="absolute -right-20 -top-20 text-[200px] opacity-10 grayscale italic font-black select-none">
                #{{ $genre->id }}
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
                    <tr class="hover:bg-white/10 transition-colors group cursor-pointer">
                        <td class="px-6 py-4 text-sm text-gray-500 group-hover:text-purple-400 transition">
                            {{ ($songs->currentPage() - 1) * $songs->perPage() + $index + 1 }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative w-12 h-12 flex-shrink-0 group/img">
                                    <img src="{{ $song->cover_url }}" class="w-full h-full object-cover rounded shadow-lg group-hover/img:brightness-50 transition" alt="Cover">
                                    <button onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $song->cover_url ?? 'https://via.placeholder.com/50' }}', '{{ addslashes($song->artists->pluck('name')->join(', ')) }}', {{ $song->id }})" 
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
                            <span class="text-sm font-medium text-gray-400">{{ $song->artists->pluck('name')->join(', ') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs bg-gray-800 px-2 py-1 rounded text-gray-400">{{ number_format($song->play_count) }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-3 text-gray-400">
                                
                                @php
                                    $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($song->id);
                                @endphp
                                <button onclick="toggleFavorite({{ $song->id }}, this)" 
                                    @class([
                                        'transition hover:scale-110',
                                        'text-pink-500' => $isFavorited,
                                        'text-gray-500 hover:text-pink-500' => !$isFavorited
                                    ])>
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                                </button>

                                <button onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $song->cover_url ?? 'https://via.placeholder.com/50' }}', '{{ addslashes($song->artists->pluck('name')->join(', ')) }}', {{ $song->id }})" 
                                        class="text-gray-400 hover:text-purple-500 transition hover:scale-110">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/></svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-music fa-3x mb-4 opacity-20"></i>
                                <p>Chưa có bài hát nào thuộc thể loại này.</p>
                                <a href="{{ route('genres') }}" class="mt-4 inline-block text-purple-500 hover:underline">Quay lại khám phá</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            {{ $songs->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        const csrfTokenFavorites = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        function toggleFavorite(songId, buttonElement) {
            if (!csrfTokenFavorites) return alert("Lỗi CSRF");

            fetch(`/songs/${songId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfTokenFavorites
                }
            })
            .then(res => res.status === 401 ? (window.location.href = '/login') : res.json())
            .then(data => {
                if (data.status === 'added') {
                    buttonElement.classList.replace('text-gray-500', 'text-pink-500');
                } else if (data.status === 'removed') {
                    buttonElement.classList.replace('text-pink-500', 'text-gray-500');
                }
            });
        }
    </script>
    @endpush
</x-music-layout>