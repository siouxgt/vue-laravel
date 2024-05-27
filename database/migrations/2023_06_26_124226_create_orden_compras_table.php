<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_compras', function (Blueprint $table) {
            $table->id();
            $table->string('orden_compra',10);
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('requisicion_id');
            $table->unsignedInteger('usuario_id');
            $table->timestamps();  //fecha_compra del created_at

            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('requisicion_id')->references('id')->on('requisiciones')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_compras');
    }
}
