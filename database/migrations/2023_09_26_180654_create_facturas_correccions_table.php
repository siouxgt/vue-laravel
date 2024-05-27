<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasCorreccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas_correccions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_correccion', 150);
            $table->text('descripcion');
            $table->integer('tipo_factura'); //1 prefactura 2 factura
            $table->unsignedInteger('orden_compra_facturas_id');
            $table->timestamps();

            $table->foreign('orden_compra_facturas_id')->references('id')->on('orden_compra_facturas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas_correccions');
    }
}
