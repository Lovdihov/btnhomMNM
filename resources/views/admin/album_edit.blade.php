<x-admin-layout>
    <x-slot name="title">Sửa Album: {{ $album->title }}</x-slot>

    <style>
        .edit-container { max-width: 800px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eef0f7; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #444; margin-bottom: 8px; font-size: 14px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 8px; font-size: 15px; }
        .form-control:focus { border-color: #4e73df; outline: none; box-shadow: 0 0 0 3px rgba(78,115,223,0.1); }
        .grid-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn-submit { background-color: #4e73df; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; transition: 0.3s; }
        .btn-submit:hover { background-color: #2e59d9; }
        .header-title { text-align: center; margin-bottom: 25px; color: #333; font-weight: 700; text-transform: uppercase; font-size: 20px; letter-spacing: 1.5px; }
    </style>

    <div class="edit-container">
        <h2 class="header-title">Chỉnh sửa Album</h2>

        <form action="{{ route('admin.albums.update', $album->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Tiêu đề Album</label>
                <input type="text" name="title" value="{{ $album->title }}" required class="form-control">
            </div>

            <div class="grid-layout">
                <div class="form-group">
                    <label>Ngày phát hành</label>
                    <input type="date" name="release_date" value="{{ $album->release_date }}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $album->status == 1 ? 'selected' : '' }}>Hiện Album</option>
                        <option value="0" {{ $album->status == 0 ? 'selected' : '' }}>Ẩn Album</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Ảnh bìa Album (URL)</label>
                <input type="text" name="cover_url" value="{{ $album->cover_url }}" class="form-control" placeholder="https://...">
                @if($album->cover_url)
                    <div style="margin-top: 10px;">
                        <img src="{{ $album->cover_url }}" width="120" style="border-radius: 8px; border: 1px solid #ddd;">
                    </div>
                @endif
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <a href="{{ route('admin.albums') }}" style="flex: 1; text-align: center; padding: 12px; background: #f8f9fc; border: 1px solid #d1d3e2; color: #4e73df; border-radius: 8px; text-decoration: none; font-weight: 600;">Quay lại</a>
                <button type="submit" class="btn-submit" style="flex: 2;">LƯU THAY ĐỔI</button>
            </div>
        </form>
    </div>
</x-admin-layout>