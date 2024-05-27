<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraProrrogasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_prorrogas', function (Blueprint $table) {
            $table->id();
            $table->string('id_prorroga',50);
            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_entrega_compromiso');
            $table->integer('dias_solicitados'); //dias solicitados para hacer la entrega
            $table->text('descripcion'); //Descripcion o motivo del porque pide la prorroga
            $table->string('justificacion', 100)->nullable(); // documento o ruta donde se guardara el archivo para justificar la prorroga
            $table->string('solicitud', 100); //archivo de la solicitud (el documento de la prorroga)
            $table->integer('estatus')->nullable(); //null = En proceso (haciendo la prorroga), 0 = En espera de que acepte o rechace la URG, 1 = aceptada, 2 = rechazada, 3= cancelada
            $table->dateTime('fecha_aceptacion')->nullable(); //Fecha en la que la URG acepta, rechaza o cancela prorroga
            $table->string('acuse', 150)->nullable(); //Documento subido por la URG
            $table->string('motivo_urg', 50)->nullable();
            $table->text('descripcion_urg')->nullable();
            $table->string('unidad_administrativa', 200)->nullable();
            $table->string('nombre_firma', 250)->nullable();
            $table->string('cargo_firma', 200)->nullable();
            $table->string('correo_firma', 200)->nullable();
            $table->string('num_contrato_pedido', 30)->nullable();
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('urg_id');
            $table->timestamps();

            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compra_prorrogas');
    }
}
