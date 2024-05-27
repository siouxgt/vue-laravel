<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_biens', function (Blueprint $table) {
            $table->id();
            $table->string('cabms',20);
            $table->string('nombre',200);
            $table->integer('cantidad');
            $table->float('precio', 3, 2);
            $table->string('medida',30);
            $table->string('color',30);
            $table->string('tamanio',100);
            $table->integer('estatus')->nullable();  //aceptado 1 rechazado 2 sustituido 3 cancelado 4
            $table->unsignedInteger('proveedor_ficha_producto_id');
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('requisicion_id');
            $table->timestamps();

            $table->foreign('proveedor_ficha_producto_id')->references('id')->on('proveedores_fichas_productos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('requisicion_id')->references('id')->on('requisiciones')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compra_biens');
    }
}
