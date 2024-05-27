<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoRevisorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupo_revisors', function (Blueprint $table) {
            $table->id();
            $table->string('convocatoria',10);
            $table->string('emite',100);
            $table->text('objeto');
            $table->text('motivo');
            $table->string('numero_oficio',50);
            $table->string('archivo_invitacion',150);
            $table->string('archivo_ficha_tecnica',150);
            $table->date('fecha_mesa')->nullable();
            $table->string('lugar',150)->nullable();
            $table->text('comentarios')->nullable();
            $table->integer('numero_asistieron')->default(0);
            $table->json('asistieron')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('archivo_minuta',150);
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
        Schema::dropIfExists('grupo_revisors');
    }
}
