<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraEvaluacionProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_evaluacion_productos', function (Blueprint $table) {
            $table->id();
            $table->integer('calificacion')->nullable();
            $table->text('comentario')->nullable();
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('producto_id');
            $table->timestamps();

            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('orden_compra_evaluacion_productos');
    }
}
