<x-admin-layout>
    <x-slot name="title">Thêm Nghệ Sĩ</x-slot>

    <div style="padding: 20px; max-width: 700px; margin: 0 auto;">
        <h2 style="text-align:center; margin-bottom:20px;">THÊM NGHỆ SĨ</h2>

        @if(session('success'))
            <div style="color: green; text-align:center; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.artists.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div style="margin-bottom: 15px;">
                <label>Tên nghệ sĩ</label>
                <input type="text" name="name" value="{{ old('name') }}" style="width:100%;">
                @error('name') <span style="color:red">{{ $message }}</span> @enderror
            </div>

            <!-- Slug -->
            <div style="margin-bottom: 15px;">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" style="width:100%;">
            </div>

            <!-- Avatar -->
            <div style="margin-bottom: 15px;">
                <label>Avatar URL</label>
                <input type="text" name="avatar_url" value="{{ old('avatar_url') }}" style="width:100%;">
            </div>

            <!-- Gender -->
            <div style="margin-bottom: 15px;">
                <label>Giới tính</label>
                <select name="gender" style="width:100%;">
                    <option value="">-- Chọn --</option>
                    <option value="1">Nam</option>
                    <option value="0">Nữ</option>
                </select>
            </div>

            <!-- Is Group -->
            <div style="margin-bottom: 15px;">
                <label>Là nhóm?</label>
                <select name="is_group" style="width:100%;">
                    <option value="0">Cá nhân</option>
                    <option value="1">Nhóm</option>
                </select>
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