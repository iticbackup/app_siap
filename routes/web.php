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
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/', function () {
    return view('welcome');
});

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

// Route::get('testing', function(){
//     return request()->ip();
// });

Route::group(['middleware' => ['auth', 'LogVisits']], function() {
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('activity_log', [App\Http\Controllers\UserController::class, 'activity_log'])->name('activity_log');
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{nama}/search', [App\Http\Controllers\UserController::class, 'search_nik']);
    Route::resource('products', App\Http\Controllers\ProductController::class);

    Route::controller(App\Http\Controllers\PeriodeController::class)->group(function () {
        Route::prefix('periode')->group(function () {
            Route::get('/', 'index')->name('periode');
            Route::post('simpan', 'simpan')->name('periode.simpan');
            Route::get('{id}/detail', 'detail')->name('periode.detail');
            Route::post('update', 'update')->name('periode.update');
            Route::get('{id}/delete', 'delete')->name('periode.delete');
        });
    });

    Route::controller(App\Http\Controllers\FileManagerController::class)->group(function () {
        Route::prefix('file_manager')->group(function () {
            Route::get('/', 'index')->name('file_manager');
            Route::get('{id}', 'detail_departemen')->name('file_manager.detail_departemen');
            Route::get('{id}/kategori', 'file_manager_kategori')->name('file_manager.kategori');
            Route::post('kategori_simpan', 'file_manager_kategori_simpan')->name('file_manager.kategori_simpan');
            Route::get('kategori/{kategori_id}', 'file_manager_list')->name('file_manager.file_manager_list');
            Route::post('upload_file/simpan', 'file_manager_list_upload_simpan')->name('file_manager.file_manager_list_upload_simpan');
            Route::post('upload_file_fr/simpan', 'file_manager_list_upload_fr_simpan')->name('file_manager.file_manager_list_upload_fr_simpan');
            Route::get('preview/{id}', 'file_manager_list_preview')->name('file_manager.file_manager_list_preview');
            Route::get('download/{id}', 'file_manager_list_download')->name('file_manager.file_manager_list_download');
            Route::get('delete/{id}', 'file_manager_list_delete')->name('file_manager.file_manager_list_delete');
        });
    });
    
    Route::controller(App\Http\Controllers\DcController::class)->group(function () {
        Route::prefix('document_control')->group(function () {
            Route::prefix('category')->group(function () {
                Route::get('/', 'category')->name('dc.category');
                Route::post('simpan', 'category_store')->name('dc.category.store');
                Route::post('update', 'category_update')->name('dc.category.update');
                Route::get('{id}', 'category_detail')->name('dc.category.detail');
                Route::delete('{id}/delete', 'category_destroy')->name('dc.category.destroy');
            });
            Route::prefix('departemen')->group(function () {
                Route::get('/', 'departemen')->name('dc.departemen');
                Route::get('{id}', 'departemen_detail')->name('dc.departemen.departemen_detail');
                Route::post('{id}/simpan', 'departemen_detail_store')->name('dc.departemen.departemen_detail.store');
                Route::post('{id}/dc/upload-file-simpan', 'departemen_category_document_control_simpan')->name('dc.departemen.document_control.simpan');
                Route::get('{id}/{dc_category_id}', 'departemen_detail_category_detail')->name('dc.departemen.departemen_detail.category_detail');
                Route::delete('{id}/{dc_category_id}/delete', 'departemen_detail_category_detail_delete')->name('dc.departemen.departemen_detail.category_detail.delete');
            });
            Route::prefix('validasi')->group(function () {
                Route::get('/', 'dataValidasi')->name('dc.dataValidasi');
                Route::get('{id}', 'dataValidasiDetail')->name('dc.dataValidasi.detail');
                Route::get('{id}/verifikasi', 'dataValidasiVerifikasi')->name('dc.dataValidasi.verifikasi');
            });
        });
    });
    
    Route::controller(App\Http\Controllers\ListValidasiController::class)->group(function () {
        Route::prefix('document_control')->group(function () {
            Route::prefix('list_validasi')->group(function () {
                Route::get('/', 'indexValidasiDisetujui')->name('dc.listValidasi');
                Route::post('simpan', 'validasiDisetujuiSimpan')->name('dc.listValidasiDisetujui.simpan');
                Route::post('update', 'validasiDisetujuiUpdate')->name('dc.listValidasiDisetujui.update');
                Route::get('{id}', 'validasiDisetujuiDetail')->name('dc.listValidasiDisetujui.detail');
                Route::delete('{id}/delete', 'validasiDisetujuiDelete')->name('dc.listValidasiDisetujui.delete');
            });
            Route::prefix('list_validasi_diperiksa')->group(function () {
                Route::get('/', 'indexValidasiDiperiksa')->name('dc.listValidasiDiperiksa');
                Route::post('simpan', 'validasiDiperiksaSimpan')->name('dc.listValidasiDiperiksa.simpan');
                Route::post('update', 'validasiDiperiksaUpdate')->name('dc.listValidasiDiperiksa.update');
                Route::get('{id}', 'validasiDiperiksaDetail')->name('dc.listValidasiDiperiksa.detail');
                Route::delete('{id}/delete', 'validasiDiperiksaDelete')->name('dc.listValidasiDiperiksa.delete');
            });
            Route::prefix('list_validasi_dibuat')->group(function () {
                Route::get('/', 'indexValidasiDibuat')->name('dc.listValidasiDibuat');
                Route::post('simpan', 'validasiDibuatSimpan')->name('dc.listValidasiDibuat.simpan');
                Route::post('update', 'validasiDibuatUpdate')->name('dc.listValidasiDibuat.update');
                Route::get('{id}', 'validasiDibuatDetail')->name('dc.listValidasiDibuat.detail');
                Route::delete('{id}/delete', 'validasiDibuatDelete')->name('dc.listValidasiDibuat.delete');
            });
        });
    });
    
    Route::controller(App\Http\Controllers\PermissionController::class)->group(function () {
        Route::prefix('permission')->group(function () {
            Route::get('/', 'index')->name('permission');
            Route::post('simpan', 'simpan')->name('permission.simpan');
            Route::get('{id}', 'detail')->name('permission.detail');
            Route::post('update', 'update')->name('permission.update');
        });
    });
    
    Route::controller(App\Http\Controllers\DepartemenController::class)->group(function () {
        Route::prefix('departemen')->group(function () {
            Route::get('/', 'index')->name('departemen');
            Route::post('simpan', 'simpan')->name('departemen.simpan');
            Route::get('{id}', 'detail')->name('departemen.detail');
            Route::post('update', 'update')->name('departemen.update');
            Route::get('{id}/delete', 'delete')->name('departemen.delete');
            Route::get('{id}/team', 'detail_team')->name('departemen.detail_team');
            Route::get('{id}/{team_id}/team', 'detail_team_group')->name('departemen.detail_team_group');
            Route::post('{id}/team/simpan', 'team_simpan')->name('departemen.team_simpan');
            Route::post('{id}/team/update', 'detail_team_update')->name('departemen.detail_team_update');
            Route::post('{id}/team/pindah/update', 'detail_pindah_team_update')->name('departemen.detail_pindah_team_update');
            Route::post('search_nik', 'search_nik')->name('departemen.search_nik');
        });
    });
    
    Route::controller(App\Http\Controllers\ValidasiDocumentControlController::class)->group(function () {
        Route::prefix('validasi_document_control')->group(function () {
            Route::get('/', 'index')->name('validasiRepresentative');
            Route::prefix('representative')->group(function () {
                Route::get('/', 'validasiRepresentativeIndex')->name('validasiRepresentative.index');
                Route::post('simpan', 'validasiRepresentativeSimpan')->name('validasiRepresentative.simpan');
                Route::post('update', 'validasiRepresentativeUpdate')->name('validasiRepresentative.update');
                Route::get('{id}', 'validasiRepresentativeDetail')->name('validasiRepresentative.detail');
                Route::delete('{id}/delete', 'validasiRepresentativeDelete')->name('validasiRepresentative.delete');
            });
            Route::prefix('document_control')->group(function () {
                Route::get('/', 'validasiDocumentControlIndex')->name('validasiDocumentControl.index');
                Route::post('simpan', 'validasiDocumentControlSimpan')->name('validasiDocumentControl.simpan');
                Route::post('update', 'validasiDocumentControlUpdate')->name('validasiDocumentControl.update');
                Route::get('{id}', 'validasiDocumentControlDetail')->name('validasiDocumentControl.detail');
            });
        });
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

    // Route::prefix('kpi')->group(function () {
    //     Route::get('/', [App\Http\Controllers\KpiController::class, 'index'])->name('kpi');
    //     Route::get('create', [App\Http\Controllers\KpiController::class, 'buat_kpi'])->name('kpi.buat_kpi');
    //     Route::get('indikator', [App\Http\Controllers\KpiController::class, 'kpi_indikator'])->name('kpi.kpi_indikator');
    //     Route::get('indikator/team/{departemen_user_id}', [App\Http\Controllers\KpiController::class, 'kpi_indikator_buat'])->name('kpi.kpi_indikator_buat');
    //     Route::post('indikator/team/{departemen_user_id}/simpan', [App\Http\Controllers\KpiController::class, 'kpi_indikator_simpan'])->name('kpi.kpi_indikator_simpan');
    //     Route::get('indikator/team/{departemen_user_id}/{id}/edit', [App\Http\Controllers\KpiController::class, 'kpi_indikator_edit'])->name('kpi.kpi_indikator_edit');
    //     Route::post('indikator/team/{departemen_user_id}/{id}/edit', [App\Http\Controllers\KpiController::class, 'kpi_indikator_update'])->name('kpi.kpi_indikator_update');
    //     Route::get('indikator/team/{departemen_user_id}/{id}/delete', [App\Http\Controllers\KpiController::class, 'kpi_indikator_delete'])->name('kpi.kpi_indikator_delete');
        
    //     Route::prefix('departemen')->group(function () {
    //         Route::get('/', [App\Http\Controllers\KpiController::class, 'kpi_departemen'])->name('kpi.kpi_departemen');
    //         Route::get('{date}', [App\Http\Controllers\KpiController::class, 'input_date_kpi'])->name('kpi_date');
    //         Route::post('{date}/simpan', [App\Http\Controllers\KpiController::class, 'input_date_kpi_simpan'])->name('kpi.input_date_kpi_simpan');
    //         Route::get('{date}/departemen', [App\Http\Controllers\KpiController::class, 'input_detail_kpi_departemen'])->name('kpi.input_detail_kpi_departemen');
    //         Route::get('{date}/departemen/{id_departemen}/detail', [App\Http\Controllers\KpiController::class, 'input_date_kpi_detail'])->name('kpi.input_date_kpi_detail');
    //         Route::get('{date}/departemen/{id_departemen}/validasi', [App\Http\Controllers\KpiController::class, 'input_date_kpi_validasi'])->name('kpi.input_date_kpi_validasi');
    //         Route::post('{date}/departemen/{id_departemen}/validasi/simpan', [App\Http\Controllers\KpiController::class, 'input_date_kpi_validasi_simpan'])->name('kpi.input_date_kpi_validasi_simpan');
    //         Route::get('{date}/departemen/{id_departemen}/print', [App\Http\Controllers\KpiController::class, 'kpi_print'])->name('kpi.kpi_print');
    //         Route::get('{id}', [App\Http\Controllers\KpiController::class, 'kpi_departemen_detail'])->name('kpi.kpi_departemen_detail');
    //         Route::get('{kpi_departemen_id}/team', [App\Http\Controllers\KpiController::class, 'kpi_detail_team'])->name('kpi.kpi_detail_team');
    //         Route::post('simpan', [App\Http\Controllers\KpiController::class, 'kpi_departemen_detail_simpan'])->name('kpi.kpi_departemen_detail_simpan');
    //     });
    // });
    Route::prefix('kpi')->group(function () {
        Route::get('/', [App\Http\Controllers\KPIController::class, 'index'])->name('kpi');
        
        Route::get('indikator', [App\Http\Controllers\KPIController::class, 'kpi_indikator'])->name('kpi_indikator');
        Route::get('indikator/team/{departemen_user_id}', [App\Http\Controllers\KPIController::class, 'kpi_indikator_buat'])->name('kpi_indikator_buat');
        Route::post('indikator/team/{departemen_user_id}/simpan', [App\Http\Controllers\KPIController::class, 'kpi_indikator_simpan'])->name('kpi_indikator_simpan');
        Route::get('indikator/team/{departemen_user_id}/{id}/edit', [App\Http\Controllers\KPIController::class, 'kpi_indikator_edit'])->name('kpi_indikator_edit');
        Route::post('indikator/team/{departemen_user_id}/{id}/edit', [App\Http\Controllers\KPIController::class, 'kpi_indikator_update'])->name('kpi_indikator_update');
        Route::get('indikator/team/{departemen_user_id}/{id}/delete', [App\Http\Controllers\KPIController::class, 'kpi_indikator_delete'])->name('kpi_indikator_delete');
        
        // Route::get('{id}/{departemen_id}', [App\Http\Controllers\KPIController::class, 'detail_kpi'])->name('kpi_detail_kpi');
        Route::get('{id}/{departemen_id}/validasi', [App\Http\Controllers\KPIController::class, 'detail_validasi'])->name('kpi_detail_validasi');
        Route::post('{id}/{departemen_id}/validasi/simpan', [App\Http\Controllers\KPIController::class, 'validasi_simpan'])->name('kpi_validasi_simpan');
        Route::get('{id}/{departemen_id}/{date}/print', [App\Http\Controllers\KPIController::class, 'kpi_print'])->name('kpi_print');

        Route::get('{kpi_team_id}/{periode}', [App\Http\Controllers\KPIController::class, 'detail_kpi'])->name('kpi_detail_kpi');
        
        Route::prefix('departemen')->group(function () {
            Route::get('/', [App\Http\Controllers\KPIController::class, 'kpi_departemen'])->name('kpi.kpi_departemen');
            Route::post('simpan', [App\Http\Controllers\KPIController::class, 'kpi_departemen_detail_simpan'])->name('kpi.kpi_departemen_detail_simpan');
            Route::get('detail/{id}', [App\Http\Controllers\KPIController::class, 'kpi_departemen_detail'])->name('kpi.kpi_departemen_detail');
            Route::get('{kpi_departemen_id}/team', [App\Http\Controllers\KPIController::class, 'kpi_detail_team'])->name('kpi.kpi_detail_team');
            Route::post('team/update', [App\Http\Controllers\KPIController::class, 'kpi_detail_team_update'])->name('kpi.kpi_detail_team_update');
            Route::get('{departemen_id}/{date}', [App\Http\Controllers\KPIController::class, 'buat_kpi'])->name('kpi_buat_kpi');
            Route::post('{departemen_id}/{date}/simpan', [App\Http\Controllers\KPIController::class, 'input_date_kpi_simpan'])->name('kpi_input_date_kpi_simpan');
            Route::get('{departemen_id}/{date}/{team_id}', [App\Http\Controllers\KPIController::class, 'buat_kpi_team'])->name('kpi_buat_kpi_team');
        });

        Route::get('testing', [App\Http\Controllers\KPIController::class, 'kpi_testing']);

    });
    
    Route::prefix('kpi_culture')->group(function () {
        Route::get('/', [App\Http\Controllers\KpiController::class, 'kpi_culture'])->name('kpi.culture');
        Route::post('simpan', [App\Http\Controllers\KpiController::class, 'kpi_culture_simpan'])->name('kpi.culture.simpan');
        Route::post('kpi_verifikasi/{kpi_id}/update', [App\Http\Controllers\KpiController::class, 'kpi_culture_verifikasi_update'])->name('kpi.culture.verifikasi');
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
            Route::get('/', [App\Http\Controllers\HRGAController::class, 'index_biodata_karyawan_new'])->name('hrga.biodata_karyawan');
            Route::get('data_karyawan', [App\Http\Controllers\HRGAController::class, 'data_karyawan'])->name('hrga.data_karyawan');
            Route::get('search/{nik}', [App\Http\Controllers\HRGAController::class, 'get_search_data_karyawan'])->name('hrga.get_search_data_karyawan');
            Route::post('simpan', [App\Http\Controllers\HRGAController::class, 'simpan'])->name('hrga.biodata_karyawan.simpan');
            Route::post('update', [App\Http\Controllers\HRGAController::class, 'update'])->name('hrga.biodata_karyawan.update');
            Route::get('{nik}/detail', [App\Http\Controllers\HRGAController::class, 'detail'])->name('hrga.biodata_karyawan.detail');
            Route::get('{nik}/detail_kontrak_kerja', [App\Http\Controllers\HRGAController::class, 'detail_kontrak_kerja'])->name('hrga.biodata_karyawan.detail_kontrak_kerja');
            Route::get('{nik}/cetak', [App\Http\Controllers\HRGAController::class, 'cetak_data_karyawan'])->name('hrga.biodata_karyawan.cetak_data_karyawan');
            Route::post('kontrak_kerja/simpan', [App\Http\Controllers\HRGAController::class, 'kontrak_kerja_simpan'])->name('hrga.biodata_karyawan.kontrak_kerja_simpan');
            Route::post('riwayat_konseling/simpan', [App\Http\Controllers\HRGAController::class, 'riwayat_konseling_simpan'])->name('hrga.biodata_karyawan.riwayat_konseling_simpan');
            Route::get('download_rekap_excel/{tanggal}', [App\Http\Controllers\HRGAController::class, 'download_rekap_excel'])->name('hrga.biodata_karyawan.donwload_rekap_excel');
            Route::post('karyawan_resign/simpan', [App\Http\Controllers\HRGAController::class, 'resign_simpan'])->name('hrga.biodata_karyawan.resign_simpan');
            Route::get('{nama}/cek_rekap_training', [App\Http\Controllers\HRGAController::class, 'cek_riwayat_training_karyawan'])->name('hrga.biodata_karyawan.cek_riwayat_training_karyawan');
            Route::post('riwayat_training/simpan', [App\Http\Controllers\HRGAController::class, 'riwayat_training_simpan'])->name('hrga.biodata_karyawan.riwayat_training_simpan');
            
            Route::get('aktif', [App\Http\Controllers\HRGAController::class, 'index_biodata_karyawan_aktif'])->name('hrga.biodata_karyawan.aktif');
            Route::prefix('non_aktif')->group(function () {
                Route::get('/', [App\Http\Controllers\HRGAController::class, 'index_biodata_karyawan_non_aktif'])->name('hrga.biodata_karyawan.non_aktif');
                Route::post('update', [App\Http\Controllers\HRGAController::class, 'update_biodata_karyawan_non_aktif'])->name('hrga.biodata_karyawan.non_aktif.update');
                Route::get('{nik}/edit', [App\Http\Controllers\HRGAController::class, 'edit_biodata_karyawan_non_aktif'])->name('hrga.biodata_karyawan.non_aktif.edit');
            });

            Route::get('demografi', [App\Http\Controllers\HRGAController::class, 'demografi'])->name('hrga.biodata_karyawan.demografi');

            Route::get('buat_karyawan_baru', [App\Http\Controllers\HRGAController::class, 'buat_karyawan_baru'])->name('hrga.biodata_karyawan.buat_karyawan_baru');
            Route::post('buat_karyawan_baru/simpan', [App\Http\Controllers\HRGAController::class, 'buat_karyawan_baru_simpan'])->name('hrga.biodata_karyawan.buat_karyawan_baru.simpan');
            Route::post('get_departemen_bagian', [App\Http\Controllers\HRGAController::class, 'get_departemen_bagian'])->name('hrga.biodata_karyawan.get_departemen_bagian');
        });
        Route::prefix('rekap_pelatihan')->group(function () {
            Route::get('/', [App\Http\Controllers\HRGAController::class, 'rekap_pelatihan'])->name('hrga.rekap_pelatihan');
            Route::get('{id}/detail', [App\Http\Controllers\HRGAController::class, 'rekap_pelatihan_detail'])->name('hrga.rekap_pelatihan_detail');
            Route::post('simpan', [App\Http\Controllers\HRGAController::class, 'rekap_pelatihan_detail_simpan'])->name('hrga.rekap_pelatihan_detail_simpan');
        });
        Route::prefix('sertifikasi')->group(function () {
            Route::prefix('mesin_produksi')->group(function () {
                Route::get('/', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'index'])->name('hrga.sertifikasi.mesin_produksi');
                Route::get('create', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'create'])->name('hrga.sertifikasi.mesin_produksi.create');
                Route::post('simpan', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'simpan'])->name('hrga.sertifikasi.mesin_produksi.simpan');
                Route::post('update', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'update'])->name('hrga.sertifikasi.mesin_produksi.update');
                Route::get('download_pdf', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'download_pdf'])->name('hrga.sertifikasi.mesin_produksi.download_pdf');
                Route::get('{id}', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'detail'])->name('hrga.sertifikasi.mesin_produksi.detail');
                Route::get('{id}/delete', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'delete'])->name('hrga.sertifikasi.mesin_produksi.delete');
                
                Route::prefix('{id}/list')->group(function () {
                    Route::get('/', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'list_mesin'])->name('hrga.sertifikasi.mesin_produksi.list_mesin');
                    Route::post('simpan', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'list_simpan'])->name('hrga.sertifikasi.mesin_produksi.list_simpan');
                    Route::post('update', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'update_list'])->name('hrga.sertifikasi.mesin_produksi.update_list');
                    Route::get('{mesin_list_id}', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'detail_list'])->name('hrga.sertifikasi.mesin_produksi.detail_list');
                    Route::get('{mesin_list_id}/delete', [App\Http\Controllers\SertifikasiMesinProduksiController::class, 'delete_list'])->name('hrga.sertifikasi.mesin_produksi.delete_list');
                });

            });
        });
    });

    Route::prefix('qhse')->group(function () {
        Route::prefix('ibprpp')->group(function () {
            Route::prefix('kategori')->group(function () {
                Route::prefix('periode')->group(function () {
                });
            });
            Route::get('/',[App\Http\Controllers\IBPRPPController::class,'ibprpp_periode'])->name('qhse.ibprpp.periode');
            Route::get('{periode}',[App\Http\Controllers\IBPRPPController::class,'ibprpp_index'])->name('qhse.ibprpp.index');
            Route::get('{periode}/{departemen_id}/preview',[App\Http\Controllers\IBPRPPController::class,'ibprpp_departemen_input_preview'])->name('qhse.ibprpp.departemen_preview');
            Route::get('{periode}/{departemen_id}/pdf',[App\Http\Controllers\IBPRPPController::class,'ibprpp_departemen_download_pdf'])->name('qhse.ibprpp.departemen_download_pdf');
            Route::get('{periode}/{departemen_id}/table-matriks',[App\Http\Controllers\IBPRPPController::class,'ibprpp_departemen_download_table_matriks'])->name('qhse.ibprpp.departemen_download_table_matriks');
            Route::get('{periode}/{departemen_id}/input',[App\Http\Controllers\IBPRPPController::class,'ibprpp_departemen_input'])->name('qhse.ibprpp.departemen_input');
            Route::post('{periode}/{departemen_id}/simpan',[App\Http\Controllers\IBPRPPController::class,'ibprpp_departemen_input_simpan'])->name('qhse.ibprpp.departemen_simpan');
        });
    });

    Route::prefix('mesin_finger')->group(function () {
        Route::prefix('device')->group(function () {
            Route::get('/',[App\Http\Controllers\FinProController::class,'device'])->name('fin_pro.device');
            Route::get('get_device',[App\Http\Controllers\FinProController::class,'get_device'])->name('fin_pro.get_device');
            Route::post('simpan',[App\Http\Controllers\FinProController::class,'device_simpan'])->name('fin_pro.device_simpan');
            Route::post('update',[App\Http\Controllers\FinProController::class,'device_update'])->name('fin_pro.device_update');
            Route::get('{dev_id}',[App\Http\Controllers\FinProController::class,'device_detail'])->name('fin_pro.device_detail');
        });
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
        Route::post('update_personal_info', [App\Http\Controllers\ProfileController::class, 'personal_info_update'])->name('profile.personal_info');
        Route::post('update_password', [App\Http\Controllers\ProfileController::class, 'password_personal_update'])->name('profile.password_personal_update');
    });
    
    Route::prefix('fcm-token')->group(function () {
        Route::patch('/', [App\Http\Controllers\UserController::class, 'updateToken'])->name('fcmToken');
    });

    Route::get('get_token', function(Request $request){
        $token = auth()->user()->createToken('myAppToken')->plainTextToken;
        return $token;
        // return auth()->user()->update(['fcm_token'=>request()->token]);
    });
    Route::post('/send-notification',[App\Http\Controllers\UserController::class,'notification'])->name('notification');

    Route::get('test', function(){
        // $data = \DB::table('fin_pro.att_log')
        //             ->addSelect(\DB::raw(
        //                 "
        //                 DATE(scan_date) AS tanggal,
        //                 pin as pin,
        //                 MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk
        //                 "
        //             ))
        //             ->addSelect(\DB::raw(
        //                 "
        //                 DATE(scan_date) AS tanggal,
        //                 pin as pin,
        //                 MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang
        //                 "
        //             ))
        //             ->where('scan_date','LIKE','%2025-08-01%')
        //             ->where('pin','1298')
        //             ->groupBy(\DB::raw('DATE(scan_date)'),'pin')
        //             ->orderBy('scan_date', 'asc')
        //             ->first();

        $data = \DB::table('fin_pro.att_log')
                    ->select(
                        \DB::raw('DATE(scan_date) AS tanggal'),
                        'pin',
                        \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') <= '11:59:59' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_masuk"),
                        \DB::raw("MAX(CASE WHEN DATE_FORMAT(scan_date,'%H:%i') >= '12:00:00' THEN DATE_FORMAT(scan_date,'%H:%i') ELSE NULL END) AS jam_pulang")
                    )
                    ->where('pin', 1298)
                    // Menggunakan whereDate() adalah cara yang lebih baik dan aman daripada LIKE untuk memfilter tanggal
                    ->whereDate('scan_date', '2025-08-01')
                    ->groupBy(\DB::raw('DATE(scan_date)'), 'pin')
                    ->orderBy(\DB::raw('DATE(scan_date)'))
                    ->first();

        // $data = \DB::select(\DB::raw(
        //     '
        //     SELECT
        //         DATE(scan_date) AS tanggal,
        //         pin AS pin,
        //         MAX(CASE WHEN DATE_FORMAT(scan_date,"%H:%i") <= "11:59:59" THEN DATE_FORMAT(scan_date,"%H:%i") ELSE NULL END) AS jam_masuk,
        //         MAX(CASE WHEN DATE_FORMAT(scan_date,"%H:%i") >= "12:00:00" THEN DATE_FORMAT(scan_date,"%H:%i") ELSE NULL END) AS jam_pulang
        //     FROM `fin_pro`.`att_log`
        //     WHERE `scan_date` LIKE "2025-08-01%" AND `pin` = 1298
        //     GROUP BY pin
        //     ORDER BY `scan_date` ASC
        //     LIMIT 1
        //     '
        // ));

        return $data;
    });
    // Route::get('testing', [App\Http\Controllers\TestingController::class, 'testing2'])->name('testing_pdf');
    Route::get('testing-telegram', [App\Http\Controllers\TestingController::class, 'testingNotificationTelegram']);

});