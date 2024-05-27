<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelarComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancelar_compras', function (Blueprint $table) {
            $table->id();
            $table->string('cancelacion',20);
            $table->string('motivo',50);
            $table->text('descripcion');
            $table->string('seccion',20);
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('usuario_id');
            $table->unsignedInteger('proveedor_id');
            $table->timestamps();

            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('cancelar_compras');
    }
}
