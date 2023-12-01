<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrgaBiodataKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrga_biodata_karyawan', function (Blueprint $table) {
            // $table->id();
            $table->bigInteger('id')->primary();
            $table->string('no_urut_level',100)->nullable();
            $table->string('no_urut_departemen',100)->nullable();
            $table->string('nik',100)->nullable();
            $table->string('no_npwp')->nullable();
            $table->string('no_telepon',100)->nullable();
            $table->string('no_bpjs_ketenagakerjaan',100)->nullable();
            $table->string('no_bpjs_kesehatan',100)->nullable();
            $table->string('no_rekening_mandiri',100)->nullable();
            $table->string('no_rekening_bws',100)->nullable();
            $table->string('departemen_dept',100)->nullable();
            $table->string('departemen_bagian',100)->nullable();
            // $table->string('departemen_jml',100)->nullable();
            $table->string('departemen_level',100)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('status_keluarga')->nullable();
            $table->string('golongan_darah',2)->nullable();
            $table->string('pendidikan',10)->nullable();
            $table->string('email')->nullable();
            $table->string('kunci_loker')->nullable();
            $table->string('foto_karyawan')->nullable();
            $table->string('status_karyawan',100)->nullable();
            // $table->string('status_kerja_pk',100)->nullable();
            // $table->date('status_kerja_tgl_mulai')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Schema::create('hrga_status_kerja', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('hrga_biodata_karyawan_id');
        //     $table->string('pk',100);
        //     $table->string('ke',10);
        //     $table->date('tgl_mulai');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('hrga_riwayat_training', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('hrga_biodata_karyawan_id');
        //     $table->string('riwayat_training');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('hrga_riwayat_konseling_karyawan', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('hrga_biodata_karyawan_id');
        //     $table->string('riwayat_konseling');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrga_biodata_karyawan');
        // Schema::dropIfExists('hrga_status_kerja');
        // Schema::dropIfExists('hrga_riwayat_training');
        // Schema::dropIfExists('hrga_riwayat_konseling_karyawan');
    }
}
