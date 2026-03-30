<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiDokumentasiSertifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_dokumentasi_sertifikasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('sertifikasi_mesin_id');
            $table->string('nama_dokumen');
            $table->text('files');
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
        Schema::dropIfExists('produksi_dokumentasi_sertifikasi');
    }
}
