<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritosComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carritos_compras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisicion_id');
            $table->unsignedBigInteger('proveedor_ficha_producto_id');
            $table->integer('cantidad_producto')->default(0);
            $table->string('color', 100);
            $table->integer('comprado')->default(0); //Guarda el estado del producto (Define si ya se compro o no el producto) 0 = No comprado, 1 = Ya ha sido comprado
            $table->timestamps();
            
            $table->foreign('requisicion_id')->references('id')->on('requisiciones')->onDelete('set null');
            $table->foreign('proveedor_ficha_producto_id')->references('id')->on('proveedores_fichas_productos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carritos_compras');
    }
}
