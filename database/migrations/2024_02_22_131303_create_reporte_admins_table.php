<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporteAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_admins', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_reporte',150);
            $table->integer('reporte');
            $table->json('parametros');
            $table->unsignedInteger('urg_id'); //urg que lo solicito 
            $table->timestamps();

            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reporte_admins');
    }
}
