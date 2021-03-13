<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* Authentication Routes */
Route::prefix('admin')->group(function () {
    Route::post('login', 'AuthController@login');
});

Route::get('unauthenticate', function() {
    return response([
        'status' => 401,
        'message' => 'Not Authenticate, Login First!'
    ]);
})->name('unauthenticate');

Route::middleware(['auth:sanctum'])->group(function () {
    /* Route for Testing API */
    Route::get('test/data', function(Request $request) {
        return response([
            'status' => 200,
            'message' => $request->user()
        ]);
    });

    /* Review Routes */
    Route::resource('review', 'ReviewController');

    /* Transaksi Routes */
    Route::get('transaksi/proses', 'PembelianController@indexProses');
    Route::get('transaksi/done', 'PembelianController@indexDone');

    /* Jadwal Routes */
    Route::resource('jadwal', 'JadwalController');

    /* Reward Routes */
    Route::resource('reward', 'RewardController');

    /* Speedboat Routes */
    Route::resource('speedboat', 'SpeedboatController');
    Route::get('speedboat/{id}/berita', 'SpeedboatController@berita');
    Route::get('speedboat/{id}/review', 'SpeedboatController@review');

    /* Berita Speedboat */
    Route::resource('berita-speedboat', 'BeritaSpeedboatController');
    Route::get('berita-speedboat/{id}/index', 'BeritaSpeedboatController@indexSpeedboat');
});