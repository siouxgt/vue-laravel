<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMensajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('asunto',100);
            $table->text('mensaje');
            $table->text('respuesta')->nullable();
            $table->string('imagen',150)->nullable();
            $table->integer('remitente'); //0 sistema id_usuario o id_proveedor
            $table->integer('receptor'); //0 admin id_usuario o id_proveedor
            $table->integer('tipo_remitente'); //0 sistema 1 usuario(admin,urg)  2 proveedor
            $table->integer('tipo_receptor'); //1 usuario(admin,urg)  2 proveedor
            $table->string('origen',100);
            $table->integer('producto')->nullable();
            $table->integer('orden_compra')->nullable();
            //banderas para receptor
            $table->boolean('leido')->default(0);
            $table->boolean('destacado')->default(0);
            $table->boolean('archivado')->default(0);
            $table->boolean('eliminado')->default(0);
            //banderas para remitente 
            $table->boolean('destacado_remitente')->default(0); 
            $table->boolean('archivado_remitente')->default(0);
            $table->boolean('eliminado_remitente')->default(0);
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
        Schema::dropIfExists('mensajes');
    }
}
