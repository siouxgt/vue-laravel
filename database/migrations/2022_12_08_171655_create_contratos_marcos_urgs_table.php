<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosMarcosUrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos_marcos_urgs', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_firma');
            $table->string('a_terminos_especificos', 250); //Archivo de la firma de los términos específicos
            $table->string('numero_archivo_adhesion',100);
            $table->boolean('estatus');
            $table->unsignedBigInteger('urg_id')->nullable(false);
            $table->unsignedBigInteger('contrato_marco_id')->nullable(false);
            $table->timestamps();
            
            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('set null');
            $table->foreign('contrato_marco_id')->references('id')->on('contratos_marcos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratos_marcos_urgs');
    }
}
