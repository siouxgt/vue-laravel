<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabilitarProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilitar_productos', function (Blueprint $table) {
            $table->id();
            $table->double('precio_maximo', 15, 2)->nullable();
            $table->date('fecha_estudio')->nullable();
            $table->string('archivo_estudio_original',150)->nullable();
            $table->string('archivo_estudio_publico',150)->nullable();
            $table->date('fecha_formulario')->nullable();
            $table->date('fecha_carga')->nullable();
            $table->date('fecha_administrativa')->nullable();
            $table->date('fecha_tecnica')->nullable();
            $table->date('fecha_publicacion')->nullable();
            $table->unsignedInteger('cat_producto_id');
            $table->unsignedInteger('grupo_revisor_id')->nullable();
            $table->timestamps();

            $table->foreign('cat_producto_id')->references('id')->on('cat_productos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('grupo_revisor_id')->references('id')->on('grupo_revisors')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habilitar_productos');
    }
}
