<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_manager_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('departemen_id')->unsigned();
            $table->string('kategori');
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('departemen_id')->references('id')->on('departemen'); 
        });
        Schema::create('file_manager_list', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('file_manager_category_id')->unsigned();
            $table->string('no_dokumen');
            $table->string('title');
            $table->string('files');
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('file_manager_category_id')->references('id')->on('file_manager_category'); 
        });
        Schema::create('file_manager_perubahan_data', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('departemen_id')->unsigned();
            $table->string('kode_formulir');
            $table->date('tanggal_formulir');
            $table->string('disetujui_signature');
            $table->string('pengajuan_signature');
            $table->string('represtative_signature');
            $table->string('is_open',2);
            $table->string('status',100);
            $table->text('remaks');
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('file_manager_category_id')->references('id')->on('file_manager_category'); 
        });
        Schema::create('file_manager_perubahan_data_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('file_manager_perubahan_data_id');
            $table->string('no_dokumen');
            $table->string('halaman');
            $table->string('revisi',2);
            $table->text('uraian_perubahan');
            $table->string('files');
            $table->string('validasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('file_manager_category_id')->references('id')->on('file_manager_category'); 
        });
        // Schema::create('file_manager_list_detail', function (Blueprint $table) {
        //     $table->id();
        //     $table->bigInteger('file_manager_list_id')->unsigned();
        //     $table->string('title');
        //     $table->string('files');
        //     $table->timestamps();
        //     $table->softDeletes();
        //     // $table->foreign('file_manager_list_id')->references('id')->on('file_manager_list');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_manager_category');
        Schema::dropIfExists('file_manager_list');
        Schema::dropIfExists('file_manager_perubahan_data');
        Schema::dropIfExists('file_manager_perubahan_data_detail');
        // Schema::dropIfExists('file_manager_list_detail');
    }
}
