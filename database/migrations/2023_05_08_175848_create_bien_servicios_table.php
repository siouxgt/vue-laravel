<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bien_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('cabms',20);
            $table->text('especificacion');
            $table->string('unidad_medida', 30);
            $table->integer('cantidad');
            $table->boolean('cotizado')->default(0);
            $table->double('precio_maximo', 15, 2)->default(0);
            $table->unsignedInteger('requisicion_id');
            $table->timestamps();

            $table->foreign('requisicion_id')->references('id')->on('requisiciones')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bien_servicios');
    }
}
