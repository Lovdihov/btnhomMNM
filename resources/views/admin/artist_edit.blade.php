<x-admin-layout>
    <x-slot name="title">Sửa Nghệ sĩ: {{ $artist->name }}</x-slot>

    <style>
        /* Tận dụng lại bộ CSS phía trên */
        .edit-container { max-width: 800px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eef0f7; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #444; margin-bottom: 8px; font-size: 14px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 8px; font-size: 15px; }
        .grid-layout { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
        .btn-submit { background-color: #1cc88a; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; transition: 0.3s; }
        .btn-submit:hover { background-color: #17a673; }
        .header-title { text-align: center; margin-bottom: 25px; color: #333; font-weight: 700; text-transform: uppercase; }
        .preview-avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 2px solid #4e73df; padding: 3px; }
    </style>

    <div class="edit-container">
        <h2 class="header-title">Chỉnh sửa Nghệ sĩ</h2>

        <form action="{{ route('admin.artists.update', $artist->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Tên nghệ sĩ / Nhóm nhạc</label>
                <input type="text" name="name" value="{{ $artist->name }}" required class="form-control">
            </div>

            <div class="grid-layout">
                <div class="form-group">
                    <label>Giới tính</label>
                    <select name="gender" class="form-control">
                        <option value="Nam" {{ $artist->gender == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ $artist->gender == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Khác" {{ $artist->gender == 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kiểu nghệ sĩ</label>
                    <select name="is_group" class="form-control">
                        <option value="0" {{ $artist->is_group == 0 ? 'selected' : '' }}>Cá nhân</option>
                        <option value="1" {{ $artist->is_group == 1 ? 'selected' : '' }}>Nhóm nhạc</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $artist->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ $artist->status == 0 ? 'selected' : '' }}>Tạm ẩn</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Avatar URL</label>
                <input type="text" name="avatar_url" value="{{ $artist->avatar_url }}" class="form-control" placeholder="https://...">
                @if($artist->avatar_url)
                    <div style="margin-top: 15px; text-align: center;">
                        <img src="{{ $artist->avatar_url }}" class="preview-avatar">
                        <p style="font-size: 12px; color: #666; margin-top: 5px;">Ảnh đại diện hiện tại</p>
                    </div>
                @endif
            </div>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <a href="{{ route('admin.artists') }}" style="flex: 1; text-align: center; padding: 12px; background: #f8f9fc; border: 1px solid #d1d3e2; color: #4e73df; border-radius: 8px; text-decoration: none; font-weight: 600;">Quay lại</a>
                <button type="submit" class="btn-submit" style="flex: 2;">LƯU THÔNG TIN</button>
            </div>
        </form>
    </div>
</x-admin-layout>
