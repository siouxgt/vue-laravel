<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraProveedor extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_entrega' => 'date:d/m/Y',
    ];

    public static function allOrdenCompraProveedor($id){
        $sql = "SELECT oc.id, oces.id AS orden_compra_estatus_id, oces.confirmacion, oces.created_at AS fecha_oce, oc.orden_compra AS id_orden, oc.created_at AS fecha, CONCAT(u.ccg, ' - ', u.nombre) AS urg, oces.indicador_proveedor,
                    (SELECT count(ocb.proveedor_ficha_producto_id) FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id AND ocb.proveedor_id = ocp.proveedor_id) AS cantidad_cabms,
                    (SELECT sum(((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio)) AS total FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id AND ocb.proveedor_id = ocp.proveedor_id) AS total_compra,
                    (SELECT fecha_entrega_almacen FROM orden_compra_envios AS oce WHERE oce.orden_compra_id = oc.id AND oce.proveedor_id = ocp.proveedor_id AND oce.urg_id = u.id),
                    (SELECT to_char(c.fecha_fin, 'DD/MM/YYYY') AS fecha_fin FROM contratos AS c WHERE c.orden_compra_id = oc.id AND c.proveedor_id = ocp.proveedor_id AND c.urg_id = u.id),
                    (SELECT ocpag.created_at AS fecha_pago FROM orden_compra_pagos AS ocpag WHERE ocpag.orden_compra_id = oc.id AND ocpag.proveedor_id = ocp.proveedor_id AND ocpag.urg_id = u.id),
                    (SELECT COUNT(i.id) AS total_incidencias FROM incidencias AS i WHERE i.orden_compra_id = oc.id AND i.proveedor_id = ocp.proveedor_id AND i.urg_id = u.id AND i.etapa = (SELECT indicador_proveedor::json->>'etapa' FROM orden_compra_estatuses AS oce WHERE oce.orden_compra_id = i.orden_compra_id AND oce.proveedor_id = i.proveedor_id AND oce.urg_id = i.urg_id) AND i.reporta = 2),
                    (SELECT ocf.fecha_sap FROM orden_compra_facturas AS ocf WHERE ocf.orden_compra_id = oc.id AND ocf.proveedor_id = ocp.proveedor_id AND ocf.urg_id = u.id)            
                FROM orden_compras AS oc
                JOIN orden_compra_proveedors AS ocp ON ocp.orden_compra_id = oc.id 
                JOIN urgs AS u ON u.id = oc.urg_id 
                JOIN orden_compra_estatuses AS oces ON oces.orden_compra_id = oc.id 
                AND oces.proveedor_id = ocp.proveedor_id
                WHERE ocp.proveedor_id = $id";
        return DB::select($sql);
    }

    public static function consultaSeguimientoConfirmacion($ordenCompraId, $proveedorId){ //Consulta que trae datos para poder tomar deciciones en la CONFIRMACION de la compra
        return DB::select("SELECT ocp.id, ocp.fecha_entrega, ocp.motivo_rechazo, ocp.descripcion_rechazo, ocp.created_at, oc.orden_compra FROM orden_compra_proveedors AS ocp JOIN orden_compras AS oc ON oc.id = ocp.orden_compra_id WHERE ocp.orden_compra_id = $ordenCompraId AND ocp.proveedor_id = $proveedorId");
    }

    public static function obtenerFechaEntrega($ordenCompraId, $proveedorId){
        return DB::select("SELECT ocp.fecha_entrega FROM orden_compra_proveedors AS ocp WHERE ocp.proveedor_id = $proveedorId AND ocp.orden_compra_id = $ordenCompraId");
    }

    public static function todosProductosConfirmados($ordenCompraId, $proveedorId){
        $sql = "SELECT  ocb.nombre, ocb.cabms, ocb.medida, ocb.cantidad, ocb.precio, 
                (ocb.cantidad * ocb.precio) AS subtotal, 
                ((ocb.cantidad * ocb.precio) * .16) AS iva,
                ((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio) AS total,
                pfp.foto_uno, pfp.foto_dos, pfp.foto_tres, pfp.foto_cuatro, pfp.foto_cinco, pfp.foto_seis, pfp.descripcion_producto
                FROM orden_compra_biens AS ocb
                JOIN proveedores_fichas_productos AS pfp ON pfp.id = ocb.proveedor_ficha_producto_id
                WHERE ocb.proveedor_id = $proveedorId
                AND ocb.orden_compra_id = $ordenCompraId
                AND ocb.estatus = 1";
        return DB::select($sql);
    }

    public static function totalesOrdenCompra($proveedorId){ //Consultas para obtener cantidades de cada seccion de ordenes compra
        return DB::select("SELECT 
        (SELECT COUNT(ocp.id) AS total_nuevas FROM orden_compra_proveedors ocp JOIN orden_compra_estatuses AS oce ON ocp.proveedor_id = oce.proveedor_id WHERE ocp.urg_id = oce.urg_id AND ocp.orden_compra_id = oce.orden_compra_id AND oce.finalizada != 2 AND ocp.fecha_entrega IS NULL AND ocp.proveedor_id = $proveedorId), 
        (SELECT COUNT(id) AS total_canceladas FROM cancelar_compras WHERE proveedor_id = $proveedorId),
        (SELECT COUNT(id) AS total_rechazadas FROM rechazar_compras WHERE proveedor_id = $proveedorId),
        (SELECT COUNT(id) AS total_ocp FROM orden_compra_proveedors WHERE proveedor_id = $proveedorId)");
    }

    public static function totalVendidos($proveedorId){
        return DB::select("SELECT count(ocp.id) AS total FROM orden_compra_proveedors ocp JOIN orden_compra_estatuses AS oce ON ocp.proveedor_id = oce.proveedor_id WHERE ocp.urg_id = oce.urg_id AND ocp.orden_compra_id = oce.orden_compra_id AND oce.pago = 2 AND oce.evaluacion = 2 AND oce.finalizada = 2 AND ocp.proveedor_id = $proveedorId");
    }

    public static function totalPendientesConfirmar($proveedorId){
        return DB::select("SELECT COUNT(ocp.id) AS total FROM orden_compra_proveedors ocp JOIN orden_compra_estatuses AS oce ON ocp.proveedor_id = oce.proveedor_id WHERE ocp.urg_id = oce.urg_id AND ocp.orden_compra_id = oce.orden_compra_id AND oce.finalizada != 2 AND ocp.fecha_entrega IS NULL AND ocp.proveedor_id = $proveedorId");
    }

    public static function totalPendientesFirmar($rfcProveedor){
        return DB::select("SELECT count(ocf.id) AS total FROM orden_compra_firmas ocf WHERE ocf.identificador = 3 AND ocf.rfc = '". $rfcProveedor."'");
    }

    public static function comboOrigenOcPro($proveedor_id){
        return DB::select("SELECT oc.orden_compra AS origen FROM orden_compras AS oc JOIN orden_compra_proveedors AS ocp ON ocp.orden_compra_id = oc.id WHERE ocp.proveedor_id = ".$proveedor_id);
    }
}
