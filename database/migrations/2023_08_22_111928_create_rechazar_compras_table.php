<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRechazarComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rechazar_compras', function (Blueprint $table) {
            $table->id();
            $table->string('rechazo',20);//Id de la compra rechazada en formato alfanumerico
            $table->string('motivo',50);
            $table->text('descripcion');
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('orden_compra_id');
            $table->timestamps();

            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rechazar_compras');
    }
}
