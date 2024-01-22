<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiTotalNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_total_nilai', function (Blueprint $table) {
            $table->id();
            $table->integer('kpi_id')->nullable();
            $table->string('nama_kpi')->nullable();
            $table->string('bobot')->nullable();
            $table->string('nilai')->nullable();
            $table->string('total_nilai')->nullable();
            $table->string('skor_nilai')->nullable();
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
        Schema::dropIfExists('kpi_total_nilai');
    }
}
