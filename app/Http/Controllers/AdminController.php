<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    // 1. Trang chủ Admin (Dashboard)
    public function dashboard()
    {
        // Tổng số
        $songCount   = Song::count();
        $albumCount  = Album::count();
        $artistCount = Artist::count();

        // Tăng trưởng tháng này
        $songThisMonth   = Song::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $albumThisMonth  = Album::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $artistThisMonth = Artist::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        // Bài hát & album upload theo 12 tháng (năm hiện tại)
        $monthlySongsRaw  = Song::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyAlbumsRaw = Album::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Điền đủ 12 tháng, tháng nào chưa có = 0
        $monthlySongs  = collect(range(1, 12))->map(fn($m) => $monthlySongsRaw[$m]  ?? 0)->values();
        $monthlyAlbums = collect(range(1, 12))->map(fn($m) => $monthlyAlbumsRaw[$m] ?? 0)->values();

        // Top 5 nghệ sĩ theo số bài hát
        $topArtists = Artist::withCount('songs')
            ->orderByDesc('songs_count')
            ->limit(5)
            ->get(['id', 'name', 'songs_count']);

        // Top 5 album theo số bài hát
        $topAlbums = Album::withCount('songs')
            ->orderByDesc('songs_count')
            ->limit(5)
            ->get(['id', 'title', 'songs_count']);

        return view('admin.dashboard', compact(
            'songCount', 'albumCount', 'artistCount',
            'songThisMonth', 'albumThisMonth', 'artistThisMonth',
            'monthlySongs', 'monthlyAlbums',
            'topArtists', 'topAlbums'
        ));
    }

    // 2. Quản lý BÀI HÁT
    public function songs()
    {
        $songs = Song::with(['artists', 'album'])->get();
        return view('admin.songs', compact('songs'));
    }

    public function deleteSong($id)
    {
        $song = Song::findOrFail($id);
        $song->status = ($song->status == 1) ? 0 : 1;
        $song->save();
        return back()->with('success', 'Đã cập nhật trạng thái bài hát!');
    }

    // 3. Quản lý ALBUM
    public function albums()
    {
        $albums = Album::all();
        return view('admin.albums', compact('albums'));
    }

    public function deleteAlbum($id)
    {
        $album = Album::findOrFail($id);
        $album->status = ($album->status == 1) ? 0 : 1;
        $album->save();
        return back()->with('success', 'Đã cập nhật trạng thái album!');
    }

    // 4. Quản lý NGHỆ SĨ
    public function artists()
    {
        $artists = Artist::all();
        return view('admin.artists', compact('artists'));
    }

    public function deleteArtist($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->status = ($artist->status == 1) ? 0 : 1;
        $artist->save();
        return back()->with('success', 'Đã cập nhật trạng thái nghệ sĩ!');
    }

    // Lưu nhạc
    public function createSong()
    {
        return view('admin.song_create');
    }

    public function storeSong(Request $request)
    {
        $request->validate([
            'title'     => 'required|max:255',
            'audio_url' => 'required',
        ]);

        Song::create([
            'title'        => $request->title,
            'album_id'     => $request->album_id,
            'audio_url'    => $request->audio_url,
            'cover_url'    => $request->cover_url,
            'duration'     => $request->duration ?? 0,
            'lyrics'       => $request->lyrics,
            'release_date' => $request->release_date,
            'status'       => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Thêm bài hát thành công!');
    }

    // Lưu Album
    public function createAlbum()
    {
        return view('admin.album_create');
    }

    public function storeAlbum(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        Album::create([
            'title'        => $request->title,
            'release_date' => $request->release_date,
            'cover_url'    => $request->cover_url,
            'status'       => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Thêm album thành công!');
    }

    // Lưu Nghệ sĩ
    public function createArtist()
    {
        return view('admin.art_create');
    }

    public function storeArtist(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        Artist::create([
            'name'       => $request->name,
            'slug'       => $request->slug ?? Str::slug($request->name),
            'avatar_url' => $request->avatar_url,
            'gender'     => $request->gender,
            'is_group'   => $request->is_group ?? 0,
            'status'     => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Thêm nghệ sĩ thành công!');
    }



    // --- Chỉnh sửa Bài hát ---
public function editSong($id) {
    $song = Song::findOrFail($id);
    $albums = Album::all(); 
    return view('admin.song_edit', compact('song', 'albums'));
}

public function updateSong(Request $request, $id) {
    $song = Song::findOrFail($id);
    $request->validate([
        'title'     => 'required|max:255',
        'audio_url' => 'required',
    ]);
    $song->update($request->all());
    return redirect()->route('admin.songs')->with('success', 'Cập nhật bài hát thành công!');
}

// --- Chỉnh sửa Album ---
public function editAlbum($id) {
    $album = Album::findOrFail($id);
    return view('admin.album_edit', compact('album'));
}

public function updateAlbum(Request $request, $id) {
    $album = Album::findOrFail($id);
    $request->validate(['title' => 'required|max:255']);
    $album->update($request->all());
    return redirect()->route('admin.albums')->with('success', 'Cập nhật album thành công!');
}

// --- Chỉnh sửa Nghệ sĩ ---
public function editArtist($id) {
    $artist = Artist::findOrFail($id);
    return view('admin.art_edit', compact('artist'));
}

public function updateArtist(Request $request, $id) {
    $artist = Artist::findOrFail($id);
    $request->validate(['name' => 'required|max:255']);
    
    $data = $request->all();
    if ($request->filled('name')) {
        $data['slug'] = \Illuminate\Support\Str::slug($request->name);
    }
    
    $artist->update($data);
    return redirect()->route('admin.artists')->with('success', 'Cập nhật nghệ sĩ thành công!');
}
}


