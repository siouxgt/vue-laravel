<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosContratosMarcosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos_contratos_marcos', function (Blueprint $table) {
            $table->id();
            $table->integer('contrato_marco_id');
            $table->string('nombre_documento', 150);
            $table->string('archivo_original', 150);
            $table->string('archivo_publico', 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anexos_contratos_marcos');
    }
}
