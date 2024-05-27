<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_productos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_ficha',150);
            $table->float('version',3,2);
            $table->string('capitulo',100);
            $table->text('partida');
            $table->text('cabms');
            $table->string('descripcion',300);
            $table->string('nombre_corto',50);
            $table->text('especificaciones');
            $table->string('medida',30);
            $table->boolean('validacion_tecnica')->default(0)->nullable();
            $table->string('tipo_prueba',50)->nullable();
            $table->string('archivo_ficha_tecnica',150);
            $table->boolean('estatus')->default(1);
            $table->boolean('habilitado')->default(0);
            $table->unsignedInteger('contrato_marco_id');
            $table->unsignedInteger('validacion_id')->nullable();
            $table->timestamps();

            $table->foreign('contrato_marco_id')->references('id')->on('contratos_marcos')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('validacion_id')->references('id')->on('validaciones_tecnicas')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_productos');
    }
}
