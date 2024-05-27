<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedoresFichasProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores_fichas_productos', function (Blueprint $table) {
            $table->id();
             //Inicio
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->string('id_producto', 100);
            $table->float('version', 3, 2);
            $table->text('caracteristicas');
            $table->boolean('estatus_inicio')->default(false);
            //Producto
            $table->string('nombre_producto', 200)->nullable();
            $table->text('descripcion_producto')->nullable();
            $table->string('foto_uno', 250)->nullable();
            $table->string('foto_dos', 250)->nullable();
            $table->string('foto_tres', 250)->nullable();
            $table->string('foto_cuatro', 250)->nullable();
            $table->string('foto_cinco', 250)->nullable();
            $table->string('foto_seis', 250)->nullable();
            $table->boolean('estatus_producto')->default(false);
            //Ficha tecnica
            $table->string('doc_ficha_tecnica', 250)->nullable();
            $table->string('doc_adicional_uno', 250)->nullable();
            $table->string('doc_adicional_dos', 250)->nullable();
            $table->string('doc_adicional_tres', 250)->nullable();
            $table->boolean('estatus_ficha_tec')->default(false);
            //Caracteristicas
            $table->string('marca', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('material', 100)->nullable();
            $table->string('composicion', 100)->nullable();
            $table->string('tamanio', 50)->nullable();
            $table->json('color')->nullable(); //Nombre del color (1 -> N)
            $table->json('dimensiones')->nullable(); //Largo, ancho, alto, peso
            $table->boolean('estatus_caracteristicas')->default(false);
            //Otras caracteristicas
            $table->string('sku', 15)->nullable();
            $table->string('fabricante', 150)->nullable();
            $table->string('pais_origen', 150)->nullable();
            $table->string('grado_integracion_nacional', 150)->nullable();
            $table->string('presentacion', 150)->nullable();
            $table->string('disenio', 150)->nullable();
            $table->string('acabado', 150)->nullable();
            $table->string('forma', 150)->nullable();
            $table->string('aspecto', 150)->nullable();
            $table->string('etiqueta', 150)->nullable();
            $table->string('envase', 150)->nullable();
            $table->string('empaque', 150)->nullable();
            //Tiempo de entrega
            $table->integer('tiempo_entrega')->nullable();
            $table->string('temporalidad', 50)->nullable();
            $table->json('documentacion_incluida')->nullable(); //Catalogo, Folletos, Garantia, Manuales, Otro
            $table->boolean('estatus_entrega')->default(false);
            //Precios
            $table->double('precio_unitario', 15, 2)->nullable();
            $table->integer('unidad_minima_venta')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('vigencia')->unsigned()->default(0); //60 o 90 días
            $table->boolean('estatus_precio')->default(false);
            //Banderas para precio
            $table->boolean('validacion_precio')->nullable();
            $table->boolean('validacion_administracion')->nullable();
            $table->boolean('validacion_tecnica')->nullable();
            $table->boolean('publicado')->default(false);
            $table->integer('validacion_cuenta')->unsigned()->default(0);
            //Validacion Tecnica Pruebas
            $table->string('validacion_tecnica_prueba', 250)->nullable();
            $table->boolean('estatus_validacion_tec')->default(false);
            //-------------------------------------------------------------------------
            $table->boolean('estatus')->default(false);
            $table->foreign('producto_id')->references('id')->on('cat_productos')->onDelete('set null');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();//Campo para eliminar de manera virtual/logica
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores_fichas_productos');
    }
}
