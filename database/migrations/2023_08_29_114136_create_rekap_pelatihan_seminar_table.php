<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapPelatihanSeminarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_pelatihan_seminar', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('tanggal');
            $table->string('tema');
            $table->string('penyelenggara');
            $table->string('jenis');
            $table->integer('jml_hari');
            $table->integer('jml_jam_dlm_hari');
            $table->integer('total_peserta');
            $table->string('periode',4);
            // $table->text('peserta');
            $table->text('keterangan')->nullable();
            $table->string('status');
            $table->string('file_sertifikat')->nullable();
            $table->string('file_absensi')->nullable();
            $table->text('link')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rekap_pelatihan_seminar_peserta', function (Blueprint $table) {
            $table->id();
            $table->integer('rekap_pelatihan_seminar_id')->unsigned();
            $table->text('peserta');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekap_pelatihan_seminar');
        Schema::dropIfExists('rekap_pelatihan_seminar_peserta');
    }
}
