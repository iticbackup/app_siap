<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiJenisSertifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_jenis_sertifikasi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_sertifikasi');
            $table->string('standar_acuan');
            $table->integer('masa_berlaku_bln');
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
        Schema::dropIfExists('produksi_jenis_sertifikasi');
    }
}
