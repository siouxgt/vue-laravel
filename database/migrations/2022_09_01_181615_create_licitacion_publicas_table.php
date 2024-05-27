<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicitacionPublicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitacion_publicas', function (Blueprint $table) {
            $table->id();
            $table->boolean('tiangis');
            $table->string('tipo_licitacion',50);
            $table->string('tipo_contratacion',50);
            $table->date('fecha_convocatoria');
            $table->integer('numero_proveedores_base')->default(0)->nullable();
            $table->json('proveedores_base')->nullable();
            $table->string('archivo_base_licitacion',150)->nullable();
            $table->date('fecha_aclaracion')->nullable();
            $table->string('archivo_acta_declaracion_original',150)->nullable();
            $table->string('archivo_acta_declaracion_publico',150)->nullable();
            $table->date('fecha_propuesta')->nullable();
            $table->integer('numero_proveedores_propuesta')->default(0)->nullable();
            $table->json('proveedores_propuesta')->nullable();
            $table->integer('numero_proveedores_descalificados')->default(0)->nullable();
            $table->json('proveedores_descalificados')->nullable();
            $table->string('archivo_acta_presentacion_original',150)->nullable();
            $table->string('archivo_acta_presentacion_publico',150)->nullable();
            $table->date('fecha_fallo')->nullable();
            $table->integer('numero_proveedores_aprobados')->default(0)->nullable();
            $table->json('proveedores_aprobados')->nullable();
            $table->integer('numero_proveedores_adjudicados')->default(0)->nullable();
            $table->json('proveedores_adjudicados')->nullable();
            $table->string('archivo_acta_fallo_original',150)->nullable();
            $table->string('archivo_acta_fallo_publica',150)->nullable();
            $table->string('archivo_oficio_adjudicacion_original',150)->nullable();
            $table->string('archivo_oficio_adjudicacion_publico',150)->nullable();
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
        Schema::dropIfExists('licitacion_publicas');
    }
}
