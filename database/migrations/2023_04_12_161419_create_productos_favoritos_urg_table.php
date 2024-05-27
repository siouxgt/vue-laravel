<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosFavoritosUrgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_favoritos_urg', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proveedor_ficha_producto_id');
            $table->unsignedBigInteger('urg_id');
            $table->foreign('proveedor_ficha_producto_id')->references('id')->on('proveedores_fichas_productos')->onDelete('set null');
            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();//Campo para eliminar de manera virtual/logica
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_favoritos_urg');
    }
}
