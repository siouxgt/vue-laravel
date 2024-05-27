<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submenus', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio_alta')->nullable();
            $table->date('fecha_fin_alta')->nullable();
            $table->boolean('alta')->default(false);
            $table->date('fecha_inicio_expediente')->nullable();
            $table->date('fecha_fin_expediente')->nullable();
            $table->boolean('expediente')->default(false);
            $table->date('fecha_inicio_revisor')->nullable();
            $table->date('fecha_fin_revisor')->nullable();
            $table->boolean('revisor')->default(false);
            $table->date('fecha_inicio_proveedor')->nullable();
            $table->date('fecha_fin_proveedor')->nullable();
            $table->boolean('proveedor')->default(false);
            $table->date('fecha_inicio_producto')->nullable();
            $table->date('fecha_fin_producto')->nullable();
            $table->boolean('producto')->default(false);
            $table->date('fecha_inicio_urg')->nullable();
            $table->date('fecha_fin_urg')->nullable();
            $table->boolean('urg')->default(false);
            $table->unsignedInteger('contrato_id');
            $table->timestamps();

            $table->foreign('contrato_id')->references('id')->on('contratos_marcos')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submenus');
    }
}
