<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcPerubahanDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_perubahan_dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('dc_category_id');
            $table->bigInteger('departemen_id')->unsigned();
            $table->string('kode_formulir');
            $table->date('tanggal_formulir');
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
        Schema::dropIfExists('dc_perubahan_dokumen');
    }
}
