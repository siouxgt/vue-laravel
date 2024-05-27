<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraEstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_estatuses', function (Blueprint $table) {
            $table->id();
            $table->integer('confirmacion')->default(1);   //0 no iniciado 1 en proceso 2 finalizado 
            $table->json('confirmacion_estatus_urg')->nullable(); //mensaje debajo de la etapa ['mensaje' => '', 'css' => '']
            $table->json('confirmacion_estatus_proveedor')->nullable();
            $table->json('confirmacion_boton_urg')->nullable(); //boton de la etapa ['mensaje' => '', 'css' => '']
            $table->json('confirmacion_boton_proveedor')->nullable();
            $table->integer('contrato')->default(0);
            $table->json('contrato_estatus_urg')->nullable();
            $table->json('contrato_estatus_proveedor')->nullable();
            $table->json('contrato_boton_urg')->nullable();
            $table->json('contrato_boton_proveedor')->nullable();
            $table->integer('envio')->default(0);
            $table->json('envio_estatus_urg')->nullable();
            $table->json('envio_estatus_proveedor')->nullable();
            $table->json('envio_boton_urg')->nullable();
            $table->json('envio_boton_proveedor')->nullable();
            $table->integer('entrega')->default(0);
            $table->json('entrega_estatus_urg')->nullable();
            $table->json('entrega_estatus_proveedor')->nullable();
            $table->json('entrega_boton_urg')->nullable();
            $table->json('entrega_boton_proveedor')->nullable();
            $table->integer('facturacion')->default(0);
            $table->json('facturacion_estatus_urg')->nullable();
            $table->json('facturacion_estatus_proveedor')->nullable();
            $table->json('facturacion_boton_urg')->nullable();
            $table->json('facturacion_boton_proveedor')->nullable();
            $table->integer('pago')->default(0);
            $table->json('pago_estatus_urg')->nullable();
            $table->json('pago_estatus_proveedor')->nullable();
            $table->json('pago_boton_urg')->nullable();
            $table->json('pago_boton_proveedor')->nullable();
            $table->integer('evaluacion')->default(0);
            $table->json('evaluacion_estatus_urg')->nullable();
            $table->json('evaluacion_estatus_proveedor')->nullable();
            $table->json('evaluacion_boton_urg')->nullable();
            $table->json('evaluacion_boton_proveedor')->nullable();
            $table->integer('finalizada')->default(0);
            $table->json('indicador_urg')->nullable();  //indicador columna estatus de tabla index ['etapa' => '', 'estatus' => ''] colores estatus 0 gris 1 verde 2 dorado 3 rojo
            $table->json('indicador_proveedor')->nullable(); //indicador columna estatus de tabla index
            $table->json('alerta_urg')->nullable();  // ['mensaje' => '', 'css' => '']
            $table->json('alerta_proveedor')->nullable();
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('urg_id');
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
        Schema::dropIfExists('orden_compra_estatuses');
    }
}
