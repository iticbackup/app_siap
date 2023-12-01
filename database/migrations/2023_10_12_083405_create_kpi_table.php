<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi', function (Blueprint $table) {
            $table->id();
            // $table->string('nik',100);
            // $table->bigInteger('departemen_user_id')->unsigned();
            // $table->bigInteger('kpi_departemen_id')->unsigned();
            // $table->string('jabatan',100);
            // $table->bigInteger('id')->primary();
            $table->bigInteger('kpi_team_id')->unsigned();
            $table->string('periode');
            $table->string('nilai')->nullable();
            $table->string('status_nilai')->nullable();
            $table->string('mengetahui')->nullable();
            $table->string('penilai')->nullable();
            $table->string('yang_dinilai')->nullable();
            $table->string('status_mengetahui')->nullable();
            $table->string('status_penilai')->nullable();
            $table->text('remaks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('kpi_detail', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('id')->primary();
            $table->bigInteger('kpi_id')->unsigned();
            $table->text('indikator')->nullable();
            $table->string('target_nilai')->nullable();
            $table->text('target_keterangan')->nullable();
            $table->string('realisasi_nilai')->nullable();
            $table->text('realisasi_keterangan')->nullable();
            $table->string('pencapaian',10)->nullable();
            $table->string('bobot',10)->nullable();
            $table->string('nilai',2)->nullable();
            $table->string('skor',4)->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('kpi');
        Schema::dropIfExists('kpi_detail');
    }
}
