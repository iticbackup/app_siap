<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartemenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departemen', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('departemen');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('departemen_user', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->bigInteger('departemen_id')->unsigned();
            $table->string('staff',4);
            $table->string('nik');
            $table->string('team');
            // $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('departemen_id')->references('id')->on('departemen'); 
            // $table->foreign('user_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departemen');
        Schema::dropIfExists('departemen_user');
    }
}
