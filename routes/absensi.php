<?php

use Illuminate\Support\Facades\Route;

// Route::domain('absensi.'.parse_url(env('APP_URL'), PHP_URL_HOST))->group(function () {
//     Route::get('/', function(){
//         return view('absensi.home.index');
//     })->name('absensi.home');
// });
Route::prefix('absensi')->group(function () {
    Route::get('login', function(){
        if (!Auth::check()) {
            return view('auth.absensi.login');
        }else{
            return redirect()->route('absensi.home');
        }
    })->name('absensi.login');

    Route::post('login', [App\Http\Controllers\AuthAbsensi\LoginController::class, 'login'])->name('absensi.login.post');

    Route::group(['middleware' => ['auth_absensi']], function() {
        Route::get('home', [App\Http\Controllers\Absensi\AbsensiController::class, 'index'])->name('absensi.home');
        Route::get('home/search', [App\Http\Controllers\Absensi\AbsensiController::class, 'search_name'])->name('absensi.search_name');
        // Route::get('home/detail/{nik}', [App\Http\Controllers\Absensi\AbsensiController::class, 'detail'])->name('absensi.detail');
        
        Route::get('absensi_masuk/{scan_date}/{pin}/{inoutmode}', [App\Http\Controllers\Absensi\AbsensiController::class, 'detail_jam_masuk'])->name('absensi.detail_jam_masuk');
        Route::post('absensi_masuk/simpan', [App\Http\Controllers\Absensi\AbsensiController::class, 'detail_jam_masuk_simpan'])->name('absensi.detail_jam_masuk_simpan');
        
        Route::get('absensi_keluar/{scan_date}/{pin}/{inoutmode}', [App\Http\Controllers\Absensi\AbsensiController::class, 'detail_jam_keluar'])->name('absensi.detail_jam_keluar');
        Route::post('absensi_keluar/simpan', [App\Http\Controllers\Absensi\AbsensiController::class, 'detail_jam_keluar_simpan'])->name('absensi.detail_jam_keluar_simpan');
        
        Route::get('jam_masuk/{date_live}/{pin}/{inoutmode}', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_nofinger_jam_masuk_absensi'])->name('absensi.input_modal_nofinger_jam_masuk_absensi');
        Route::post('jam_masuk/no_finger/simpan', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_nofinger_jam_masuk_simpan'])->name('absensi.input_modal_nofinger_jam_masuk_simpan');
        
        Route::get('jam_pulang/{date_live}/{pin}/{inoutmode}', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_nofinger_jam_pulang_absensi'])->name('absensi.input_modal_nofinger_jam_pulang_absensi');
        Route::post('jam_pulang/no_finger/simpan', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_nofinger_jam_pulang_simpan'])->name('absensi.input_modal_nofinger_jam_pulang_simpan');

        Route::prefix('ijin_keluar_masuk')->group(function () {
            Route::get('/', [App\Http\Controllers\Absensi\IjinKeluarMasukController::class, 'index'])->name('ijin_keluar_masuk');
            Route::get('search', [App\Http\Controllers\Absensi\IjinKeluarMasukController::class, 'search'])->name('ijin_keluar_masuk.search');
            Route::post('simpan', [App\Http\Controllers\Absensi\IjinKeluarMasukController::class, 'simpan'])->name('ijin_keluar_masuk.simpan');
            Route::get('{id_ijin}', [App\Http\Controllers\Absensi\IjinKeluarMasukController::class, 'detail'])->name('ijin_keluar_masuk.detail');
            Route::post('update', [App\Http\Controllers\Absensi\IjinKeluarMasukController::class, 'update'])->name('ijin_keluar_masuk.update');
            Route::get('{id_ijin}/delete', [App\Http\Controllers\Absensi\IjinKeluarMasukController::class, 'delete'])->name('ijin_keluar_masuk.delete');
        });
        Route::prefix('ijin_terlambat')->group(function () {
            Route::get('/', [App\Http\Controllers\Absensi\IjinTerlambatController::class, 'index'])->name('ijin_terlambat');
            Route::get('search', [App\Http\Controllers\Absensi\IjinTerlambatController::class, 'search'])->name('ijin_terlambat.search');
            Route::post('simpan', [App\Http\Controllers\Absensi\IjinTerlambatController::class, 'simpan'])->name('ijin_terlambat.simpan');
            Route::get('{att_rec}', [App\Http\Controllers\Absensi\IjinTerlambatController::class, 'detail'])->name('ijin_terlambat.detail');
            Route::post('update', [App\Http\Controllers\Absensi\IjinTerlambatController::class, 'update'])->name('ijin_terlambat.update');
            Route::get('{att_rec}/delete', [App\Http\Controllers\Absensi\IjinTerlambatController::class, 'delete'])->name('ijin_terlambat.delete');
        });
        Route::prefix('presensi')->group(function () {
            Route::get('/', [App\Http\Controllers\Absensi\PresensiController::class, 'index'])->name('presensi');
            Route::get('search', [App\Http\Controllers\Absensi\PresensiController::class, 'search'])->name('presensi.search');
            Route::get('detail/{nik}', [App\Http\Controllers\Absensi\PresensiController::class, 'detail'])->name('presensi.detail');
            Route::get('detail/{nik}/search', [App\Http\Controllers\Absensi\PresensiController::class, 'search_detail'])->name('presensi.search_detail');
            Route::get('detail/{nik}/cetak', [App\Http\Controllers\Absensi\PresensiController::class, 'detail_print'])->name('presensi.detail_print');
        });
        // Route::get('jam_masuk/edit/{att_rec}', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_edit_nofinger_jam_masuk_absensi'])->name('absensi.input_modal_edit_nofinger_jam_masuk_absensi');
        // Route::post('jam_masuk/no_finger/update', [App\Http\Controllers\Absensi\AbsensiController::class, 'input_modal_edit_nofinger_jam_masuk_update'])->name('absensi.input_modal_edit_nofinger_jam_masuk_update');
        
        // Route::get('home', function(){
        //     return view('absensi.home.index');
        // })->name('absensi.home');
    });
});