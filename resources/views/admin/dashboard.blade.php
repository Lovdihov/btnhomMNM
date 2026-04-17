<x-admin-layout>
    <x-slot name="title">Tổng quan hệ thống</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-5 mt-2">
        <div style='text-align:center; color:black; font-weight:bold; font-size:22px; text-transform: uppercase; margin-bottom: 20px; letter-spacing: 1px;'>
            Bảng điều khiển
        </div>
        <div class="mt-4 p-4 bg-white shadow-sm" style="border-radius: 15px;">
            <h5 class="font-weight-bold mb-3"><i class="fas fa-bolt text-warning me-2"></i>Thao tác nhanh</h5>
            <div class="d-flex gap-2">
                <a href="/admin/song_create" class="btn btn-outline-primary btn-sm rounded-pill px-3">+ Thêm Nhạc</a>
                <a href="/admin/art_create" class="btn btn-outline-success btn-sm rounded-pill px-3">+ Thêm Nghệ sĩ</a>
                <a href="/admin/album_create" class="btn btn-outline-dark btn-sm rounded-pill px-3">+ Thêm Album</a>
            </div>
        </div>
    </div>

    <div class="row text-center" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
        <div style="grid-column: span 1;">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                <div class="card-body py-5 bg-gradient" style="background: linear-gradient(45deg, #0dcaf0, #0aa2c0);">
                    <div class="mb-3">
                        <i class="fas fa-music fa-3x text-white-50"></i>
                    </div>
                    <h1 class="display-4 font-weight-bold text-white mb-0">{{ number_format($songCount ?? 0) }}</h1>
                    <h5 class="text-white-50 text-uppercase small font-weight-bold">Tổng bài hát</h5>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <a href="{{ route('admin.songs') }}" class="text-info font-weight-bold text-decoration-none small">
                        QUẢN LÝ NGAY <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div style="grid-column: span 1;">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                <div class="card-body py-5 bg-gradient" style="background: linear-gradient(45deg, #198754, #146c43);">
                    <div class="mb-3">
                        <i class="fas fa-compact-disc fa-3x text-white-50"></i>
                    </div>
                    <h1 class="display-4 font-weight-bold text-white mb-0">{{ number_format($albumCount ?? 0) }}</h1>
                    <h5 class="text-white-50 text-uppercase small font-weight-bold">Album hiện có</h5>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <a href="{{ route('admin.albums') }}" class="text-success font-weight-bold text-decoration-none small">
                        QUẢN LÝ NGAY <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div style="grid-column: span 1;">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                <div class="card-body py-5 bg-gradient" style="background: linear-gradient(45deg, #ffc107, #e0a800);">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-dark-50" style="opacity: 0.3;"></i>
                    </div>
                    <h1 class="display-4 font-weight-bold text-dark mb-0">{{ number_format($artistCount ?? 0) }}</h1>
                    <h5 class="text-dark-50 text-uppercase small font-weight-bold">Nghệ sĩ hợp tác</h5>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <a href="{{ route('admin.artists') }}" class="text-warning font-weight-bold text-decoration-none small">
                        QUẢN LÝ NGAY <i class="fas fa-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>