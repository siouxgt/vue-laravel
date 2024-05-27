<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReporteProveedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reporte_proveedors', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 150);
            $table->json('parametros')->nullable();
            // $table->integer('estatus')->default(0); //El estatus de la generacion del reporte en Excel
            // $table->string('archivo_excel', 150)->nullable();
            $table->unsignedInteger('proveedor_id');
            $table->timestamps();

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
        Schema::dropIfExists('reporte_proveedors');
    }
}
