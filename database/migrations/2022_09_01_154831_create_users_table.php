<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('rfc',15)->unique();
            $table->string('curp',20);
            $table->string('nombre',50);
            $table->string('primer_apellido',100);
            $table->string('segundo_apellido',100)->nullable();
            $table->boolean('estatus')->default(1);
            $table->string('cargo',150)->nullable();
            $table->string('email',200)->nullable();
            $table->string('genero',50)->nullable();
            $table->string('password');
            $table->string('telefono',10)->nullable();
            $table->string('extension',5)->nullable();
            $table->unsignedInteger('rol_id');
            $table->unsignedInteger('urg_id');
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
