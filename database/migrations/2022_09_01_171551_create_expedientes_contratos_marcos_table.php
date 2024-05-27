<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpedientesContratosMarcosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedientes_contratos_marcos', function (Blueprint $table) {
            $table->id();
            $table->date('f_creacion');
            $table->string('metodo', 50);
            $table->string('num_procedimiento', 50);
            $table->string('imagen',150)->nullable();
            $table->boolean('liberado')->default(0);
            $table->integer('porcentaje')->default(0);
            $table->unsignedInteger('contrato_id');
            $table->unsignedInteger('user_id_creo');
            $table->timestamps();

            $table->foreign('contrato_id')->references('id')->on('contratos_marcos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('user_id_creo')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expedientes_contratos_marcos');
    }
}
