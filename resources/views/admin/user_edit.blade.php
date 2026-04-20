<x-admin-layout>
    <x-slot name="title">Sửa Người dùng: {{ $user->name }}</x-slot>

    <style>
        .edit-container { max-width: 720px; margin: 30px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #eef0f7; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; color: #444; margin-bottom: 8px; font-size: 14px; }
        .form-control { width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 8px; font-size: 15px; }
        .form-control:focus { border-color: #4e73df; outline: none; box-shadow: 0 0 0 3px rgba(78,115,223,0.1); }
        .grid-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .btn-submit { background-color: #4e73df; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; width: 100%; font-size: 16px; transition: 0.3s; }
        .btn-submit:hover { background-color: #2e59d9; }
        .header-title { text-align: center; margin-bottom: 25px; color: #333; font-weight: 700; text-transform: uppercase; font-size: 20px; letter-spacing: 1.5px; }
        .help-text { margin-top: 6px; font-size: 12px; color: #666; }
    </style>

    <div class="edit-container">
        <h2 class="header-title">Chỉnh sửa Người dùng</h2>

        @if ($errors->any())
            <div style="margin-bottom: 15px; padding: 12px; border-radius: 8px; background: #ffe9e9; color: #c0392b; border: 1px solid #ffb8b8;">
                <strong>Vui lòng kiểm tra lại thông tin:</strong>
                <ul style="margin: 8px 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Tên người dùng</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control">
            </div>

            <div class="form-group">
                <label>Vai trò</label>
                <select name="role_id" class="form-control" required>
                    <option value="2" {{ old('role_id', $user->role_id ?? 2) == 2 ? 'selected' : '' }}>Thành viên</option>
                    <option value="1" {{ old('role_id', $user->role_id ?? 2) == 1 ? 'selected' : '' }}>Quản trị viên</option>
                </select>
            </div>

            <div class="grid-layout">
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control" placeholder="Để trống nếu không đổi">
                </div>
                <div class="form-group">
                    <label>Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                </div>
            </div>

            <p class="help-text">Nếu không muốn thay đổi mật khẩu, để trống hai ô mật khẩu.</p>

            <div style="margin-top: 30px; display: flex; gap: 10px;">
                <a href="{{ route('admin.users') }}" style="flex: 1; text-align: center; padding: 12px; background: #f8f9fc; border: 1px solid #d1d3e2; color: #4e73df; border-radius: 8px; text-decoration: none; font-weight: 600;">Quay lại</a>
                <button type="submit" class="btn-submit" style="flex: 2;">LƯU THAY ĐỔI</button>
            </div>
        </form>
    </div>
</x-admin-layout>
