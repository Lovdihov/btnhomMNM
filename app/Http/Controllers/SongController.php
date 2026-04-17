<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    // 1. Chức năng Tăng lượt nghe
    public function incrementPlayCount(Request $request, Song $song)
    {
        // Tăng trường play_count lên 1
        $song->increment('play_count');

        // (Nâng cao) Nếu User đã đăng nhập, lưu vào Lịch sử nghe (PlayHistory)
        if (Auth::check()) {
            Auth::user()->playHistories()->create([
                'song_id' => $song->id
            ]);
        }

        return response()->json(['success' => true, 'current_plays' => $song->play_count]);
    }

    // 2. Chức năng Thả Tim (Yêu thích)
    public function toggleFavorite(Request $request, Song $song)
    {
        // Nếu chưa đăng nhập thì báo lỗi 401 để JS tự chuyển hướng
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        
        // Hàm toggle() của Laravel cực kỳ vi diệu: Có rồi thì xóa, chưa có thì thêm!
        $user->favoriteSongs()->toggle($song->id);

        // Kiểm tra xem trạng thái hiện tại là Đã thêm hay Đã xóa để trả về màu cho JS
        $isFavorited = $user->favoriteSongs()->where('song_id', $song->id)->exists();

        return response()->json(['status' => $isFavorited ? 'added' : 'removed']);
    }
}