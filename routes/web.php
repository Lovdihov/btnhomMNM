<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

Route::get('/bang-xep-hang', [HomeController::class, 'charts'])->name('charts');
Route::get('/the-loai', [HomeController::class, 'genres'])->name('genres');
Route::get('/nghe-si', [HomeController::class, 'artists'])->name('artists');
Route::get('/album', [HomeController::class, 'albums'])->name('albums');
Route::get('/bai-hat', [HomeController::class, 'songs'])->name('songs');

Route::get('/the-loai/{id}', [HomeController::class, 'genreDetail'])->name('music.genre_detail');
Route::get('/nghe-si/{id}', [HomeController::class, 'artistDetail'])->name('music.artist_detail');
Route::get('/album/{id}', [HomeController::class, 'albumDetail'])->name('album_detail');

Route::post('/tim-kiem', [HomeController::class, 'search'])->name('search');
Route::post('/songs/{id}/history', [HomeController::class, 'saveHistory'])
    ->middleware('auth')
    ->name('songs.history');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');

    Route::get('/yeu-thich', [HomeController::class, 'favorites'])->name('user.favorites');
    Route::get('/nghe-si-yeu-thich', [HomeController::class, 'favoriteArtists'])->name('user.favorite_artists');
    Route::get('/lich-su-nghe', [HomeController::class, 'history'])->name('user.history');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/songs/{song}/play', [SongController::class, 'incrementPlayCount']);
Route::post('/songs/{song}/favorite', [SongController::class, 'toggleFavorite']);
Route::post('/artists/{artist}/favorite', [HomeController::class, 'toggleFavoriteArtist']);

// Trang Quản trị (Admin)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // 1. DASHBOARD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 2. QUẢN LÝ BÀI HÁT (SONGS)
    Route::controller(AdminController::class)->group(function () {
        Route::get('/songs', 'songs')->name('songs');
        Route::get('/songs/create', 'createSong')->name('songs.create');
        Route::post('/songs/store', 'storeSong')->name('songs.store');
        Route::get('/songs/edit/{id}', 'editSong')->name('songs.edit');
        Route::put('/songs/update/{id}', 'updateSong')->name('songs.update');
        Route::post('/songs/delete/{id}', 'deleteSong')->name('songs.delete');
    });

    // 3. QUẢN LÝ ALBUM
    Route::controller(AdminController::class)->group(function () {
        Route::get('/albums', 'albums')->name('albums');
        Route::get('/albums/create', 'createAlbum')->name('albums.create');
        Route::post('/albums/store', 'storeAlbum')->name('albums.store');
        Route::get('/albums/edit/{id}', 'editAlbum')->name('albums.edit');
        Route::put('/albums/update/{id}', 'updateAlbum')->name('albums.update');
        Route::post('/albums/delete/{id}', 'deleteAlbum')->name('albums.delete');
    });

    // 4. QUẢN LÝ NGHỆ SĨ (ARTISTS)
    Route::controller(AdminController::class)->group(function () {
        Route::get('/artists', 'artists')->name('artists');
        Route::get('/artists/create', 'createArtist')->name('artists.create');
        Route::post('/artists/store', 'storeArtist')->name('artists.store');
        Route::get('/artists/edit/{id}', 'editArtist')->name('artists.edit');
        Route::put('/artists/update/{id}', 'updateArtist')->name('artists.update');
        Route::post('/artists/delete/{id}', 'deleteArtist')->name('artists.delete');
    });

    // 5. QUẢN LÝ NGƯỜI DÙNG (USERS)
    Route::controller(AdminController::class)->group(function () {
        Route::get('/users', 'users')->name('users');
        Route::get('/users/create', 'createUser')->name('users.create');
        Route::post('/users/store', 'storeUser')->name('users.store');
        Route::get('/users/edit/{id}', 'editUser')->name('users.edit');
        Route::put('/users/update/{id}', 'updateUser')->name('users.update');
        Route::delete('/users/delete/{id}', 'deleteUser')->name('users.delete');
    });
});

require __DIR__.'/auth.php';