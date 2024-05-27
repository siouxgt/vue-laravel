<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosPreguntasRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_preguntas_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedor_ficha_producto_id');
            $table->unsignedBigInteger('urg_id');
            $table->string('tema_pregunta', 100)->nullable();
            $table->text('pregunta')->nullable();
            $table->text('respuesta')->nullable();
            $table->boolean('estatus')->default(false);
            //-------------------------------------------------------------------------
            $table->foreign('proveedor_ficha_producto_id')->references('id')->on('proveedores_fichas_productos')->onDelete('set null');
            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_preguntas_respuestas');
    }
}
