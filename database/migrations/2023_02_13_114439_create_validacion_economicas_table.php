<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidacionEconomicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validacion_economicas', function (Blueprint $table) {
            $table->id();
            $table->double('precio', 15, 2);
            $table->unsignedInteger('producto_id');
            $table->integer('intento');
            $table->boolean('validado');
            $table->timestamps();

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
        Schema::dropIfExists('validacion_economicas');
    }
}
