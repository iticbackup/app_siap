<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrgaStatusKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrga_status_kerja', function (Blueprint $table) {
            // $table->id();
            $table->bigInteger('id')->primary();
            $table->bigInteger('hrga_biodata_karyawan_id');
            $table->string('pk',100);
            $table->string('ke',10);
            $table->date('tgl_mulai');
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
        Schema::dropIfExists('hrga_status_kerja');
    }
}
