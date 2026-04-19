<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Song;
use App\Models\Artist;
use App\Models\Album;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index() {
        // Chỉ lấy những cái có status = 1 (Đang hiện)
        $latestSongs = Song::where('status', 1)->with(['artists', 'album'])->latest()->take(4)->get();
        $topArtists = Artist::where('status', 1)->orderByDesc('follower_count')->take(4)->get();
        $topAlbums = Album::where('status', 1)->orderByDesc('play_count')->take(4)->get();
        
        return view('music.home', compact('latestSongs', 'topArtists', 'topAlbums'));
    }

    public function charts() {
        $topSongs = Song::where('status', 1)->with('artists')->orderByDesc('play_count')->take(20)->get();
        return view('music.charts', compact('topSongs'));
    }

    public function artists() {
        $artists = Artist::where('status', 1)->get();
        return view('music.artists', compact('artists'));
    }

    public function albums() {
        $albums = Album::where('status', 1)->get();
        return view('music.albums', compact('albums'));
    }

    public function favorites()
    {
        $user = Auth::user();

        $artists = $user->favoriteArtists()
            ->where('status', 1)
            ->get();

        $songs = $user->favoriteSongs()
            ->where('status', 1)
            ->with(['artists', 'album'])
            ->get();

        return view('music.favorites', compact('artists', 'songs'));
    }

    public function history() {
        $user = Auth::user();
        
        $histories = $user->playHistories()
                          ->whereHas('song', function ($query) {
                              $query->where('status', 1);
                          })
                          ->with(['song' => function ($query) {
                              $query->where('status', 1)->with(['artists', 'album']);
                          }])
                          ->latest()
                          ->take(30)
                          ->get();
                          
        return view('music.history', compact('histories'));
    }

    public function saveHistory($id) 
    {
        if (Auth::check()) {

            \App\Models\PlayHistory::create([
                'user_id' => Auth::id(),
                'song_id' => $id
            ]);

            $song = \App\Models\Song::find($id);
            if ($song) {
                $song->increment('play_count');
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'unauthenticated'], 401);
    }

    public function genres() {
        $genre = Genre::where('status', 1)->get();
        return view('music.genres', compact('genre')); 
    }

    public function songs(Request $request) {
        $availableMoods = [
            'chill' => 'Chill',
            'lam-viec' => 'Làm việc',
            'buon' => 'Buồn',
            'party' => 'Party',
        ];

        $selectedMood = $request->query('mood');
        if (!array_key_exists($selectedMood, $availableMoods)) {
            $selectedMood = null;
        }

        $songsQuery = Song::where('status', 1)->with(['artists', 'album', 'genres']);

        if ($selectedMood && Schema::hasColumn('songs', 'mood')) {
            $songsQuery->where('mood', $selectedMood);
        }

        $songs = $songsQuery->get();

        return view('music.songs', compact('songs', 'selectedMood', 'availableMoods'));
    }

    public function genreDetail($id) {
        // 1. Tìm thể loại đang chọn
        $genre = \App\Models\Genre::where('status', 1)->findOrFail($id);

        // 2. Lấy danh sách bài hát thuộc thể loại đó qua bảng trung gian
        $songs = $genre->songs() ->where('status', 1) ->with('artists')->paginate(15);

        return view('music.genre_detail', compact('genre', 'songs'));
    }

    public function artistDetail($id) {
        $artist = Artist::findOrFail($id);
        
        // Lấy danh sách bài hát của nghệ sĩ
        $songs = $artist->songs()
                        ->where('status', 1)
                        ->with('artists')
                        ->paginate(15);
        
        return view('music.artist_detail', compact('artist', 'songs'));
    }

    public function albumDetail($id) {
        $album = Album::findOrFail($id);
        
        // Lấy danh sách bài hát thuộc album này
        $songs = $album->songs()
                       ->where('status', 1)
                       ->with('artists') // Load kèm nghệ sĩ để tránh lỗi N+1
                       ->paginate(15);
        
        return view('music.album_detail', compact('album', 'songs'));
    }

    // Chức năng Thả Tim cho Nghệ sĩ (Yêu thích)
    public function toggleFavoriteArtist(Request $request, Artist $artist)
    {
        // Nếu chưa đăng nhập thì báo lỗi 401 để JS tự chuyển hướng
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();
        
        // Hàm toggle() của Laravel: Có rồi thì xóa, chưa có thì thêm!
        $user->favoriteArtists()->toggle($artist->id);

        // Kiểm tra xem trạng thái hiện tại là Đã thêm hay Đã xóa để trả về cho JS
        $isFavorited = $user->favoriteArtists()->where('artist_id', $artist->id)->exists();

        return response()->json(['status' => $isFavorited ? 'added' : 'removed']);
    }

    public function search(Request $request) 
    {
        // Nhận từ khóa từ Javascript gửi lên
        $keyword = $request->input('keyword');

        // Nếu không có từ khóa thì trả về rỗng
        if (!$keyword) {
            return response()->json(['songs' => [], 'artists' => [], 'albums' => []]);
        }

        // Tìm kiếm cơ bản bằng LIKE cho Sinh viên
        // 1. Tìm Bài hát (kèm thông tin nghệ sĩ để tí nữa gọi hàm Play)
        $songs = \App\Models\Song::where('status', 1)
                                 ->where('title', 'LIKE', '%' . $keyword . '%')
                                 ->with('artists')
                                 ->take(5) // Lấy tối đa 5 bài
                                 ->get();

        // 2. Tìm Nghệ sĩ
        $artists = \App\Models\Artist::where('status', 1)
                                     ->where('name', 'LIKE', '%' . $keyword . '%')
                                     ->take(3)
                                     ->get();

        // 3. Tìm Album
        $albums = \App\Models\Album::where('status', 1)
                                   ->where('title', 'LIKE', '%' . $keyword . '%')
                                   ->take(3)
                                   ->get();

        // Trả kết quả về dạng JSON cho Front-end
        return response()->json([
            'songs' => $songs,
            'artists' => $artists,
            'albums' => $albums
        ]);
    }
}