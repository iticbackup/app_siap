<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrgaRiwayatKonselingKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrga_riwayat_konseling_karyawan', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('hrga_biodata_karyawan_id');
            $table->string('riwayat_konseling');
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
        Schema::dropIfExists('hrga_riwayat_konseling_karyawan');
    }
}
