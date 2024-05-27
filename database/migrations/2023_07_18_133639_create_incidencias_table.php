<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('id_incidencia',50);
            $table->string('motivo',200);
            $table->text('descripcion');
            $table->dateTime('fecha_respuesta')->nullable();
            $table->string('etapa', 50); //nombre de la etapa
            $table->string('etapa_id',100)->nullable();
            $table->integer('reporta'); //1 admin 2 urg 3 proveedor
            $table->boolean('estatus')->default(1); //true abierto false cerrado  
            $table->dateTime('fecha_cierre')->nullable();
            $table->string('escala', 200)->nullable();
            $table->string('sancion', 250)->nullable();
            $table->text('respuesta')->nullable();
            $table->boolean('conformidad')->nullable();
            $table->text('comentario')->nullable();
            $table->unsignedInteger('user_creo')->nullable();
            $table->unsignedInteger('admin_atendio')->nullable();
            $table->unsignedInteger('urg_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('orden_compra_id')->nullable();
            $table->unsignedInteger('proveedor_id')->nullable();
            $table->timestamps(); //created_at fecha_apertura

            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('incidencias');
    }
}
