<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailKpiCultureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_detail_culture', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kpi_id')->unsigned();
            $table->string('culture')->nullable();
            $table->text('indikator')->nullable();
            $table->string('skala',10)->nullable();
            $table->string('bobot',10)->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('kpi_detail_culture');
    }
}
