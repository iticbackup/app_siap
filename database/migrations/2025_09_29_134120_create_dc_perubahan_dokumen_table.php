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
            $table->text('dc_disetujui')->nullable();
            $table->text('dc_diperiksa')->nullable();
            $table->text('dc_dibuat')->nullable();
            $table->text('dc_document_control')->nullable();
            $table->string('is_open',2);
            $table->string('status',100);
            $table->text('remaks')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dc_perubahan_dokumen_list', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('dc_perubahan_dokumen_id');
            $table->string('no_dokumen');
            $table->string('halaman');
            $table->string('revisi',2);
            $table->text('uraian_perubahan');
            $table->text('files');
            $table->text('validasi')->nullable();
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
        Schema::dropIfExists('dc_perubahan_dokumen_list');
    }
}
