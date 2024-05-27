<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabilitarProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilitar_proveedores', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_adhesion')->nullable();
            $table->string('archivo_adhesion',150)->nullable();
            $table->boolean('habilitado')->nullable();
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('expediente_id');
            $table->unsignedInteger('contrato_id');
            $table->timestamps();

            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('expediente_id')->references('id')->on('expedientes_contratos_marcos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('contrato_id')->references('id')->on('contratos_marcos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habilitar_proveedores');
    }
}
