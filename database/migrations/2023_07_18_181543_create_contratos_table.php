<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->string('contrato_pedido',15);
            $table->string('institucion',200)->nullable();
            $table->string('antecedentes',100)->nullable(); //nombre contrato marco
            $table->string('orden_compra',10)->nullable();
            $table->string('area_requiriente',200)->nullable();
            $table->string('requisicion',20)->nullable();
            $table->string('partida',150)->nullable();
            $table->string('oficio_adhesion',150)->nullable();
            $table->string('anio_fiscal',5)->nullable();

            $table->date('fecha_fallo')->nullable();
            
            $table->string('director',200)->nullable();
            $table->string('rfc_fiscal',15)->nullable(); 
            $table->string('direccion_urg',250)->nullable(); 
            $table->string('telefono_urg',15)->nullable();

            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('ccg',10)->nullable(); 
            $table->string('responsable_almacen',150)->nullable(); 
            $table->string('direccion_almacen',250)->nullable(); 
            $table->string('telefono_almacen',50)->nullable(); 
            $table->date('fecha_entrega')->nullable();
            
            $table->string('nombre_proveedor',200)->nullable();
            $table->string('rfc_proveedor',15)->nullable();
            $table->string('domicilio_proveedor',250)->nullable(); 
            $table->string('telefono_proveedor',10)->nullable(); 
            
            $table->string('cedula_identificacion')->nullable();

            $table->string('acta_identidad',10)->nullable(); //acta constitutiva 
            $table->date('fecha_constitucion_identidad')->nullable(); 
            $table->string('titular_identidad',150)->nullable(); //nombre notario 
            $table->string('num_notaria_identidad',10)->nullable();
            $table->string('entidad_identidad',100)->nullable();
            $table->string('num_reg_identidad',100)->nullable(); //folio mercantil
            $table->date('fecha_reg_identidad')->nullable();

            $table->string('representante_proveedor',150)->nullable();

            // se acredita de otra forma 
            $table->string('num_instrumento_representante', 10)->nullable();
            $table->string('titular_representante', 150)->nullable(); //nombre notario
            $table->string('num_notaria_representante', 10)->nullable();
            $table->string('entidad_representante', 100)->nullable();
            $table->string('num_reg_representante', 15)->nullable(); //folio mercantil
            $table->date('fecha_reg_representante')->nullable();
            
            $table->text('garantias_anexas')->nullable();
            
            $table->string('articulo',50)->nullable();
            
            $table->string('numero_contrato_marco',100)->nullable(); //numero contrato marco 
            $table->date('fecha_contrato_marco')->nullable();
            $table->unsignedInteger('contrato_marco_id')->nullable();

            $table->string('razon_social_fiscal',100)->nullable(); 
            $table->string('domicilio_fiscal',200)->nullable(); 
            $table->string('metodo_pago',50)->nullable(); 
            $table->string('forma_pago',50)->nullable(); 
            $table->string('uso_cfdi',100)->nullable(); 

            $table->string('archivo_bancario',200)->nullable(); //PDF de cuenta bancaria

            $table->integer('estatus')->default(0); //0 no terminado 1 para firmar 2 firmado  
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('requisicion_id');
            $table->timestamps(); //fecha creacion 

            $table->foreign('urg_id')->references('id')->on('urgs')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('contratos');
    }
}

