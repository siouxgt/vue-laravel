<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_compras', function (Blueprint $table) {
            $table->id();
            $table->string('orden_compra',10);
            $table->string('requisicion',10);
            $table->string('urg',200);
            $table->string('responsable',150);
            $table->string('telefono',10)->nullable();
            $table->string('correo',100);
            $table->string('extension',5)->nullable();
            $table->string('direccion_almacen',200);
            $table->string('responsable_almacen',150);
            $table->string('telefono_almacen',10);
            $table->string('correo_almacen',100);
            $table->string('extension_almacen',5)->nullable();
            $table->text('condicion_entrega');
            $table->json('producto'); // {productos: { proveedor: {producto:,imagen:,nombre:,cabms:,unidad_medida:,cantidad:,precio:,tamanio:,color:,marca: }} }
            $table->unsignedInteger('orden_compra_id');
            $table->unsignedInteger('urg_id');
            $table->unsignedInteger('requisicion_id');
            $table->unsignedInteger('usuario_id');
            $table->timestamps();  //fecha de created_at

            $table->foreign('orden_compra_id')->references('id')->on('orden_compras')->onDelete('restrict')->onUpdate('cascade');
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
        Schema::dropIfExists('solicitud_compras');
    }
}
