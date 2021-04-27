<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    Route::post('logout', 'AuthController@logout');
    Route::post('getcode', 'AuthController@getCodes');
    Route::post('cekcode', 'AuthController@cekCodes');
    Route::post('forgotpass', 'AuthController@forgotPass');
});

Route::get('unauthenticate', function() {
    return response([
        'status' => 401,
        'message' => 'Not Authenticate, Login First!'
    ]);
})->name('unauthenticate');

Route::get('qrcode', function() {
    $detail = \App\DetailPembelian::where('id_detail_pembelian', 1)->first();
    $qr = QrCode::size(256)->generate($detail->kode_tiket);
    echo $qr;
});

Route::get('qrcode/{id}', function($id) {
    $detail = \App\DetailPembelian::where('id_detail_pembelian', $id)->first();
    $qr = QrCode::size(256)->generate($detail->kode_tiket);
    echo $qr;
});

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
    Route::get('transaksi/detail/{id}', 'PembelianController@detailTransaksi');
    Route::get('transaksi/tiket/{kode_tiket}', 'PembelianController@showTiket');
    Route::get('transaksi/tiket/approve/{id}', 'PembelianController@approveTiket');
    Route::get('transaksi/approve/{id}', 'PembelianController@approvePembelian');

    /* Jadwal Routes */
    Route::resource('jadwal', 'JadwalController');

    /* Reward Routes */
    Route::resource('reward', 'RewardController');

    /* Speedboat Routes */
    Route::get('kapal', 'SpeedboatController@index');
    Route::get('kapal/show/{kapal}', 'SpeedboatController@show');
    Route::get('kapal/{kapal}', 'SpeedboatController@destroy');
    Route::post('kapal', 'SpeedboatController@store');
    Route::post('kapal/update/{kapal}', 'SpeedboatController@update');
    Route::get('speedboat/{id}/berita', 'SpeedboatController@berita');
    Route::get('speedboat/{id}/review', 'SpeedboatController@review');

    /* Berita Speedboat */
    Route::resource('berita-speedboat', 'BeritaSpeedboatController');
    Route::get('berita-speedboat/{id}/index', 'BeritaSpeedboatController@indexSpeedboat');

    Route::resource('pelabuhan', 'PelabuhanController');
    Route::get('pelabuhan/get/name', 'PelabuhanController@getPelabuhanName');
    
    Route::get('golongan/get/{id}', 'GolonganController@golonganByPelabuhan');
    Route::get('user/get/{id}', 'UserController@edit');
    Route::post('user/update/{id}', 'UserController@update');
    Route::post('gantipass','AuthController@gantiPass');
});