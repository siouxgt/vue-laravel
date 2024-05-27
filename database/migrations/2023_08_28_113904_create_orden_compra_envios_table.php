<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_envios', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_envio')->nullable(); //Fecha en que el proveedor está enviando el producto
            $table->text('comentarios')->nullable(); //Comentarios que hace el proveedor sobre el envio del producto
            $table->dateTime('fecha_entrega_almacen')->nullable(); //Fecha en la que se esta entregando el producto en el almacen
            $table->string('nota_remision', 150)->nullable(); //guarda la ruta de la nota de remisión
            $table->dateTime('fecha_entrega_aceptada')->nullable(); // La fecha puede referirse a una fecha de rechazo (rechazo de productos para sustitucion)
            $table->boolean('estatus')->nullable(); //estatus del envio, si fue aceptado completamente (true) o rechazado para sustitucion (false) por la URG
            $table->integer('penalizacion')->default(0); //Guarda el número de días para generar penalización
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('urg_id');
            $table->timestamps();

            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('orden_compra_envios');
    }
}
