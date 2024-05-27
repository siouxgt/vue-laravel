<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosRestringidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos_restringidas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->string('archivo_original',150);
            $table->string('archivo_publica',150);
            $table->unsignedInteger('invitacion_restringida_id');
            $table->timestamps();
            
            $table->foreign('invitacion_restringida_id')->references('id')->on('invitacion_restringidas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anexos_restringidas');
    }
}
