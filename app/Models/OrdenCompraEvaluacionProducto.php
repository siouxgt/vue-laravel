<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraEvaluacionProducto extends Model
{
    use HasFactory;

     public static function opinionesProducto($producto_id){
        return DB::select("SELECT ocep.id, ocep.comentario, ocep.calificacion, TO_CHAR(ocep.created_at,'DD/MM/YYYY') AS fecha_creacion, u.nombre FROM orden_compra_evaluacion_productos AS ocep JOIN urgs AS u ON ocep.urg_id = u.id WHERE ocep.producto_id =".$producto_id." ORDER BY ocep.id DESC");
    }

    public static function opinionesProductoShow($producto_id){
        return DB::select("SELECT ocep.id, ocep.comentario, ocep.calificacion, TO_CHAR(ocep.created_at,'DD/MM/YYYY') AS fecha_creacion, u.nombre FROM orden_compra_evaluacion_productos AS ocep JOIN urgs AS u ON ocep.urg_id = u.id JOIN proveedores_fichas_productos AS pfp ON ocep.producto_id = pfp.id WHERE ocep.producto_id =".$producto_id." ORDER BY ocep.id DESC");
    }

    public static function opinionesProductoFiltro($producto_id,$estrellas){
        return DB::select("SELECT ocep.id, ocep.comentario, ocep.calificacion, TO_CHAR(ocep.created_at,'DD/MM/YYYY') AS fecha_creacion, u.nombre FROM orden_compra_evaluacion_productos AS ocep JOIN urgs AS u ON ocep.urg_id = u.id JOIN proveedores_fichas_productos AS pfp ON ocep.producto_id = pfp.id WHERE ocep.calificacion = ".$estrellas." AND ocep.producto_id =".$producto_id." ORDER BY ocep.id DESC");
    }
}
