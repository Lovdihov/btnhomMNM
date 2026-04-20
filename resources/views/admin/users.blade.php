<x-admin-layout>
    <x-slot name="title">Quản lý Người dùng</x-slot>

    {{-- DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <style>
        .btn-custom { padding: 6px 12px; border-radius: 6px; font-size: 14px; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-add { background-color: #28a745; color: white; }
        .btn-delete { background-color: #dc3545; color: white; }
        .btn-restore { background-color: #17a2b8; color: white; }
        .btn-restore { display: inline-block; white-space: nowrap; }
        .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 12px; color: #fff; display: inline-block; white-space: nowrap; }
        .role-admin { background: #e74c3c; }
        .role-user { background: #3498db; }
        .status-active { background: #28a745; }
        .status-hidden { background: #6c757d; }
        table.dataTable { border: 1px solid #ccc; }
        table.dataTable th, table.dataTable td { border: 1px solid #ddd !important; padding: 8px; }
        table.dataTable thead { background-color: #343a40; color: white; }
    </style>

    <script>
        $(document).ready(function(){
            $('#user-table').DataTable({
                pageLength: 10,
                order: [[0, 'asc']],
                language: {
                    lengthMenu: 'Hiển thị _MENU_ mục',
                    search: 'Tìm kiếm:',
                    info: 'Hiển thị _START_ đến _END_ trong tổng _TOTAL_ mục',
                    infoEmpty: 'Hiển thị 0 đến 0 trong tổng 0 mục',
                    infoFiltered: '(lọc từ _MAX_ mục)',
                    zeroRecords: 'Không tìm thấy dữ liệu phù hợp',
                    emptyTable: 'Không có dữ liệu',
                    paginate: {
                        first: 'Đầu',
                        last: 'Cuối',
                        next: 'Sau',
                        previous: 'Trước'
                    }
                }
            });
        });
    </script>

    @if (session('success'))
        <div style="color:green; text-align:center; margin-bottom:10px; font-weight:bold;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div style="color:red; text-align:center; margin-bottom:10px; font-weight:bold;">
            {{ session('error') }}
        </div>
    @endif

    <div style="text-align:center; font-size:22px; font-weight:bold; margin-bottom:20px;">
        QUẢN LÝ NGƯỜI DÙNG
    </div>

    <div style="text-align:left; margin-bottom:12px;">
        <a href="{{ route('admin.users.create') }}" class="btn-custom btn-add">+ Thêm người dùng</a>
    </div>

    <div class="card" style="padding:15px;">
        <table id="user-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày tham gia</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                    <th>Cập nhật</th>
                </tr>
            </thead>

            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td style="font-weight:500;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td style="text-align:center;">
                        <span class="badge-status {{ $user->role_id == 1 ? 'role-admin' : 'role-user' }}">
                            {{ $user->role_id == 1 ? 'Quản trị viên' : 'Thành viên' }}
                        </span>
                    </td>
                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '---' }}</td>

                    <td style="text-align:center;">
                        <span class="badge-status {{ ($user->status ?? 1) == 1 ? 'status-active' : 'status-hidden' }}">
                            {{ ($user->status ?? 1) == 1 ? 'Hiện' : 'Ẩn' }}
                        </span>
                    </td>

                    <td style="text-align:center;">
                        @if($user->id !== Auth::id())
                        <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" 
                               onsubmit="return confirm('Bạn có chắc muốn thao tác với người dùng này không?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-custom {{ ($user->status ?? 1) == 1 ? 'btn-delete' : 'btn-restore' }}">
                                {{ ($user->status ?? 1) == 1 ? 'Xóa' : 'Khôi phục' }}
                            </button>
                        </form>
                        @else
                            <span style="font-size: 11px; color: gray;">(Đang đăng nhập)</span>
                        @endif
                    </td>

                    <td style="text-align:center;">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-custom" 
                           style="background-color: #ffc107; color: #000;">
                            Sửa
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>