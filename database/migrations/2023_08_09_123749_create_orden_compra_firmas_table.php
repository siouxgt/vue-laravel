<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenCompraFirmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compra_firmas', function (Blueprint $table) {
            $table->id();
            $table->string('rfc',15);
            $table->string('nombre',50);
            $table->string('primer_apellido',50);
            $table->string('segundo_apellido',50)->nullable();
            $table->string('puesto',150)->nullable();
            $table->string('telefono',10)->nullable();
            $table->string('extension',5)->nullable();
            $table->string('correo',150);
            $table->integer('identificador'); //1 titular 2  area adquisiciones 3 proveedor 4  area financiera 5  area requiriente
            $table->string('folio_consulta',150)->nullable();
            $table->text('sello')->nullable();
            $table->string('fecha_firma',50)->nullable();
            $table->unsignedInteger('contrato_id');
            $table->timestamps(); //created_at fecha de alta contrato

            $table->foreign('contrato_id')->references('id')->on('contratos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compra_firmas');
    }
}
