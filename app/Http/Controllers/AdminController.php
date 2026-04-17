<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    // 1. Trang chủ Admin (Dashboard)
    public function dashboard() {
        $data = [
            'songCount' => Song::count(),
            'albumCount' => Album::count(),
            'artistCount' => Artist::count(),
        ];
        return view('admin.dashboard', $data);
    }

    // 2. Quản lý BÀI HÁT
    public function songs() {
        $songs = Song::with(['artists', 'album'])->get();
        return view('admin.songs', compact('songs'));
    }

    public function deleteSong($id) {
        $song = Song::findOrFail($id);
        $song->status = ($song->status == 1) ? 0 : 1;
        $song->save();
        return back()->with('success', 'Đã xóa bài hát thành công!');
    }

    // 3. Quản lý ALBUM
    public function albums() {
        $albums = Album::all();
        return view('admin.albums', compact('albums'));
    }

    public function deleteAlbum($id) {
        $album = Album::findOrFail($id);
        $album->status = ($album->status == 1) ? 0 : 1;
        $album->save();
        return back()->with('success', 'Đã xóa album thành công!');
    }

    // 4. Quản lý NGHỆ SĨ
    public function artists() {
        $artists = Artist::all();
        return view('admin.artists', compact('artists'));
    }

    public function deleteArtist($id) {
        $artist = Artist::findOrFail($id);
        $artist->status = ($artist->status == 1) ? 0 : 1;
        $artist->save();
        return back()->with('success', 'Đã xóa nghệ sĩ thành công!');
    }

    // Lưu nhạc
    public function createSong()
    {
        return view('admin.song_create');
    }

    public function storeSong(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'audio_url' => 'required',
        ]);

        Song::create([
            'title' => $request->title,
            'album_id' => $request->album_id,
            'audio_url' => $request->audio_url,
            'cover_url' => $request->cover_url,
            'duration' => $request->duration ?? 0,
            'lyrics' => $request->lyrics,
            'release_date' => $request->release_date,
            'status' => $request->status ?? 1,
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
            'title' => $request->title,
            'release_date' => $request->release_date,
            'cover_url' => $request->cover_url,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Thêm album thành công!');
    }

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
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'avatar_url' => $request->avatar_url,
            'gender' => $request->gender,
            'is_group' => $request->is_group ?? 0,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Thêm nghệ sĩ thành công!');
    }
}