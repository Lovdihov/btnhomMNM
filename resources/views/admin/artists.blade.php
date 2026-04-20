<x-admin-layout>
    <x-slot name="title">Quản lý Nghệ sĩ</x-slot>

    {{-- DataTables --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <style>
        .btn-custom {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-add:hover {
            background-color: #218838;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-restore {
            background-color: #17a2b8;
            color: white;
            display: inline-block;
            white-space: nowrap;
        }

        .btn-restore:hover {
            background-color: #138496;
        }

        .badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .status-active {
            background: #28a745;
            color: #fff;
        }

        .status-hidden {
            background: #6c757d;
            color: #fff;
        }

        table.dataTable {
            border: 1px solid #ccc;
        }

        table.dataTable th,
        table.dataTable td {
            border: 1px solid #ddd !important;
            padding: 8px;
        }

        table.dataTable thead {
            background-color: #343a40;
            color: white;
        }
    </style>

    <script>
        $(document).ready(function(){
            $('#artist-table').DataTable({
                pageLength: 10,
                order: [[3, 'desc']],
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

    {{-- Alert --}}
    @if (session('success'))
        <div style="color:green; text-align:center; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="text-align:center; font-size:22px; font-weight:bold; margin-bottom:20px;">
        QUẢN LÝ NGHỆ SĨ
    </div>

    {{-- Nút thêm --}}
    <div style="margin-bottom: 15px;">
        <a href="{{ route('admin.artists.create') }}" class="btn-custom btn-add">
            + Thêm nghệ sĩ
        </a>
    </div>

    <div class="card" style="padding:15px;">
        <table id="artist-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Tên nghệ sĩ</th>
                    <th>Follower</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                    <th>Cập nhật</th>
                </tr>
            </thead>

            <tbody>
                @foreach($artists as $artist)
                <tr>
                    <td style="text-align:center;">
                        <img src="{{ $artist->avatar_url }}" width="45" height="45" 
                             style="border-radius:50%; object-fit:cover;">
                    </td>

                    <td style="font-weight:500;">
                        {{ $artist->name }}
                    </td>

                    <td>
                        {{ number_format($artist->follower_count) }}
                    </td>

                    <td>
                        {{ $artist->created_at ? $artist->created_at->format('d/m/Y') : '' }}
                    </td>

                    <td style="text-align:center;">
                        <span class="badge-status {{ $artist->status == 1 ? 'status-active' : 'status-hidden' }}">
                            {{ $artist->status == 1 ? 'Hiện' : 'Ẩn' }}
                        </span>
                    </td>

                    <td style="text-align:center;">
                        <form method="POST" action="{{ route('admin.artists.delete', $artist->id) }}" 
                              onsubmit="return confirm('Bạn có chắc muốn thao tác không?')">
                            @csrf
                            <button type="submit" class="btn-custom {{ $artist->status == 1 ? 'btn-delete' : 'btn-restore' }}">
                                {{ $artist->status == 1 ? 'Xóa' : 'Khôi phục' }}
                            </button>
                        </form>
                    </td>

                    <td style="text-align:center;">
                        <a href="{{ route('admin.artists.edit', $artist->id) }}" class="btn-custom" 
                        style="background-color: #ffc107; color: #000; text-decoration: none; display: inline-block;">
                            Sửa
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>