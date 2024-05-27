<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('folio_padron', 20);
            $table->string('rfc', 15)->unique();
            $table->string('password', 100)->nullable();
            $table->string('constancia', 50);
            $table->string('nombre', 100);
            $table->string('persona', 20);
            $table->string('nacionalidad', 20);
            $table->string('mipyme', 5);
            $table->string('tipo_pyme', 50)->nullable();
            $table->integer('codigo_postal');
            $table->string('colonia', 100);
            $table->string('alcaldia', 100);
            $table->string('entidad_federativa', 100);
            $table->string('pais', 50);
            $table->string('tipo_vialidad', 50);
            $table->string('vialidad', 100);
            $table->string('numero_exterior', 50);
            $table->string('numero_interior', 50)->nullable();
            $table->string('nombre_legal', 50)->nullable();
            $table->string('primer_apellido_legal', 50)->nullable();
            $table->string('segundo_apellido_legal', 50)->nullable();
            $table->string('rfc_legal', 50)->nullable();
            $table->string('telefono_legal', 10);
            $table->string('extension_legal', 5)->nullable();
            $table->string('celular_legal', 10);
            $table->string('correo_legal', 100);
            /// identidad
            $table->string('cedula_identificacion', 50)->nullable();
            $table->string('acta_identidad', 100)->nullable();
            $table->date('fecha_constitucion_identidad')->nullable();
            $table->string('titular_identidad', 150)->nullable(); //titular notaria
            $table->string('num_notaria_identidad', 10)->nullable();
            $table->string('entidad_identidad', 100)->nullable();
            $table->string('num_reg_identidad', 100)->nullable(); //folio mercantil
            $table->date('fecha_reg_identidad')->nullable();
            $table->boolean('acreditacion_acta_constitutiva')->nullable();  // verdadero toma identidad falso toma representante 
            /// representante legal 
            $table->string('num_instrumento_representante', 10)->nullable();
            $table->string('titular_representante', 150)->nullable();
            $table->string('num_notaria_representante', 10)->nullable();
            $table->string('entidad_representante', 100)->nullable();
            $table->string('num_reg_representante', 15)->nullable();
            $table->date('fecha_reg_representante')->nullable();
            /// matriz nivel 3
            $table->string('nombre_tres', 50)->nullable();
            $table->string('primer_apellido_tres', 50)->nullable();
            $table->string('segundo_apellido_tres', 50)->nullable();
            $table->string('cargo_tres', 100)->nullable();
            $table->string('telefono_tres', 10)->nullable();
            $table->string('extension_tres', 5)->nullable();
            $table->string('celular_tres', 10)->nullable();
            $table->string('correo_tres', 100)->nullable();
            //  matris nivel 2
            $table->string('nombre_dos', 50)->nullable();
            $table->string('primer_apellido_dos', 50)->nullable();
            $table->string('segundo_apellido_dos', 50)->nullable();
            $table->string('cargo_dos', 100)->nullable();
            $table->string('telefono_dos', 10)->nullable();
            $table->string('extension_dos', 5)->nullable();
            $table->string('celular_dos', 10)->nullable();
            $table->string('correo_dos', 100)->nullable();
            // matris nivel 1
            $table->string('nombre_uno', 50)->nullable();
            $table->string('primer_apellido_uno', 50)->nullable();
            $table->string('segundo_apellido_uno', 50)->nullable();
            $table->string('cargo_uno', 100)->nullable();
            $table->string('telefono_uno', 10)->nullable();
            $table->string('extension_uno', 5)->nullable();
            $table->string('celular_uno', 10)->nullable();
            $table->string('correo_uno', 100)->nullable();
            // 
            $table->string('confirmacion', 8)->nullable();
            $table->timestamp('confirmacion_fecha')->nullable();
            $table->boolean('perfil_completo')->default(0);
            $table->boolean('estatus')->default(1);
            $table->string('imagen', 200)->nullable();
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
        Schema::dropIfExists('proveedores');
    }
}
