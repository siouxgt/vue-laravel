<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urgs', function (Blueprint $table) {
            $table->id();
            $table->string('ccg', 100)->unique();
            $table->string('tipo', 100);
            $table->string('nombre', 150);
            $table->string('direccion', 250);
            $table->double('monto_actuacion',21,2);
            $table->date('fecha_adhesion');
            $table->string('archivo', 150);
            $table->boolean('validadora')->default(0);
            $table->boolean('estatus')->default(1);
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
        Schema::dropIfExists('urgs');
    }
}
