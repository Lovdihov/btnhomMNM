<x-music-layout title="Album - ThreeX Music">
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-white mb-8 border-l-4 border-green-500 pl-4">Bộ sưu tập Album</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($albums as $album)
                <a href="{{ route('album_detail', $album->id) }}" class="block bg-[#1e2038] rounded-2xl p-5 hover:bg-[#2a2d4f] transition-all duration-300 group shadow-xl">
                    <div class="relative mb-4 overflow-hidden rounded-xl shadow-lg">
                        <img src="{{ $album->cover_url }}" alt="{{ $album->title }}" class="w-full aspect-square object-cover group-hover:scale-110 transition duration-700">
                    </div>
                    <h3 class="text-lg font-bold text-white truncate group-hover:text-green-400 transition">{{ $album->title }}</h3>
                    <p class="text-sm text-gray-400 mt-1">
                        {{ $album->release_date ? date('Y', strtotime($album->release_date)) : 'N/A' }} 
                        • {{ number_format($album->play_count) }} lượt nghe
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</x-music-layout>