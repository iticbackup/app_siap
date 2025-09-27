<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcListValidasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_list_validasi_disetujui', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->bigInteger('departemen_id');
            $table->enum('status',['Active','InActive']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dc_list_validasi_diperiksa', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->bigInteger('departemen_id');
            $table->enum('status',['Active','InActive']);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dc_list_validasi_dibuat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->bigInteger('departemen_id');
            $table->enum('status',['Active','InActive']);
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
        Schema::dropIfExists('dc_list_validasi_disetujui');
        Schema::dropIfExists('dc_list_validasi_diperiksa');
        Schema::dropIfExists('dc_list_validasi_dibuat');
    }
}
