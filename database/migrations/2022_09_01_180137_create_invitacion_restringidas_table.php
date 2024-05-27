<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitacionRestringidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitacion_restringidas', function (Blueprint $table) {
            $table->id();
            $table->string('articulo',20);
            $table->string('fraccion',50)->nullable();
            $table->date('fecha_sesion')->nullable();
            $table->integer('numero_sesion')->nullable();
            $table->integer('numero_cotizacion');
            $table->integer('numero_proveedores_invitados')->default(0)->nullable();
            $table->json('proveedores_invitados')->nullable();
            $table->string('archivo_aprobacion_original',150)->nullable();
            $table->string('archivo_aprobacion_publica',150)->nullable();
            $table->integer('numero_proveedores_participaron')->default(0)->nullable();
            $table->json('proveedores_participaron')->nullable();
            $table->string('archivo_aclaracion_original',150)->nullable();
            $table->string('archivo_aclaracion_publica',150)->nullable();
            $table->integer('numero_proveedores_propuesta')->default(0)->nullable();
            $table->json('proveedores_propuesta')->nullable();
            $table->integer('numero_proveedores_descalificados')->default(0)->nullable();
            $table->json('proveedores_descalificados')->nullable();
            $table->string('archivo_presentacion_original',150)->nullable();
            $table->string('archivo_presentacion_publico',150)->nullable();
            $table->integer('numero_proveedores_aprobados')->default(0)->nullable();
            $table->json('proveedores_aprobados')->nullable();
            $table->integer('numero_proveedores_adjudicados')->default(0)->nullable();
            $table->json('proveedores_adjudicados')->nullable();
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
        Schema::dropIfExists('invitacion_restringidas');
    }
}
