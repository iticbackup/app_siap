<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

// Route::resource('login', App\Http\Controllers\Auth\LoginController::class);
Route::prefix('docs')->group(function () {
    Route::get('/', function(){
        return view('documentation.index');
    })->name('docs.index');
    Route::get('file_management', function(){
        return view('documentation.file_manager');
    })->name('docs.file_management');
});
Route::prefix('cek_dokumen')->group(function () {
    Route::get('/', function(){
        return view('verifikasi_dokumen.index');
    })->name('cek_dokumen');
    Route::post('search', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'cek_verifikasi_dokumen'])->name('cek_verifikasi_dokumen');
});

Route::get('modules', [App\Http\Controllers\ModulesController::class, 'f_index'])->name('f_module');
Route::get('modules/{id}/download', [App\Http\Controllers\ModulesController::class, 'f_download'])->name('f_module.download');

Route::get('testing', function(){
    return request()->ip();
});

Route::group(['middleware' => ['auth']], function() {
    // Route::get('testing', function(){
    //     $array = array('2023-09-02,2023-09-03');
    //     return implode(',',$array);
    // });
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('activity_log', [App\Http\Controllers\UserController::class, 'activity_log'])->name('activity_log');
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{nama}/search', [App\Http\Controllers\UserController::class, 'search_nik']);
    Route::resource('products', App\Http\Controllers\ProductController::class);

    // Route::prefix('users')->group(function () {

    // });

    Route::prefix('file_manager')->group(function () {
        Route::get('/', [App\Http\Controllers\FileManagerController::class, 'index'])->name('file_manager');
        Route::get('{id}', [App\Http\Controllers\FileManagerController::class, 'detail_departemen'])->name('file_manager.detail_departemen');
        Route::get('{id}/kategori', [App\Http\Controllers\FileManagerController::class, 'file_manager_kategori'])->name('file_manager.kategori');
        Route::post('kategori_simpan', [App\Http\Controllers\FileManagerController::class, 'file_manager_kategori_simpan'])->name('file_manager.kategori_simpan');
        Route::get('kategori/{kategori_id}', [App\Http\Controllers\FileManagerController::class, 'file_manager_list'])->name('file_manager.file_manager_list');
        Route::post('upload_file/simpan', [App\Http\Controllers\FileManagerController::class, 'file_manager_list_upload_simpan'])->name('file_manager.file_manager_list_upload_simpan');
        Route::post('upload_file_fr/simpan', [App\Http\Controllers\FileManagerController::class, 'file_manager_list_upload_fr_simpan'])->name('file_manager.file_manager_list_upload_fr_simpan');
        Route::get('preview/{id}', [App\Http\Controllers\FileManagerController::class, 'file_manager_list_preview'])->name('file_manager.file_manager_list_preview');
        Route::get('download/{id}', [App\Http\Controllers\FileManagerController::class, 'file_manager_list_download'])->name('file_manager.file_manager_list_download');
        Route::get('delete/{id}', [App\Http\Controllers\FileManagerController::class, 'file_manager_list_delete'])->name('file_manager.file_manager_list_delete');
    });

    Route::prefix('permission')->group(function () {
        Route::get('/', [App\Http\Controllers\PermissionController::class, 'index'])->name('permission');
        Route::post('simpan', [App\Http\Controllers\PermissionController::class, 'simpan'])->name('permission.simpan');
        Route::get('{id}', [App\Http\Controllers\PermissionController::class, 'detail'])->name('permission.detail');
        Route::post('update', [App\Http\Controllers\PermissionController::class, 'update'])->name('permission.update');
    });

    Route::prefix('departemen')->group(function () {
        Route::get('/', [App\Http\Controllers\DepartemenController::class, 'index'])->name('departemen');
        Route::post('simpan', [App\Http\Controllers\DepartemenController::class, 'simpan'])->name('departemen.simpan');
        Route::get('{id}', [App\Http\Controllers\DepartemenController::class, 'detail'])->name('departemen.detail');
        Route::post('update', [App\Http\Controllers\DepartemenController::class, 'update'])->name('departemen.update');
        Route::get('{id}/delete', [App\Http\Controllers\DepartemenController::class, 'delete'])->name('departemen.delete');
        Route::get('{id}/team', [App\Http\Controllers\DepartemenController::class, 'detail_team'])->name('departemen.detail_team');
        Route::post('{id}/team/simpan', [App\Http\Controllers\DepartemenController::class, 'team_simpan'])->name('departemen.team_simpan');
        Route::post('search_nik', [App\Http\Controllers\DepartemenController::class, 'search_nik'])->name('departemen.search_nik');
    });

    Route::prefix('rekap_pelatihan')->group(function () {
        Route::prefix('kategori')->group(function () {
            Route::get('/', [App\Http\Controllers\RekapPelatihanController::class, 'kategori_index'])->name('rekap_pelatihan.kategori');
            Route::post('simpan', [App\Http\Controllers\RekapPelatihanController::class, 'kategori_simpan'])->name('rekap_pelatihan.kategori_simpan');
            Route::get('{id}', [App\Http\Controllers\RekapPelatihanController::class, 'kategori_detail'])->name('rekap_pelatihan.kategori_detail');
            Route::post('update', [App\Http\Controllers\RekapPelatihanController::class, 'kategori_update'])->name('rekap_pelatihan.kategori_update');
            Route::get('{id}/delete', [App\Http\Controllers\RekapPelatihanController::class, 'kategori_delete'])->name('rekap_pelatihan.kategori_delete');
        });
        Route::get('/', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_rekap'])->name('rekap_pelatihan.rekap_pelatihan');
        // Route::get('{periode}', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_rekap'])->name('rekap_pelatihan.rekap_pelatihan');
        Route::get('cari_peserta', [App\Http\Controllers\RekapPelatihanController::class, 'search_karyawan_departemen'])->name('rekap_pelatihan.cari_peserta');
        Route::get('create', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_create'])->name('rekap_pelatihan.create');
        Route::post('simpan', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_simpan'])->name('rekap_pelatihan.simpan');
        Route::get('{id}', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_detail'])->name('rekap_pelatihan.rekap_pelatihan_detail');
        Route::get('{id}/edit', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_edit'])->name('rekap_pelatihan.rekap_pelatihan_edit');
        Route::post('canvas_right_update', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_canvas_right_update'])->name('rekap_pelatihan.canvas_right_update');
        Route::post('{id}/update', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_update'])->name('rekap_pelatihan.rekap_pelatihan_update');
        Route::get('{id}/delete', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_delete'])->name('rekap_pelatihan.rekap_pelatihan_delete');
        Route::post('search_rekapan', [App\Http\Controllers\RekapPelatihanController::class, 'search_rekapan_pelatihan'])->name('rekap_pelatihan.search_excel_rekap_pelatihan');
        Route::get('download_excel_rekap/{periode}', [App\Http\Controllers\RekapPelatihanController::class, 'download_excel_rekap'])->name('rekap_pelatihan.download_excel_rekap');
        Route::get('download_excel_rekap_all_dep/{periode}', [App\Http\Controllers\RekapPelatihanController::class, 'download_excel_rekap_all_dep'])->name('rekap_pelatihan.download_excel_rekap_all_dep');
        Route::get('download_excel_rekap_all_pelatihan/{periode}', [App\Http\Controllers\RekapPelatihanController::class, 'download_excel_rekap_all_pelatihan'])->name('rekap_pelatihan.download_excel_rekap_all_pelatihan');
        Route::get('download_excel_rekap_periode/{periode}', [App\Http\Controllers\RekapPelatihanController::class, 'download_excel_rekap_periode'])->name('rekap_pelatihan.download_excel_rekap_periode');
        Route::post('upload_file', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_upload_file'])->name('rekap_pelatihan.upload_file');
        Route::get('{id}/tambah_peserta', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_tambah_peserta'])->name('rekap_pelatihan.rekap_pelatihan_tambah_peserta');
        Route::post('{id}/tambah_peserta/update', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_tambah_peserta_update'])->name('rekap_pelatihan.rekap_pelatihan_tambah_peserta_update');
        Route::get('{id}/{id_peserta}/delete', [App\Http\Controllers\RekapPelatihanController::class, 'rekap_pelatihan_hapus_peserta'])->name('rekap_pelatihan.rekap_pelatihan_hapus_peserta');

    });

    Route::prefix('perubahan_data')->group(function () {
        Route::get('/', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'index'])->name('perubahan_data');
        Route::get('create_no_formulir', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'buat_nomor_formulir'])->name('perubahan_data.buat_nomor_formulir');
        Route::post('create_no_formulir', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'buat_nomor_formulir_simpan'])->name('perubahan_data.buat_nomor_formulir.simpan');
        Route::get('create/{id}', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'create'])->name('perubahan_data.create');
        Route::post('create/{id}', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'detail_form_simpan'])->name('perubahan_data.detail_form_simpan');
        Route::post('create/{id}/formulir', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'simpan'])->name('perubahan_data.simpan');
        // Route::post('simpan', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'simpan'])->name('perubahan_data.simpan');
        Route::get('{id}', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'detail'])->name('perubahan_data.detail');
        Route::get('{id}/validasi', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'cek_validasi'])->name('perubahan_data.cek_validasi');
        Route::post('{id}/validasi/submit', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'validasi_submit'])->name('perubahan_data.validasi_submit');
        Route::get('{id}/cetak', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'cetak_dokumen'])->name('perubahan_data.cetak_dokumen');
        Route::get('{id}/edit', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'edit'])->name('perubahan_data.detail.edit');
        Route::post('{id}/update', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'update'])->name('perubahan_data.update');
        Route::get('{id}/{id_perubahan_data_detail}/delete', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'delete_perubahan_data_detail'])->name('perubahan_data.delete_perubahan_data_detail');
        Route::get('{id}/{id_perubahan_data_detail}/cek_dokumen', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'cek_dokumen_validasi'])->name('perubahan_data.cek_dokumen');

        Route::post('download/periode', [App\Http\Controllers\PerubahanDataFileManagerController::class, 'download_report'])->name('perubahan_data.download_report');
    });

    Route::prefix('kpi')->group(function () {
        Route::get('/', [App\Http\Controllers\KpiController::class, 'index'])->name('kpi');
        Route::get('create', [App\Http\Controllers\KpiController::class, 'buat_kpi'])->name('kpi.buat_kpi');
        Route::get('indikator', [App\Http\Controllers\KpiController::class, 'kpi_indikator'])->name('kpi.kpi_indikator');
        Route::get('indikator/team/{departemen_user_id}', [App\Http\Controllers\KpiController::class, 'kpi_indikator_buat'])->name('kpi.kpi_indikator_buat');
        Route::post('indikator/team/{departemen_user_id}/simpan', [App\Http\Controllers\KpiController::class, 'kpi_indikator_simpan'])->name('kpi.kpi_indikator_simpan');
        Route::get('indikator/team/{departemen_user_id}/{id}/edit', [App\Http\Controllers\KpiController::class, 'kpi_indikator_edit'])->name('kpi.kpi_indikator_edit');
        Route::post('indikator/team/{departemen_user_id}/{id}/edit', [App\Http\Controllers\KpiController::class, 'kpi_indikator_update'])->name('kpi.kpi_indikator_update');
        Route::get('indikator/team/{departemen_user_id}/{id}/delete', [App\Http\Controllers\KpiController::class, 'kpi_indikator_delete'])->name('kpi.kpi_indikator_delete');
        Route::get('departemen', [App\Http\Controllers\KpiController::class, 'kpi_departemen'])->name('kpi.kpi_departemen');
        Route::get('departemen/{id}', [App\Http\Controllers\KpiController::class, 'kpi_departemen_detail'])->name('kpi.kpi_departemen_detail');
        Route::post('departemen/simpan', [App\Http\Controllers\KpiController::class, 'kpi_departemen_detail_simpan'])->name('kpi.kpi_departemen_detail_simpan');
        Route::get('{date}', [App\Http\Controllers\KpiController::class, 'input_date_kpi'])->name('kpi_date');
        Route::post('{date}/simpan', [App\Http\Controllers\KpiController::class, 'input_date_kpi_simpan'])->name('kpi.input_date_kpi_simpan');
        Route::get('{date}/departemen', [App\Http\Controllers\KpiController::class, 'input_detail_kpi_departemen'])->name('kpi.input_detail_kpi_departemen');
        Route::get('{date}/departemen/{id_departemen}/detail', [App\Http\Controllers\KpiController::class, 'input_date_kpi_detail'])->name('kpi.input_date_kpi_detail');
        Route::get('{date}/departemen/{id_departemen}/validasi', [App\Http\Controllers\KpiController::class, 'input_date_kpi_validasi'])->name('kpi.input_date_kpi_validasi');
        Route::post('{date}/departemen/{id_departemen}/validasi/simpan', [App\Http\Controllers\KpiController::class, 'input_date_kpi_validasi_simpan'])->name('kpi.input_date_kpi_validasi_simpan');
        Route::get('{date}/departemen/{id_departemen}/print', [App\Http\Controllers\KpiController::class, 'kpi_print'])->name('kpi.kpi_print');
    });

    Route::prefix('b_modules')->group(function () {
        Route::get('/', [App\Http\Controllers\ModulesController::class, 'b_index'])->name('b_module');
        Route::post('simpan', [App\Http\Controllers\ModulesController::class, 'b_simpan'])->name('b_module.simpan');
        Route::get('{id}', [App\Http\Controllers\ModulesController::class, 'b_detail'])->name('b_module.detail');
        Route::post('update', [App\Http\Controllers\ModulesController::class, 'b_update'])->name('b_module.update');
        Route::get('{id}/delete', [App\Http\Controllers\ModulesController::class, 'b_delete'])->name('b_module.delete');
    });

    Route::prefix('hrga')->group(function () {
        Route::prefix('biodata_karyawan')->group(function () {
            Route::get('/', [App\Http\Controllers\HRGAController::class, 'index_biodata_karyawan'])->name('hrga.biodata_karyawan');
            Route::get('data_karyawan', [App\Http\Controllers\HRGAController::class, 'data_karyawan'])->name('hrga.data_karyawan');
            Route::get('search/{nik}', [App\Http\Controllers\HRGAController::class, 'get_search_data_karyawan'])->name('hrga.get_search_data_karyawan');
            Route::post('simpan', [App\Http\Controllers\HRGAController::class, 'simpan'])->name('hrga.biodata_karyawan.simpan');
            Route::post('update', [App\Http\Controllers\HRGAController::class, 'update'])->name('hrga.biodata_karyawan.update');
            Route::get('{nik}/detail', [App\Http\Controllers\HRGAController::class, 'detail'])->name('hrga.biodata_karyawan.detail');
            Route::get('{nik}/detail_kontrak_kerja', [App\Http\Controllers\HRGAController::class, 'detail_kontrak_kerja'])->name('hrga.biodata_karyawan.detail_kontrak_kerja');
            Route::post('kontrak_kerja/simpan', [App\Http\Controllers\HRGAController::class, 'kontrak_kerja_simpan'])->name('hrga.biodata_karyawan.kontrak_kerja_simpan');
            Route::post('riwayat_konseling/simpan', [App\Http\Controllers\HRGAController::class, 'riwayat_konseling_simpan'])->name('hrga.biodata_karyawan.riwayat_konseling_simpan');
            Route::get('download_rekap_excel/{tanggal}', [App\Http\Controllers\HRGAController::class, 'download_rekap_excel'])->name('hrga.biodata_karyawan.donwload_rekap_excel');
            Route::post('karyawan_resign/simpan', [App\Http\Controllers\HRGAController::class, 'resign_simpan'])->name('hrga.biodata_karyawan.resign_simpan');
            Route::get('{nama}/cek_rekap_training', [App\Http\Controllers\HRGAController::class, 'cek_riwayat_training_karyawan'])->name('hrga.biodata_karyawan.cek_riwayat_training_karyawan');
            Route::post('riwayat_training/simpan', [App\Http\Controllers\HRGAController::class, 'riwayat_training_simpan'])->name('hrga.biodata_karyawan.riwayat_training_simpan');
            
            Route::get('aktif', [App\Http\Controllers\HRGAController::class, 'index_biodata_karyawan_aktif'])->name('hrga.biodata_karyawan.aktif');
            Route::get('non_aktif', [App\Http\Controllers\HRGAController::class, 'index_biodata_karyawan_non_aktif'])->name('hrga.biodata_karyawan.non_aktif');

            Route::get('buat_karyawan_baru', [App\Http\Controllers\HRGAController::class, 'buat_karyawan_baru'])->name('hrga.biodata_karyawan.buat_karyawan_baru');
            Route::post('buat_karyawan_baru/simpan', [App\Http\Controllers\HRGAController::class, 'buat_karyawan_baru_simpan'])->name('hrga.biodata_karyawan.buat_karyawan_baru.simpan');
        });
        Route::prefix('rekap_pelatihan')->group(function () {
            Route::get('/', [App\Http\Controllers\HRGAController::class, 'rekap_pelatihan'])->name('hrga.rekap_pelatihan');
            Route::get('{id}/detail', [App\Http\Controllers\HRGAController::class, 'rekap_pelatihan_detail'])->name('hrga.rekap_pelatihan_detail');
            Route::post('simpan', [App\Http\Controllers\HRGAController::class, 'rekap_pelatihan_detail_simpan'])->name('hrga.rekap_pelatihan_detail_simpan');
        });
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
        Route::post('update_personal_info', [App\Http\Controllers\ProfileController::class, 'personal_info_update'])->name('profile.personal_info');
        Route::post('update_password', [App\Http\Controllers\ProfileController::class, 'password_personal_update'])->name('profile.password_personal_update');
    });

    Route::get('testing', [App\Http\Controllers\TestingController::class, 'testing2'])->name('testing_pdf');

});