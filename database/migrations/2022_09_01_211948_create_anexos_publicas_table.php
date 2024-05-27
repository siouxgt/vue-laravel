<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosPublicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos_publicas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->string('archivo_original',150);
            $table->string('archivo_publica',150);
            $table->unsignedInteger('licitacion_publica_id');
            $table->timestamps();

            $table->foreign('licitacion_publica_id')->references('id')->on('licitacion_publicas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anexos_publicas');
    }
}
