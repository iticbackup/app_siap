<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIbprppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ibprpp', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('ibprpp_periode_id');
            $table->integer('ibprpp_category_area_id');
            $table->integer('ibprpp_departemen_id');
            // $table->integer('departemen_id');
            $table->string('aktivitas_pekerja');
            $table->string('jenis_aktivitas');
            $table->longText('body');
            // $table->longText('penilaian_risiko_pengendalian');
            // $table->longText('potensi_bahaya');
            // $table->longText('risiko_bahaya');
            // $table->longText('penilaian_risiko');
            // $table->string('nilai_risiko',10);
            // $table->string('penetapan_pengendali',10);
            // $table->longText('pengendalian');
            // $table->string('pic_wewenang');
            // $table->text('regulasi_terkait');
            $table->string('status',100);
            $table->timestamps();
            $table->softDeletes();
        });
        
        // Schema::create('ibprpp_', function (Blueprint $table) {
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ibprpp');
    }
}
