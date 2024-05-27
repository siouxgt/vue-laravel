<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosAdjudicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos_adjudicacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',50);
            $table->string('archivo_original',150);
            $table->string('archivo_publica',150);
            $table->unsignedInteger('adjudicacion_directa_id');
            $table->timestamps();

            $table->foreign('adjudicacion_directa_id')->references('id')->on('adjudicacion_directas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anexos_adjudicacions');
    }
}
