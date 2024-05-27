<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompra extends Model
{
    use HasFactory;

     protected $casts = [
        'created_at' => 'date:d/m/Y',
    ];

    public function urg()
    {
        return $this->belongsTo(Urg::class);
    }

    public function requisicion()
    {
        return $this->belongsTo(Requisicione::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function ordenCompraEstatus()
    {
        return $this->hasMany(OrdenCompraEstatus::class);
    }

    public static function allOrdenUrg($urg)
    {
        return DB::select("SELECT oc.id, oc.orden_compra, TO_CHAR(oc.created_at, 'DD/MM/YYYY') AS fecha, r.requisicion, (SELECT count(distinct ocb.proveedor_id) FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id) AS proveedor, (SELECT count(ocb.cabms) FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id) AS cabms, (SELECT count(ocb.id) FROM orden_compra_biens AS ocb WHERE ocb.estatus = 1 and ocb.orden_compra_id = oc.id) AS aceptadas, (SELECT count(ocb.id) FROM orden_compra_biens AS ocb WHERE ocb.estatus = 2 and ocb.orden_compra_id = oc.id) AS rechazadas, (SELECT sum(((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio)) AS total FROM orden_compra_biens AS ocb WHERE  ocb.orden_compra_id = oc.id) AS total, sc.id AS solicitud_id 
            FROM orden_compras AS oc 
            JOIN requisiciones AS r ON r.id = oc.requisicion_id 
            JOIN solicitud_compras AS sc ON sc.orden_compra_id = oc.id WHERE oc.urg_id = ".$urg);
    }

    public static function allOrden()
    {
        return DB::select("SELECT oc.id, oc.orden_compra, TO_CHAR(oc.created_at, 'DD/MM/YYYY') AS fecha, r.requisicion, u.nombre AS urg, (SELECT count(distinct ocb.proveedor_id) FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id) AS proveedor, (SELECT count(ocb.cabms) FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id) AS cabms, (SELECT count(ocb.id) FROM orden_compra_biens AS ocb WHERE ocb.estatus = 1 and ocb.orden_compra_id = oc.id) AS aceptadas, (SELECT count(ocb.id) FROM orden_compra_biens AS ocb WHERE ocb.estatus = 2 and ocb.orden_compra_id = oc.id) AS rechazadas, (SELECT sum(((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio)) AS total FROM orden_compra_biens AS ocb WHERE  ocb.orden_compra_id = oc.id) AS total, sc.id AS solicitud_id 
            FROM orden_compras AS oc 
            JOIN requisiciones AS r ON r.id = oc.requisicion_id 
            JOIN solicitud_compras AS sc ON sc.orden_compra_id = oc.id 
            JOIN urgs AS u ON oc.urg_id = u.id");
    }


    public static function datosProductosPorOrdenCompra($ordenCompraId, $proveedorId)
    { //Funcion que integra datos extra correspondientes a la orden de compra (falta integrar la $id del proveedor)
        $sql = "SELECT oce.id, oce.urg_id AS urg_id, CONCAT(u.ccg, ' - ', u.nombre) AS urg_nombre, oc.orden_compra, ocp.fecha_entrega, ocp.fecha_entrega AS dias, oce.confirmacion_estatus_proveedor, oce.indicador_proveedor, oce.finalizada, oce.envio,
        (SELECT c.contrato_pedido 
            FROM contratos c
            WHERE c.proveedor_id = oce.proveedor_id
            AND c.urg_id = oce.urg_id
            AND c.orden_compra_id = oce.orden_compra_id) 
        FROM orden_compra_estatuses oce
        JOIN urgs AS u ON u.id = oce.urg_id
        JOIN orden_compras AS oc ON oce.orden_compra_id = oc.id
        JOIN orden_compra_proveedors AS ocp ON ocp.proveedor_id = oce.proveedor_id 
        WHERE oce.urg_id = oc.urg_id
        AND ocp.orden_compra_id = oce.orden_compra_id
        AND ocp.urg_id = oce.urg_id
        AND oce.orden_compra_id = $ordenCompraId
        AND oce.proveedor_id = $proveedorId";
        return DB::select($sql);
    }

    public static function precioTotalProductosConIva($ordenCompraId, $proveedorId)
    { //Suma del precio de todos los productos ACEPTADOS y SUSTITUIDOS de la orden de compra integrando el IVA        
        return DB::select("SELECT SUM(((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio)) AS total FROM orden_compra_biens AS ocb WHERE (ocb.estatus = 1 OR ocb.estatus = 3) AND ocb.orden_compra_id = $ordenCompraId AND ocb.proveedor_id = $proveedorId");
    }

    public static function precioTotalProductosSinIva($ordenCompraId, $proveedorId, $urgId)
    { //Suma de precio de todos los productos aceptados (los que seran entregados a la URG) de la orden de compra biens. No se les esta integrando IVA        
        return DB::select("SELECT SUM((ocb.cantidad * ocb.precio)) AS total FROM orden_compra_biens AS ocb WHERE ocb.estatus = 1 AND ocb.orden_compra_id = $ordenCompraId AND ocb.proveedor_id = $proveedorId AND ocb.urg_id = $urgId");
    }

    public static function precioTotalProductosSinIvaSustitucion($ordenCompraId, $proveedorId, $urgId)
    { //Suma de precio de todos los productos por sustitucion de la orden de compra biens. No se les esta integrando IVA        
        return DB::select("SELECT SUM((ocb.cantidad * ocb.precio)) AS total FROM orden_compra_biens AS ocb WHERE ocb.estatus = 3 AND ocb.orden_compra_id = $ordenCompraId AND ocb.proveedor_id = $proveedorId AND ocb.urg_id = $urgId");
    }

    public static function datosOrdenCompraConfirmada($orden_compra_id)
    { //Obtención de datos para mostrar en la orden de compra confirmada
        $sql = "SELECT oc.orden_compra, oc.created_at AS fecha_compra, sc.requisicion, sc.urg, sc.responsable, sc.telefono, sc.correo, sc.extension, sc.direccion_almacen, sc.responsable_almacen, sc.telefono_almacen, sc.correo_almacen, sc.extension_almacen, sc.condicion_entrega FROM orden_compras AS oc JOIN solicitud_compras AS sc ON sc.orden_compra_id = oc.id AND oc.id = $orden_compra_id";
        return DB::select($sql);
    }

    public static function comboOrigenOcUrg($urg_id){
        return DB::select("SELECT oc.orden_compra AS origen FROM orden_compras AS oc WHERE oc.urg_id = ".$urg_id);
    }
}
