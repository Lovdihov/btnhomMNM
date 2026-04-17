<x-music-layout title="Thể loại - ThreeX Music">
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold text-white mb-8 border-l-4 border-orange-500 pl-4">Khám phá Thể loại</h2>
        <div class="hidden">
            <div class="from-blue-600 to-blue-800 from-green-600 to-green-800"></div>
            <div class="from-purple-600 to-purple-800 from-red-600 to-red-800"></div>
            <div class="from-yellow-600 to-yellow-800 from-pink-600 to-pink-800"></div>
            <div class="from-indigo-600 to-indigo-800"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $colors = [
                    'from-blue-600 to-blue-800', 
                    'from-green-600 to-green-800', 
                    'from-purple-600 to-purple-800', 
                    'from-red-600 to-red-800',
                    'from-yellow-600 to-yellow-800',
                    'from-pink-600 to-pink-800',
                    'from-indigo-600 to-indigo-800'
                ];
            @endphp

            @foreach($genre as $index => $item)
                @php $currentColor = $colors[$index % count($colors)]; @endphp

                <a href="{{ route('music.genre_detail', $item->id) }}" 
                   class="bg-gradient-to-br {{ $currentColor }} h-40 rounded-2xl p-6 relative overflow-hidden group cursor-pointer shadow-2xl hover:-translate-y-2 transition-all duration-300 block">
                    
                    <h3 class="text-2xl font-black text-white relative z-10">{{ $item->name }}</h3>
                    
                    <span class="absolute -right-2 -bottom-2 text-8xl opacity-20 grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-500">
                        🎵
                    </span>

                    <p class="text-white/60 text-sm relative z-10 mt-2 font-medium">Khám phá ngay →</p>
                </a>
            @endforeach
        </div>
    </div>
</x-music-layout>