<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc', function (Blueprint $table) {
            $table->uuid('id')->primary();
            // $table->bigInteger('departemen_id')->unsigned();
            // $table->uuid('dc_category_id');
            $table->uuid('dc_category_departemen_id');
            $table->string('dc_code');
            $table->string('dc_title');
            $table->date('dc_tanggal_terbit');
            $table->string('dc_nomor_dokumen');
            $table->string('dc_nomor_revisi');
            $table->text('dc_disetujui')->nullable();
            $table->text('dc_diperiksa')->nullable();
            $table->text('dc_dibuat')->nullable();
            $table->text('dc_files');
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
        Schema::dropIfExists('dc');
    }
}
