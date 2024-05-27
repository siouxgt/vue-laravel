<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosMarcosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos_marcos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cm', 150);
            $table->string('nombre_cm', 150);
            $table->string('imagen',150)->nullable();
            $table->text('objetivo');   
            $table->date('f_inicio');
            $table->date('f_fin');
            $table->json('capitulo_partida'); //Contiene: capitulo, partida, estatus_cp
            $table->boolean('compras_verdes');
            $table->boolean('validacion_tecnica');
            $table->json('validaciones_seleccionadas'); //Contiene de momento: id (Pueden agregarse direccion, siglas)
            $table->json('sector');//Contiene los sectores que seleccionara el usuario (El usuario podra seleccionar varios sectores especificos)
            $table->boolean('liberado')->default(false);
            $table->integer('porcentaje')->default(0);
            $table->boolean('eliminado')->default(0);
            $table->unsignedInteger('user_id_responsable');
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('user_id_creo');
            $table->timestamps();

            $table->foreign('user_id_responsable')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('contratos_marcos');
    }
}
