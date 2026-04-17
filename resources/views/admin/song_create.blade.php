<x-admin-layout>
    <x-slot name="title">Thêm Bài Hát</x-slot>

    <div style="padding: 20px; max-width: 800px; margin: 0 auto;">
        <h3 style="text-align:center; margin-bottom:20px;">THÊM BÀI HÁT</h3>

        @if(session('success'))
            <div style="color: green; text-align:center; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.songs.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div style="margin-bottom: 15px;">
                <label>Tên bài hát</label>
                <input type="text" name="title" value="{{ old('title') }}" style="width:100%;">
                @error('title') <span style="color:red">{{ $message }}</span> @enderror
            </div>

            <!-- Album -->
            <div style="margin-bottom: 15px;">
                <label>Album ID</label>
                <input type="number" name="album_id" value="{{ old('album_id') }}" style="width:100%;">
            </div>

            <!-- Audio URL -->
            <div style="margin-bottom: 15px;">
                <label>Audio URL</label>
                <input type="text" name="audio_url" value="{{ old('audio_url') }}" style="width:100%;">
                @error('audio_url') <span style="color:red">{{ $message }}</span> @enderror
            </div>

            <!-- Cover -->
            <div style="margin-bottom: 15px;">
                <label>Cover URL</label>
                <input type="text" name="cover_url" value="{{ old('cover_url') }}" style="width:100%;">
            </div>

            <!-- Duration -->
            <div style="margin-bottom: 15px;">
                <label>Thời lượng (giây)</label>
                <input type="number" name="duration" value="{{ old('duration') }}" style="width:100%;">
            </div>

            <!-- Lyrics -->
            <div style="margin-bottom: 15px;">
                <label>Lyrics</label>
                <textarea name="lyrics" rows="4" style="width:100%;">{{ old('lyrics') }}</textarea>
            </div>

            <!-- Release date -->
            <div style="margin-bottom: 15px;">
                <label>Ngày phát hành</label>
                <input type="date" name="release_date" value="{{ old('release_date') }}" style="width:100%;">
            </div>

            <!-- Status -->
            <div style="margin-bottom: 15px;">
                <label>Trạng thái</label>
                <select name="status" style="width:100%;">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>

            <div style="text-align:center;">
                <button type="submit">Lưu</button>
            </div>
        </form>
    </div>
</x-admin-layout>