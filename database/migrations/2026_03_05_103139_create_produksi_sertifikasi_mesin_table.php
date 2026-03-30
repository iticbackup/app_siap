<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiSertifikasiMesinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_sertifikasi_mesin', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mesin_id');
            $table->uuid('jenis_sertifikasi_id');
            $table->date('tanggal_inspeksi');
            $table->date('tanggal_terbit');
            $table->date('tanggal_kedaluwarsa');
            $table->enum('status_sertifikasi',['Berlaku','Kedaluwarsa','Gagal Uji','Proses'])->default('Proses');
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('produksi_sertifikasi_mesin');
    }
}
