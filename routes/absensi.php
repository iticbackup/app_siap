<?php

use Illuminate\Support\Facades\Route;

// Route::domain('absensi.'.parse_url(env('APP_URL'), PHP_URL_HOST))->group(function () {
//     Route::get('/', function(){
//         return view('absensi.home.index');
//     })->name('absensi.home');
// });
Route::prefix('absensi')->group(function () {
    Route::get('login', function(){
        return view('auth.absensi.login');
    })->name('absensi.login');

    Route::post('login', [App\Http\Controllers\AuthAbsensi\LoginController::class, 'login'])->name('absensi.login.post');

    Route::group(['middleware' => ['auth_absensi']], function() {
        Route::get('home', [App\Http\Controllers\Absensi\AbsensiController::class, 'index'])->name('absensi.home');
        Route::get('fin_tes', [App\Http\Controllers\Absensi\AbsensiController::class, 'fin_tes']);
        Route::get('jam_masuk/{date_live}/{pin}/{inout}', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_nofinger_jam_masuk_absensi'])->name('absensi.input_modal_nofinger_jam_absensi');
        Route::post('jam_masuk/no_finger/simpan', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_nofinger_jam_masuk_simpan'])->name('absensi.input_modal_nofinger_jam_masuk_simpan');
        Route::get('jam_masuk/edit/{att_rec}', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_edit_nofinger_jam_masuk_absensi'])->name('absensi.input_modal_edit_nofinger_jam_masuk_absensi');
        Route::post('jam_masuk/no_finger/update', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_edit_nofinger_jam_masuk_update'])->name('absensi.input_modal_edit_nofinger_jam_masuk_update');
        // Route::get('home', function(){
        //     return view('absensi.home.index');
        // })->name('absensi.home');
    });
});