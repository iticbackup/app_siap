<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidasiPerubahanDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validasi_representative', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik');
            $table->string('nama_validasi');
            $table->enum('status',['Y','N'])->default('Y');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('validasi_document_control', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik');
            $table->string('nama_validasi');
            $table->enum('status',['Y','N'])->default('Y');
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
        Schema::dropIfExists('validasi_representative');
        Schema::dropIfExists('validasi_document_control');
    }
}
