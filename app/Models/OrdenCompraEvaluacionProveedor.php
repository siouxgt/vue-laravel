<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraEvaluacionProveedor extends Model
{
    use HasFactory;

    public static function evaluacionGeneral($proveedorId){
        return DB::select('SELECT (sum(general)/count(id)) AS promedio_evaluacion FROM orden_compra_evaluacion_proveedors WHERE proveedor_id = ' . $proveedorId);
    }

    public static function opinionesProveedorShow($proveedorId){
        return DB::select("SELECT ocepr.general, ocepr.comunicacion, ocepr.calidad, ocepr.tiempo, ocepr.mercancia, ocepr.facturas, ocepr.proceso, ocepr.comentario, TO_CHAR(ocepr.created_at,'DD/MM/YYYY') AS fecha_creacion, u.nombre FROM orden_compra_evaluacion_proveedors AS ocepr JOIN urgs AS u ON ocepr.urg_id = u.id WHERE ocepr.proveedor_id = ".$proveedorId);
    }    

    public static function opinionesProveedorFiltro($proveedorId, $estrellas){
        return DB::select("SELECT ocepr.general, ocepr.comunicacion, ocepr.calidad, ocepr.tiempo, ocepr.mercancia, ocepr.facturas, ocepr.proceso, ocepr.comentario, TO_CHAR(ocepr.created_at,'DD/MM/YYYY') AS fecha_creacion, u.nombre FROM orden_compra_evaluacion_proveedors AS ocepr JOIN urgs AS u ON ocepr.urg_id = u.id WHERE ocepr.general = ".$estrellas." AND ocepr.proveedor_id = ".$proveedorId);
    }   
}
