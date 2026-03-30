<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksiMesinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_mesin', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_mesin')->unique();
            $table->string('nama_mesin');
            $table->uuid('kategori_id');
            $table->uuid('lokasi_id');
            $table->string('merk');
            $table->year('tahun_pembuatan');
            $table->enum('status_mesin',['Aktif','Rusak','Maintenance','NonAktif']);
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
        Schema::dropIfExists('produksi_mesin');
    }
}
