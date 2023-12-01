<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiBobotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_bobot', function (Blueprint $table) {
            $table->id();
            $table->string('bobot_huruf',2);
            $table->string('bobot_nilai',2);
            $table->string('keterangan',100);
            $table->string('skala',100);
            $table->string('prosentase',100);
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
        Schema::dropIfExists('kpi_bobot');
    }
}
