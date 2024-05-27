<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisiciones', function (Blueprint $table) {
            $table->id();
            $table->string('requisicion',10);
            $table->string('area_requirente',150);
            $table->text('objeto_requisicion');
            $table->date('fecha_autorizacion');
            $table->double('monto_autorizado', 20, 2);
            $table->double('monto_por_confirmar', 20, 2)->default(0);
            $table->double('monto_adjudicado', 20, 2)->default(0);
            $table->double('monto_pagado', 20, 2)->default(0);
            $table->json('clave_partida'); //{clave_presupuestaria: , partida_presupuestal: , valor_estimado: }
            $table->boolean('estatus')->default(0);
            $table->unsignedInteger('urg_id');
            $table->timestamps();

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
        Schema::dropIfExists('requisiciones');
    }
}
