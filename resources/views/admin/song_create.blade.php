<x-admin-layout>
<x-slot name="title">Thêm bài hát</x-slot>

<style>
.fc { max-width: 640px; margin: 0 auto; padding: 2rem 0; }
.fc-title { font-size: 18px; font-weight: 600; color: #111; margin-bottom: 2rem; text-align: center;}
.alert-ok { font-size: 13px; color: #2da06e; background: #f0faf5; border-radius: 8px; padding: 10px 14px; margin-bottom: 1.5rem; }
.fg { margin-bottom: 1.25rem;}
.fg label { display: block; font-size: 13px; color: #000000; margin-bottom: 5px; }
.fg input, .fg select, .fg textarea {
    width: 100%; padding: 9px 12px;
    font-size: 13px; color: #0a0a0a;
    background: #ffffff; border: 1px solid #d9d9d9;
    border-radius: 8px; outline: none;
    transition: border-color 0.15s, background 0.15s;
    font-family: inherit;
}
.fg input:focus, .fg select:focus, .fg textarea:focus {
    background: #fff; border-color: #ddd;
}
.fg textarea { resize: vertical; min-height: 90px; }
.fg .err { font-size: 11px; color: #e05c5c; margin-top: 4px; display: block; }
.fg-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.fc-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f0f0f0; }
.btn-cancel { font-size: 13px; color: #000000; padding: 8px 18px; border-radius: 7px; border: 1px solid #e5e5e5; background: #fff; text-decoration: none; cursor: pointer; }
.btn-save { font-size: 13px; color: #fff; padding: 8px 22px; border-radius: 7px; border: none; background: #111; cursor: pointer; transition: background 0.15s; }
.btn-save:hover { background: #333; }
</style>

<div class="fc">
    <div class="fc-title">Thêm bài hát</div>

    @if(session('success'))
    <div class="alert-ok">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.songs.store') }}" method="POST">
        @csrf

        <div class="fg">
            <label>Tên bài hát</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Nhập tên bài hát">
            @error('title') <span class="err">{{ $message }}</span> @enderror
        </div>

        <div class="fg-row">
            <div class="fg">
                <label>Album</label>
                <input type="number" name="album_id" value="{{ old('album_id') }}" placeholder="ID album">
            </div>
            <div class="fg">
                <label>Thời lượng (giây)</label>
                <input type="number" name="duration" value="{{ old('duration') }}" placeholder="0">
            </div>
        </div>

        <div class="fg">
            <label>Audio URL</label>
            <input type="text" name="audio_url" value="{{ old('audio_url') }}" placeholder="https://...">
            @error('audio_url') <span class="err">{{ $message }}</span> @enderror
        </div>

        <div class="fg">
            <label>Cover URL</label>
            <input type="text" name="cover_url" value="{{ old('cover_url') }}" placeholder="https://...">
        </div>

        <div class="fg-row">
            <div class="fg">
                <label>Ngày phát hành</label>
                <input type="date" name="release_date" value="{{ old('release_date') }}">
            </div>
            <div class="fg">
                <label>Trạng thái</label>
                <select name="status">
                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>
            
        </div>

        <div class="fg">
            <label>Lyrics</label>
            <textarea name="lyrics" placeholder="Nhập lời bài hát...">{{ old('lyrics') }}</textarea>
        </div>

        <div class="fc-footer">
            <a href="{{ route('admin.songs') }}" class="btn-cancel">Huỷ</a>
            <button type="submit" class="btn-save">Lưu bài hát</button>
        </div>
    </form>
</div>
</x-admin-layout>