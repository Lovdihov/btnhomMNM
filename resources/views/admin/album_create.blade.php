<x-admin-layout>
    <x-slot name="title">Thêm Album</x-slot>

    <div style="padding: 20px; max-width: 700px; margin: 0 auto;">
        <h2 style="text-align:center; margin-bottom:20px;">THÊM ALBUM</h2>

        @if(session('success'))
            <div style="color: green; text-align:center; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.albums.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <div style="margin-bottom: 15px;">
                <label>Tên album</label>
                <input type="text" name="title" value="{{ old('title') }}" style="width:100%;">
                @error('title') <span style="color:red">{{ $message }}</span> @enderror
            </div>

            <!-- Release Date -->
            <div style="margin-bottom: 15px;">
                <label>Ngày phát hành</label>
                <input type="date" name="release_date" value="{{ old('release_date') }}" style="width:100%;">
            </div>

            <!-- Cover -->
            <div style="margin-bottom: 15px;">
                <label>Cover URL</label>
                <input type="text" name="cover_url" value="{{ old('cover_url') }}" style="width:100%;">
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
                <button type="submit" style="padding:8px 20px;">Lưu</button>
            </div>
        </form>
    </div>
</x-admin-layout>