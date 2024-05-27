<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidacionesTecnicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validaciones_tecnicas', function (Blueprint $table) {
            $table->id();
            $table->string('direccion', 200)->nullable();
            $table->string('siglas', 10)->nullable();
            // $table->json('responsable');//status(boolean = seleccionado), Nombre, cargo, permiso
            $table->boolean('estatus')->default(1);
            $table->unsignedInteger('urg_id');
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
        Schema::dropIfExists('validaciones_tecnicas');
    }
}
