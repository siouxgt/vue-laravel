<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraSustitucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_sustitucions', function (Blueprint $table) {
            $table->id();
            $table->string('sustitucion', 20);
            $table->string('motivo', 150)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('archivo_acuse_sustitucion', 150)->nullable();
            $table->dateTime('fecha_envio')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->string('archivo_nota_remision', 150)->nullable();
            $table->boolean('aceptado')->default(0);
            $table->dateTime('fecha_aceptada')->nullable();
            $table->integer('penalizacion')->default(0); //Guarda el número de días para generar penalización
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
        Schema::dropIfExists('orden_compra_sustitucions');
    }
}
