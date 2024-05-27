<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_facturas', function (Blueprint $table) {
            $table->id();
            $table->string('archivo_prefactura', 150);
            $table->dateTime('fecha_prefactura_envio');
            $table->integer('estatus_prefactura')->default(0); //0 En espera, 1 aceptado, 2 rechazado
            $table->date('fecha_prefactura_aceptada')->nullable();
            $table->integer('contador_rechazos_prefactura')->default(0); //0 prefactura original, 1 rechazado, 2: Ultimo rechazo (Este rechazo tiene que ser aceptado si o si)
            $table->string('archivo_factura', 150)->nullable();
            $table->dateTime('fecha_factura_envio')->nullable();
            $table->integer('estatus_factura')->default(0); //0 En espera, 1 aceptado, 2 rechazado
            $table->dateTime('fecha_sap')->nullable(); //fecha aceptacion
            $table->string('tipo_archivo', 100)->nullable();
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('proveedor_id');
            $table->timestamps();

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
        Schema::dropIfExists('orden_compra_facturas');
    }
}
