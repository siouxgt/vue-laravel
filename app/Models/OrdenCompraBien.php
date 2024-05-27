<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraBien extends Model
{
    use HasFactory;

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function fichaProducto(){
        return $this->belongsTo(ProveedorFichaProducto::class, 'proveedor_ficha_producto_id');
    }

    public static function todasCabmsUrg($urg){
        return DB::select("SELECT count(ocb.id) AS todas FROM orden_compra_biens AS ocb WHERE ocb.urg_id = " . $urg);
    }

    public static function cabmsAceptadasUrg($urg){
        return DB::select("SELECT count(ocb.id) AS aceptadas FROM orden_compra_biens AS ocb WHERE ocb.estatus = 1 AND ocb.urg_id = " . $urg);
    }

    public static function cabmsRechazadasUrg($urg){
        return DB::select("SELECT count(ocb.id) AS rechazadas FROM orden_compra_biens AS ocb WHERE ocb.estatus = 2 AND ocb.urg_id = " . $urg);
    }

    public static function todasCabms(){
        return DB::select("SELECT count(ocb.id) AS todas FROM orden_compra_biens AS ocb");
    }

    public static function cabmsAceptadas(){
        return DB::select("SELECT count(ocb.id) AS aceptadas FROM orden_compra_biens AS ocb WHERE ocb.estatus = 1");
    }

    public static function cabmsRechazadas(){
        return DB::select("SELECT count(ocb.id) AS rechazadas FROM orden_compra_biens AS ocb WHERE ocb.estatus = 2");
    }

    public static function productos($proveedor_id, $orden_compra_id){
        return DB::select("SELECT ocb.cabms, ocb.nombre, ocb.cantidad, ocb.precio, ocb.estatus, ocb.proveedor_ficha_producto_id FROM orden_compra_biens AS ocb WHERE ocb.proveedor_id = " . $proveedor_id . " AND ocb.orden_compra_id = " . $orden_compra_id);
    }

    public static function aceptados($ordenCompra, $proveedor){
        return DB::select('SELECT ocb.id, ocb.nombre, ocb.medida, ocb.cantidad FROM orden_compra_biens AS ocb WHERE ocb.estatus = 1 AND ocb.orden_compra_id = ' . $ordenCompra . ' AND ocb.proveedor_id = ' . $proveedor);
    }

    public static function rechazadas($ordenCompra, $proveedor){
        return DB::select('SELECT ocb.id, ocb.nombre, ocb.medida, ocb.cantidad, ocp.fecha_entrega, ocp.motivo_rechazo, ocp.descripcion_rechazo FROM orden_compra_biens AS ocb JOIN orden_compra_proveedors AS ocp ON ocb.proveedor_id = ocp.proveedor_id WHERE ocb.estatus = 2 AND ocb.orden_compra_id = ' . $ordenCompra . ' AND ocb.proveedor_id = ' . $proveedor);
    }

    public static function cancelarProductos($ordenCompra, $proveedor){
        return DB::select("SELECT ocb.id FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = " . $ordenCompra . " AND ocb.proveedor_id = " . $proveedor);
    }

    public static function productosPorOrdenCompra($orden_compra_id, $proveedor_id){ //Funcion que obtiene los productos de acuerdo al id de la orden compra seleccionada.
        return DB::select("SELECT ocb.id, ocb.cabms, ocb.nombre, CONCAT(ocb.cantidad, ' ', ocb.medida) AS cantidad, (((ocb.cantidad * ocb.precio) * .16) + (ocb.cantidad * ocb.precio)) AS total, ocb.estatus FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = " . $orden_compra_id . " AND ocb.proveedor_id = $proveedor_id");
    }

    public static function contratoPedido($ordenCompra, $proveedor){
        return DB::select("SELECT ocb.cabms, ocb.cantidad, ocb.precio, ocb.medida, pfp.descripcion_producto, pfp.marca, pfp.modelo, (ocb.cantidad * ocb.precio) AS subtotal FROM orden_compra_biens AS ocb JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id WHERE ocb.estatus = 1 AND ocb.orden_compra_id = " . $ordenCompra . " AND ocb.proveedor_id = " . $proveedor);
    }

    public static function productosPenalizacionEnvio($ordenCompra, $proveedor, $urg){
        return DB::select('SELECT ocb.cantidad, ocb.precio FROM orden_compra_biens AS ocb WHERE ocb.estatus = 1 OR ocb.estatus = 3 AND ocb.orden_compra_id = ' . $ordenCompra . ' AND ocb.proveedor_id = ' . $proveedor . ' AND ocb.urg_id = ' . $urg);
    }

    public static function productosPenalizacionSustitucion($ordenCompra, $proveedor, $urg){
        return DB::select('SELECT ocb.cantidad, ocb.precio FROM orden_compra_biens AS ocb WHERE ocb.estatus = 3 AND ocb.orden_compra_id = ' . $ordenCompra . ' AND ocb.proveedor_id = ' . $proveedor . ' AND ocb.urg_id = ' . $urg);
    }

    public static function sustitucion($ordenCompra, $proveedor){
        return DB::select("SELECT ocb.cabms, ocb.cantidad, ocb.precio, ocb.medida, pfp.descripcion_producto, pfp.marca, pfp.modelo, (ocb.cantidad * ocb.precio) AS subtotal FROM orden_compra_biens AS ocb JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id WHERE ocb.estatus = 3 AND ocb.orden_compra_id = " . $ordenCompra . " AND ocb.proveedor_id = " . $proveedor);
    }

    public static function evaluacion($ordenCompra, $proveedor){
        return DB::select("SELECT pfp.id, ocb.nombre, pfp.nombre_producto, pfp.foto_uno, pfp.marca, pfp.modelo, ocb.tamanio, ocb.color FROM orden_compra_biens AS ocb JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id WHERE ocb.orden_compra_id = " . $ordenCompra . " AND ocb.proveedor_id = " . $proveedor . " AND ocb.estatus = 1 or ocb.estatus = 3");
    }

    public static function totalPorProveedor($proveedorId){ //Sin IVA, el IVA se aplica despues
        return DB::select("SELECT SUM((ocb.precio * ocb.cantidad)) + 0 AS total FROM orden_compra_biens ocb JOIN orden_compra_estatuses AS oce ON ocb.proveedor_id = oce.proveedor_id WHERE ocb.urg_id = oce.urg_id AND ocb.orden_compra_id = oce.orden_compra_id AND oce.pago = 2 AND oce.evaluacion = 2 AND oce.finalizada = 2 AND (ocb.estatus = 1 OR ocb.estatus = 3) AND ocb.proveedor_id = $proveedorId");
    }

    public static function totalPenalizacionEnvioProveedor($proveedorId){
        return DB::select("SELECT SUM(oce.penalizacion) AS total FROM orden_compra_envios oce WHERE oce.proveedor_id = $proveedorId");
    }

    public static function totalPenalizacionSustProveedor($proveedorId){
        return DB::select("SELECT SUM(ocs.penalizacion) AS total FROM orden_compra_sustitucions ocs WHERE ocs.proveedor_id = $proveedorId");
    }

    public static function totalCabmsPorProveedor($proveedorId){
        return DB::select("SELECT COUNT(ocb.cabms) AS total FROM orden_compra_biens ocb JOIN orden_compra_estatuses AS oce ON ocb.proveedor_id = oce.proveedor_id WHERE ocb.urg_id = oce.urg_id AND ocb.orden_compra_id = oce.orden_compra_id AND oce.finalizada = 2 AND (ocb.estatus = 1 OR ocb.estatus = 3) AND ocb.proveedor_id = $proveedorId");
    }

    public static function productosMasComprados($urg_id){
        return DB::select("SELECT DISTINCT(pfp.id), pfp.nombre_producto, pfp.marca, pfp.tamanio, pfp.precio_unitario, pfp.foto_uno, pfp.created_at, ocb.medida, (select sum(ocb.cantidad) from orden_compra_biens as ocb where ocb.proveedor_ficha_producto_id = pfp.id ) AS cantidad, cp.cabms, cp.descripcion, CASE WHEN (SELECT pfu.id FROM productos_favoritos_urg AS pfu WHERE pfu.proveedor_ficha_producto_id = pfp.id AND pfu.urg_id = ".$urg_id.") IS NULL THEN false ELSE true END AS favorito, (SELECT SUM(ep.calificacion) FROM orden_compra_evaluacion_productos as ep WHERE ep.producto_id = pfp.id) AS calificacion, (SELECT COUNT(ep.id) FROM orden_compra_evaluacion_productos as ep WHERE ep.producto_id = pfp.id) AS total, (SELECT id AS id_favorito FROM productos_favoritos_urg  AS pfu WHERE pfu.proveedor_ficha_producto_id = pfp.id AND pfu.urg_id = ".$urg_id." AND deleted_at IS NULL) as id_favorito FROM orden_compra_biens AS ocb JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id JOIN cat_productos AS cp ON pfp.producto_id = cp.id WHERE pfp.estatus = true AND pfp.publicado = true GROUP BY pfp.id, pfp.nombre_producto, pfp.marca, pfp.tamanio, pfp.precio_unitario, pfp.foto_uno, pfp.created_at, ocb.medida, cp.cabms, cp.descripcion, cantidad ORDER BY cantidad DESC LIMIT 10");
    }
}
