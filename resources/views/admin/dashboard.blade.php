<x-admin-layout>
<x-slot name="title">Tổng quan hệ thống</x-slot>

<style>
    .db-section { padding: 1.5rem 0; }

    /* ── Header ── */
    .db-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .db-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 4px;
    }
    .db-heading {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    .db-date { font-size: 13px; color: #202020; margin-top: 4px; }

    .qa-wrap {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
    }
    .qa-label {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #191919;
    }
    .qa-btns { display: flex; gap: 8px; flex-wrap: wrap; justify-content: flex-end; }
    .qa-btn {
        font-size: 12px;
        font-weight: 600;
        padding: 7px 16px;
        border-radius: 50px;
        border: 1.5px solid #e0e0e0;
        background: #fff;
        color: #000000;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.18s;
        display: inline-block;
    }
    .qa-btn:hover { background: #1a1a2e; color: #fff; border-color: #1a1a2e; }


    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 16px;
        margin-bottom: 20px;
        text-align: center;
    }
    .stat-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #919191;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
        gap: 4px;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        transition: box-shadow 0.18s, transform 0.18s;
        
    }
    .stat-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,0.09); transform: translateY(-2px); }
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        border-radius: 16px 16px 0 0;
    }
    


    .stat-label { font-size: 15px; font-weight: 600; text-transform: uppercase; text-align: center; letter-spacing: 1.5px; color: #252424; }
    .stat-val   { font-size: 34px; font-weight: 800; color: #1a1a2e; line-height: 1.1; }
    .stat-badge {
        gap: 4px;
        font-size: 11px; font-weight: 600;
        padding: 3px 10px;
        border-radius: 50px;
        margin-top: 6px;
        margin-left: auto;
        margin-right: auto;
        display: flex;   
        align-items: center;
   
    }
    .stat-card.blue  .stat-badge { background: #daf7ff; color: #00cdf7; }
    .stat-card.green .stat-badge { background: #c9ffe2; color: #00c167; }
    .stat-card.amber .stat-badge { background: #faefcc; color: #efb72b; }


    .stat-card.blue  .stat-manage { color: #919191; }
    .stat-card.green .stat-manage { color: #919191; }
    .stat-card.amber .stat-manage { color: #919191; }

    /* ── Charts row ── */
    .charts-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.65fr) minmax(0, 1fr);
        gap: 16px;
        margin-bottom: 20px;
        text-align: center;
    }
    .chart-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #a5a5a5;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .card-title {
        font-size: 15px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: #1f1f1f;
        margin-bottom: 16px;
        text-align: center;
        display: block;      /* Đảm bảo thẻ chiếm hết chiều ngang để text-align có tác dụng */
        
        /* Mẹo nhỏ dành cho dân chuyên nghiệp */
        text-indent: 1.5px;
    
    }
    .chart-legend {
        display: flex; gap: 16px; margin-bottom: 14px; flex-wrap: wrap;
    }
    .legend-item {
        display: flex; align-items: center; gap: 6px;
        font-size: 12px; color: #666;
    }
    .legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    /* ── Bottom row ── */
    .bottom-grid {
        display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1fr);
        gap: 16px;
    }
    .list-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid #a5a5a5;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    /* Artist list */
    .artist-row {
        display: flex; align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f7f7f7;
    }
    .artist-row:last-child { border-bottom: none; }
    .artist-rank {
        width: 22px; height: 22px;
        border-radius: 6px;
        background: #f5f5f5;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: #383838;
        margin-right: 10px; flex-shrink: 0;
    }
    .artist-rank.top { background: #1a1a2e; color: #fff; }
    .artist-name { font-size: 13px; font-weight: 600; color: #1a1a2e; }
    .artist-count { font-size: 12px; font-weight: 600; color: #aaa; }

    /* Album bars */
    .bar-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; }
    .bar-name {
        font-size: 12px; color: #666;
        width: 110px; flex-shrink: 0;
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .bar-track {
        flex: 1; height: 7px;
        background: #f3f3f3; border-radius: 4px; overflow: hidden;
    }
    .bar-fill { height: 100%; border-radius: 4px; }
    .bar-val { font-size: 12px; font-weight: 600; color: #888; width: 30px; text-align: right; flex-shrink: 0; }
</style>

<div class="db-section">

    {{-- ── HEADER ── --}}
    <div class="db-header">
        <div>
            <div class="db-title">Quản trị hệ thống</div>
            <h1 class="db-heading">Bảng điều khiển</h1>
            <div class="db-date" id="dbDate"></div>
        </div>
        <div class="qa-wrap">
            <div class="qa-label">Thao tác nhanh</div>
            <div class="qa-btns">
                <a href="/admin/song_create"  class="qa-btn"><i class="fas fa-music me-1"></i> Thêm nhạc</a>
                <a href="/admin/art_create"   class="qa-btn"><i class="fas fa-user me-1"></i> Thêm nghệ sĩ</a>
                <a href="/admin/album_create" class="qa-btn"><i class="fas fa-compact-disc me-1"></i> Thêm album</a>
            </div>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="stats-grid">
        <a href="{{ route('admin.songs') }}" class="stat-card blue">
            <div class="stat-icon-wrap"><i class="fas fa-music"></i></div>
            <div class="stat-label">Tổng bài hát</div>
            <div class="stat-val">{{ number_format($songCount ?? 0) }}</div>
            <div class="stat-badge">
                <i class="fas fa-arrow-up" style="font-size:9px;"></i>
                +{{ $songThisMonth ?? 0 }} tháng này
            </div>
            <div class="stat-manage">Quản lý ngay &rarr;</div>
        </a>

        <a href="{{ route('admin.albums') }}" class="stat-card green">
            <div class="stat-icon-wrap"><i class="fas fa-compact-disc"></i></div>
            <div class="stat-label">Album hiện có</div>
            <div class="stat-val">{{ number_format($albumCount ?? 0) }}</div>
            <div class="stat-badge">
                <i class="fas fa-arrow-up" style="font-size:9px;"></i>
                +{{ $albumThisMonth ?? 0 }} tháng này
            </div>
            <div class="stat-manage">Quản lý ngay &rarr;</div>
        </a>

        <a href="{{ route('admin.artists') }}" class="stat-card amber">
            <div class="stat-icon-wrap"><i class="fas fa-users"></i></div>
            <div class="stat-label">Nghệ sĩ hợp tác</div>
            <div class="stat-val">{{ number_format($artistCount ?? 0) }}</div>
            <div class="stat-badge">
                <i class="fas fa-arrow-up" style="font-size:9px;"></i>
                +{{ $artistThisMonth ?? 0 }} tháng này
            </div>
            <div class="stat-manage">Quản lý ngay &rarr;</div>
        </a>
    </div>

    {{-- ── CHARTS ROW ── --}}
    <div class="charts-grid">

        {{-- Line chart: upload theo tháng --}}
        <div class="chart-card">
            <div class="card-title">Thống kê upload theo tháng {{ now()->year }}</div>
            <div class="chart-legend">
                <span class="legend-item">
                    <span class="legend-dot" style="background:#0aa2c0;"></span> Bài hát
                </span>
                <span class="legend-item">
                    <span class="legend-dot" style="background:#198754; border-radius:2px;"></span> Album
                </span>
            </div>
            <div style="position:relative; width:100%; height:210px;">
                <canvas id="lineChart"
                    role="img"
                    aria-label="Biểu đồ số bài hát và album được tải lên theo từng tháng trong năm {{ now()->year }}">
                    Dữ liệu thống kê upload theo tháng.
                </canvas>
            </div>
        </div>

        {{-- Donut: tỉ lệ nội dung --}}
        <div class="chart-card" style="display:flex; flex-direction:column; align-items:center; justify-content:center;">
            <div class="card-title" >Tỉ lệ nội dung</div>
            <div style="position:relative; width:170px; height:170px;">
                <canvas id="donutChart"
                    role="img"
                    aria-label="Biểu đồ tỉ lệ giữa bài hát, album và nghệ sĩ trong hệ thống">
                    Tỉ lệ nội dung hệ thống.
                </canvas>
            </div>
            <div class="chart-legend" style="margin-top:16px; flex-direction:column; gap:10px;">
                <span class="legend-item">
                    <span class="legend-dot" style="background:#0aa2c0;"></span>
                    Bài hát — {{ number_format($songCount ?? 0) }}
                </span>
                <span class="legend-item">
                    <span class="legend-dot" style="background:#198754;"></span>
                    Album — {{ number_format($albumCount ?? 0) }}
                </span>
                <span class="legend-item">
                    <span class="legend-dot" style="background:#ffc107;"></span>
                    Nghệ sĩ — {{ number_format($artistCount ?? 0) }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── BOTTOM ROW ── --}}
    <div class="bottom-grid">

        {{-- Top nghệ sĩ --}}
        <div class="list-card">
            <div class="card-title">Top nghệ sĩ theo số bài hát</div>
            @forelse ($topArtists ?? [] as $i => $artist)
            <div class="artist-row">
                <div style="display:flex; align-items:center;">
                    <div class="artist-rank {{ $i < 3 ? 'top' : '' }}">{{ $i + 1 }}</div>
                    <div class="artist-name">{{ $artist->name }}</div>
                </div>
                <div class="artist-count">{{ $artist->songs_count }} bài</div>
            </div>
            @empty
            <p style="font-size:13px; color:#aaa; text-align:center; padding:1rem 0;">Chưa có dữ liệu</p>
            @endforelse
        </div>

        {{-- Top album theo số bài --}}
        <div class="list-card">
            <div class="card-title">Top album nhiều bài nhất</div>
            @php
                $maxSongs = ($topAlbums ?? collect())->max('songs_count') ?: 1;
                $barColors = ['#0aa2c0','#198754','#ffc107','#e05c5c','#7c6fcd'];
            @endphp
            @forelse ($topAlbums ?? [] as $i => $album)
            <div class="bar-row">
                <div class="bar-name" title="{{ $album->title }}">{{ $album->title }}</div>
                <div class="bar-track">
                    <div class="bar-fill"
                         style="width:{{ round(($album->songs_count / $maxSongs) * 100) }}%;
                                background:{{ $barColors[$i % count($barColors)] }};"></div>
                </div>
                <div class="bar-val">{{ $album->songs_count }}</div>
            </div>
            @empty
            <p style="font-size:13px; color:#aaa; text-align:center; padding:1rem 0;">Chưa có dữ liệu</p>
            @endforelse
        </div>

    </div>
</div>

{{-- ── SCRIPTS ── --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script>
    // Ngày hiện tại
    document.getElementById('dbDate').textContent =
        new Date().toLocaleDateString('vi-VN', { weekday:'long', year:'numeric', month:'long', day:'numeric' });

    // Dữ liệu từ Laravel
    const songData  = @json($monthlySongs  ?? array_fill(0, 12, 0));
    const albumData = @json($monthlyAlbums ?? array_fill(0, 12, 0));
    const totalSong   = {{ $songCount   ?? 0 }};
    const totalAlbum  = {{ $albumCount  ?? 0 }};
    const totalArtist = {{ $artistCount ?? 0 }};

    const months = ['T1','T2','T3','T4','T5','T6','T7','T8','T9','T10','T11','T12'];

    // ── Line chart ──
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Bài hát',
                    data: songData,
                    borderColor: '#0aa2c0',
                    backgroundColor: 'rgba(10,162,192,0.07)',
                    tension: 0.42,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#0aa2c0',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    borderWidth: 2.5,
                },
                {
                    label: 'Album',
                    data: albumData,
                    borderColor: '#198754',
                    backgroundColor: 'transparent',
                    tension: 0.42,
                    fill: false,
                    pointRadius: 4,
                    pointBackgroundColor: '#198754',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    borderWidth: 2.5,
                    borderDash: [5, 4],
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 }, color: '#bbb' }
                },
                y: {
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                    ticks: { font: { size: 11 }, color: '#bbb' },
                    beginAtZero: true
                }
            }
        }
    });

    // ── Donut chart ──
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Bài hát', 'Album', 'Nghệ sĩ'],
            datasets: [{
                data: [totalSong, totalAlbum, totalArtist],
                backgroundColor: ['#0aa2c0', '#198754', '#ffc107'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '72%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed.toLocaleString('vi-VN')
                    }
                }
            }
        }
    });
</script>

</x-admin-layout>