<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraEstatus extends Model
{
    use HasFactory;

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function ordenCompra(){
        return $this->belongsTo(OrdenCompra::class);
    }

    public static function ordenCompraFind($id){
        return DB::select("SELECT oce.id, p.nombre AS proveedor, p.id AS proveedor_id, oce.indicador_urg AS indicador, (SELECT TO_CHAR(c.fecha_fin, 'DD/MM/YYYY') FROM contratos AS c WHERE c.orden_compra_id = ".$id." AND c.proveedor_id = p.id ) AS fecha_fin, (SELECT count(iu.id) FROM incidencias AS iu WHERE iu.orden_compra_id = ".$id." AND iu.proveedor_id = p.id) AS incidencias, (SELECT count(ocb.id) FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = ".$id." AND ocb.proveedor_id = p.id AND ocb.estatus = 1) AS producto_aceptado FROM orden_compra_estatuses AS oce JOIN proveedores AS p ON oce.proveedor_id = p.id WHERE oce.orden_compra_id = ".$id);
    }

    public static function todosEstatuses($proveedorId){
        return DB::select("SELECT confirmacion, contrato, envio, entrega, facturacion, pago, evaluacion, finalizada FROM orden_compra_estatuses WHERE proveedor_id = $proveedorId");
    }

    public static function getConfirmacion($ordenCompraEstatusId){
        return DB::select("SELECT id, confirmacion, created_at FROM orden_compra_estatuses WHERE id = $ordenCompraEstatusId");
    }
}
