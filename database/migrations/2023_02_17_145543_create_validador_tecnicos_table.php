<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidadorTecnicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validador_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->boolean('aceptada');
            $table->date('fecha_revision');
            $table->text('comentario');
            $table->unsignedInteger('producto_id');
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('proveedores_fichas_productos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validador_tecnicos');
    }
}
