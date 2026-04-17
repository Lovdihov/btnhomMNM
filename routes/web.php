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

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/songs', [AdminController::class, 'songs'])->name('songs');
    Route::get('/albums', [AdminController::class, 'albums'])->name('albums');
    Route::get('/artists', [AdminController::class, 'artists'])->name('artists');

    Route::post('/artists/delete/{id}', [AdminController::class, 'deleteArtist'])->name('artists.delete');
    Route::post('/songs/delete/{id}', [AdminController::class, 'deleteSong'])->name('songs.delete');
    Route::post('/albums/delete/{id}', [AdminController::class, 'deleteAlbum'])->name('albums.delete');
    Route::get('/song_create', [AdminController::class, 'createSong'])->name('songs.create');
    Route::post('/song_store', [AdminController::class, 'storeSong'])->name('songs.store');
    Route::get('/alb_create', [AdminController::class, 'createAlbum'])->name('albums.create');
    Route::post('/alb_store', [AdminController::class, 'storeAlbum'])->name('albums.store');
    Route::get('/art_create', [AdminController::class, 'createArtist'])->name('artists.create');
        Route::post('/art_store', [AdminController::class, 'storeArtist'])->name('artists.store');
});

require __DIR__.'/auth.php';