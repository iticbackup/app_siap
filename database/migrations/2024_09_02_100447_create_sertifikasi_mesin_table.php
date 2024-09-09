<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikasiMesinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikasi_mesin', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_mesin');
            $table->text('no_sertifikat');
            $table->date('tgl_sertifikat_pertama');
            $table->integer('periode_resertifikasi');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('sertifikasi_mesin_list', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sertifikasi_mesin_id');
            $table->date('tgl_periksa_uji');
            $table->date('tgl_terbit_sertifikat');
            $table->text('no_sertifikat_terakhir');
            $table->text('tgl_resertifikat_terakhir');
            $table->text('keterangan');
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
        Schema::dropIfExists('sertifikasi_mesin');
        Schema::dropIfExists('sertifikasi_mesin_list');
    }
}
