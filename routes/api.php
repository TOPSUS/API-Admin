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
});