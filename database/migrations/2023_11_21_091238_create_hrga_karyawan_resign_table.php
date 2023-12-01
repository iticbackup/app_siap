<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrgaKaryawanResignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrga_karyawan_resign', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->bigInteger('hrga_biodata_karyawan_id');
            $table->date('tanggal_resign');
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
        Schema::dropIfExists('hrga_karyawan_resign');
    }
}
