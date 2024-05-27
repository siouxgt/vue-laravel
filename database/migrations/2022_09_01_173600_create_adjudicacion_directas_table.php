<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjudicacionDirectasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjudicacion_directas', function (Blueprint $table) {
            $table->id();
            $table->string('articulo',20);
            $table->string('fraccion',50)->nullable();
            $table->date('fecha_sesion')->nullable();
            $table->integer('numero_sesion')->nullable();
            $table->integer('numero_cotizacion')->nullable();
            $table->string('archivo_aprobacion_original',150)->nullable();
            $table->string('archivo_aprobacion_publica',150)->nullable();
            $table->integer('numero_proveedores_adjudicado')->default(0)->nullable();
            $table->json('proveedores_adjudicado')->nullable();
            $table->unsignedInteger('expediente_id');
            $table->timestamps();

            $table->foreign('expediente_id')->references('id')->on('expedientes_contratos_marcos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjudicacion_directas');
    }
}
