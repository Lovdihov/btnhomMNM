<x-admin-layout>
    <x-slot name="title">Quản lý Bài hát</x-slot>

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
            $('#song-table').DataTable({
                pageLength: 10,
                order: [[4, 'desc']],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json'
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
        QUẢN LÝ BÀI HÁT
    </div>

    {{-- Nút thêm --}}
    <div style="margin-bottom: 15px;">
        <a href="{{ url('/admin/song_create') }}" class="btn-custom btn-add">
            + Thêm bài hát
        </a>
    </div>

    <div class="card" style="padding:15px;">
        <table id="song-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Nghệ sĩ</th>
                    <th>Lượt nghe</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @foreach($songs as $song)
                <tr>
                    <td style="text-align:center;">
                        <img src="{{ $song->cover_url }}" width="50" style="border-radius:6px;">
                    </td>

                    <td style="font-weight:500;">
                        {{ $song->title }}
                    </td>

                    <td>
                        {{ $song->artists->pluck('name')->join(', ') }}
                    </td>

                    <td>
                        {{ number_format($song->play_count) }}
                    </td>

                    <td>
                        {{ $song->created_at ? $song->created_at->format('d/m/Y') : '' }}
                    </td>

                    <td style="text-align:center;">
                        <span class="badge-status {{ $song->status == 1 ? 'status-active' : 'status-hidden' }}">
                            {{ $song->status == 1 ? 'Hiện' : 'Ẩn' }}
                        </span>
                    </td>

                    <td style="text-align:center;">
                        <form method="POST" action="{{ route('admin.songs.delete', $song->id) }}" 
                              onsubmit="return confirm('Bạn có chắc muốn thao tác không?')">
                            @csrf
                            <button type="submit" class="btn-custom btn-delete">
                                {{ $song->status == 1 ? 'Xóa' : 'Khôi phục' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin-layout>