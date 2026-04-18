<x-music-layout title="Tất cả bài hát - ThreeX Music">
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-white mb-6 border-l-4 border-blue-500 pl-4">Kho Bài Hát</h2>
        
        <div class="bg-[#1e2038] rounded-2xl overflow-hidden shadow-xl">
            <div class="grid grid-cols-12 gap-4 p-4 border-b border-gray-800 text-gray-400 text-sm font-bold uppercase tracking-wider">
                <div class="col-span-1 text-center">#</div>
                <div class="col-span-6 md:col-span-5">Tiêu đề</div>
                <div class="hidden md:block col-span-3">Album</div>
                <div class="hidden md:block col-span-2 text-right">Lượt nghe</div>
                <div class="col-span-5 md:col-span-1 text-right">Thao tác</div>
            </div>

            <div class="divide-y divide-gray-800">
                @foreach($songs as $index => $song)
                    @php
                        $isFavorited = Auth::check() && Auth::user()->favoriteSongs->contains($song->id);
                        $coverUrl = $song->cover_url ?? 'https://via.placeholder.com/50';
                        $artistNames = addslashes($song->artists->pluck('name')->join(', '));
                    @endphp

                    {{-- Click vào cả dòng để phát nhạc --}}
                    <div onclick="playSong('{{ $song->audio_url }}', '{{ addslashes($song->title) }}', '{{ $coverUrl }}', '{{ $artistNames }}', {{ $song->id }})" 
                         class="grid grid-cols-12 gap-4 p-4 items-center hover:bg-white/5 transition group cursor-pointer">
                        
                        <div class="col-span-1 text-center text-gray-500 group-hover:hidden">
                            {{ $index + 1 }}
                        </div>
                        <div class="col-span-1 text-center hidden group-hover:block text-purple-500">
                            <i class="fas fa-play"></i>
                        </div>

                        <div class="col-span-6 md:col-span-5 flex items-center gap-3">
                            <img src="{{ $coverUrl }}" class="w-10 h-10 rounded shadow-md">
                            <div class="truncate">
                                <h4 class="text-white font-medium truncate group-hover:text-purple-400 transition">{{ $song->title }}</h4>
                                <p class="text-xs text-gray-400 truncate">{{ $song->artists->pluck('name')->join(', ') }}</p>
                            </div>
                        </div>

                        <div class="hidden md:block col-span-3 text-gray-400 text-sm truncate">
                            {{ $song->album->title ?? 'Single' }}
                        </div>

                        <div class="hidden md:block col-span-2 text-right text-gray-400 text-sm">
                            {{ number_format($song->play_count) }}
                        </div>

                        <div class="col-span-5 md:col-span-1 flex justify-end items-center gap-3">
                            {{-- Chặn nổi bọt ở nút thả tim --}}
                            <button onclick="event.stopPropagation(); toggleFavorite({{ $song->id }}, this)" 
                                @class([
                                    'transition hover:scale-110',
                                    'text-pink-500' => $isFavorited,
                                    'text-gray-500 hover:text-pink-500' => !$isFavorited
                                ])>
                                <i class="fas fa-heart text-lg"></i>
                            </button>
                            
                            <div class="text-gray-400 hover:text-purple-500 transition hover:scale-110">
                                <i class="fas fa-play-circle text-lg"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        @if($songs->isEmpty())
            <div class="text-center py-20 text-gray-500 italic bg-[#1e2038] rounded-2xl mt-4">
                Hiện chưa có bài hát nào trong hệ thống.
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        const csrfTokenFavorites = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        function toggleFavorite(songId, buttonElement) {
            if (!csrfTokenFavorites) return alert("Vui lòng đăng nhập để sử dụng tính năng này!");

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
                    buttonElement.classList.remove('hover:text-pink-500');
                } else if (data.status === 'removed') {
                    buttonElement.classList.replace('text-pink-500', 'text-gray-500');
                    buttonElement.classList.add('hover:text-pink-500');
                }
            });
        }
    </script>
    @endpush
</x-music-layout>