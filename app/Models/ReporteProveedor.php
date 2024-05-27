<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReporteProveedor extends Model {
    use HasFactory;

    public static function getAnios() {
        return DB::select('SELECT DISTINCT(extract(year from cm.created_at)) AS anio FROM contratos_marcos AS cm');
    }

    public static function getContratos() {
        return DB::select('SELECT cm.id, cm.nombre_cm FROM contratos_marcos AS cm');
    }

    public static function getUrgs() {
        return DB::select("SELECT u.id, CONCAT(u.ccg, ' - ', u.nombre) AS nombre FROM urgs AS u");
    }

    public static function getProveedores() {
        return DB::select("SELECT p.id, p.nombre FROM proveedores AS p");
    }

    //Zona de reportes

    public static function allReportes($proveedorId) {
        return DB::select("SELECT id, tipo, created_at AS fecha_creacion, created_at AS estatus FROM reporte_proveedors WHERE proveedor_id = $proveedorId ORDER BY id DESC");
    }

    public static function buscarReportes($tipoReporte, $proveedorId) {
        return DB::select("SELECT id, tipo, parametros FROM reporte_proveedors WHERE proveedor_id = $proveedorId AND tipo = '$tipoReporte'");
    }

    public static function buscarTipoReporte($reporteId) { //Buscar el reporte 
        return DB::select("SELECT rp.tipo, rp.created_at AS fecha_reporte FROM reporte_proveedors AS rp WHERE rp.id = $reporteId");
    }

    public static function getDirectorioUnidadesCompradoras($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT ur.id, UPPER(CONCAT(ur.ccg, ' - ', ur.nombre)) AS nombre_urg, (SELECT us.email FROM users AS us WHERE us.rol_id = 4 AND us.urg_id = ur.id LIMIT 1) AS correo, (SELECT u.telefono FROM users AS u WHERE u.rol_id = 4 AND u.urg_id = ur.id LIMIT 1) AS telefono, TO_CHAR(ur.created_at,'DD/MM/YYYY') AS fecha_creacion 
                FROM urgs AS ur";

        if ($urgId != 0) $sql .= " AND ur.id = $urgId";
        //Falta revisar la zona de contratos
        if ($contratoMarcoId != 0) $sql .= " AND cmu.contrato_marco_id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND EXTRACT(year FROM ur.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND ur.created_at BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";

        // dd($sql);
        return DB::select($sql);
    }

    public static function getOrdenCompraGeneral($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT ";
        if ($contratoMarcoId != 0) $sql .= "DISTINCT(cp.contrato_marco_id), ";
        $sql .= "oc.id, oc.orden_compra, r.requisicion, CONCAT(u.ccg, ' - ', u.nombre) AS nombre_urg, p.nombre AS nombre_proveedor, p.rfc, to_char(oc.created_at,'DD/MM/YYYY') AS fecha_oc, (SELECT SUM(((ocbi.cantidad * ocbi.precio) * .16) + (ocbi.cantidad * ocbi.precio)) AS total FROM orden_compra_biens AS ocbi WHERE ocbi.orden_compra_id = oc.id) AS monto_total, CASE WHEN (SELECT cc.id FROM cancelar_compras AS cc WHERE cc.orden_compra_id = oc.id) IS NOT NULL THEN 'CANCELADA' WHEN (SELECT COUNT(rc.id) FROM rechazar_compras AS rc WHERE rc.orden_compra_id = oc.id) <> 0 THEN 'RECHAZADA' WHEN (SELECT oce.finalizada FROM orden_compra_estatuses AS oce WHERE oce.orden_compra_id = oc.id) = 2 THEN 'FINALIZADA' ELSE 'EN PROCESO' END AS estatus, (SELECT string_agg(DISTINCT (CASE WHEN substring(ocb.cabms, 1, 1) = '1' THEN '1000' WHEN substring(ocb.cabms, 1, 1) = '2' THEN '2000' WHEN substring(ocb.cabms, 1, 1) = '3' THEN '3000' WHEN substring(ocb.cabms, 1, 1) = '4' THEN '4000' WHEN substring(ocb.cabms, 1, 1) = '5' THEN '5000' END), ',') FROM orden_compra_biens AS ocb WHERE ocb.orden_compra_id = oc.id AND ocb.estatus = 1 OR ocb.estatus = 3 ) AS capitulos FROM orden_compras AS oc JOIN requisiciones AS r ON oc.requisicion_id = r.id JOIN urgs AS u ON oc.urg_id = u.id JOIN orden_compra_proveedors AS ocp ON ocp.orden_compra_id = oc.id JOIN proveedores AS p ON ocp.proveedor_id = p.id ";

        if ($contratoMarcoId != 0) {
            $sql .= "JOIN orden_compra_biens AS ocb ON ocb.orden_compra_id = oc.id JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id JOIN cat_productos AS cp ON pfp.producto_id = cp.id WHERE ocp.proveedor_id = $proveedorId AND cp.contrato_marco_id = $contratoMarcoId";
        } else {
            $sql .= " WHERE ocp.proveedor_id = $proveedorId";
        }
        if ($urgId != 0) $sql .= " AND oc.urg_id = $urgId";
        if ($anio != 0) $sql .= " AND EXTRACT(year FROM oc.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND oc.created_at BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        // dd($sql);
        return DB::select($sql);
    }

    public static function getOrdenCompraCompleto($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) { //Reporte 3 y de URGs
        $sql = "SELECT oc.orden_compra, r.requisicion, CONCAT(u.ccg, ' - ', u.nombre) AS urg, ocb.cabms, pfp.descripcion_producto, UPPER(ocb.medida) AS unidad_medida, ocb.precio AS precio_unitario, ocb.cantidad, (ocb.precio * ocb.cantidad) + ((ocb.precio * ocb.cantidad) * 0.16) AS monto_total_iva, (ocb.precio * ocb.cantidad) AS monto_total_sin_iva, CASE WHEN substring(ocb.cabms, 1, 1) = '1' THEN '1000' WHEN substring(ocb.cabms, 1, 1) = '2' THEN '2000' WHEN substring(ocb.cabms, 1, 1) = '3' THEN '3000' WHEN substring(ocb.cabms, 1, 1) = '4' THEN '4000' ELSE '5000' END AS capitulo, CASE WHEN (SELECT cc.id FROM cancelar_compras AS cc WHERE cc.orden_compra_id = oc.id AND cc.proveedor_id = p.id) IS NOT NULL THEN 'CANCELADA' WHEN (SELECT COUNT(id) FROM  rechazar_compras WHERE orden_compra_id = oc.id) != 0 THEN 'RECHAZADA' WHEN (SELECT finalizada FROM orden_compra_estatuses WHERE orden_compra_id = oc.id) = 2 THEN 'FINALIZADA' ELSE 'EN PROCESO' END AS estatus, p.nombre, p.rfc, 'PEDIDO' AS tipo_contrato, UPPER(cm.numero_cm) AS id_contrato, UPPER(cm.nombre_cm) AS nombre_contrato, TO_CHAR(oc.created_at,'DD/MM/YYYY') AS fecha_creacion FROM orden_compra_biens AS ocb JOIN orden_compras AS oc ON ocb.orden_compra_id = oc.id JOIN requisiciones AS r ON ocb.requisicion_id = r.id JOIN urgs AS u ON ocb.urg_id = u.id JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id JOIN proveedores AS p ON ocb.proveedor_id = p.id JOIN habilitar_proveedores AS hp ON ocb.proveedor_id = hp.proveedor_id JOIN contratos_marcos AS cm ON hp.contrato_id = cm.id WHERE ocb.proveedor_id = $proveedorId ";

        if ($urgId != 0) $sql .= " AND ocb.urg_id = $urgId";//No se aplica aquí
        if ($contratoMarcoId != 0) $sql .= " AND cm.id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND EXTRACT(year FROM oc.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND oc.created_at BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        // dd($sql);
        return DB::select($sql);
    }

    public static function getOrdenCompraCompletoUrg($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) { //Reporte 3 y de URGs
        $sql = "SELECT oc.orden_compra, r.requisicion, CONCAT(u.ccg, ' - ', u.nombre) AS urg, ocb.cabms, pfp.descripcion_producto, UPPER(ocb.medida) AS unidad_medida, ocb.precio AS precio_unitario, ocb.cantidad, (ocb.precio * ocb.cantidad) + ((ocb.precio * ocb.cantidad) * 0.16) AS monto_total_iva, (ocb.precio * ocb.cantidad) AS monto_total_sin_iva, CASE WHEN substring(ocb.cabms, 1, 1) = '1' THEN '1000' WHEN substring(ocb.cabms, 1, 1) = '2' THEN '2000' WHEN substring(ocb.cabms, 1, 1) = '3' THEN '3000' WHEN substring(ocb.cabms, 1, 1) = '4' THEN '4000' ELSE '5000' END AS capitulo, CASE WHEN (SELECT cc.id FROM cancelar_compras AS cc WHERE cc.orden_compra_id = oc.id AND cc.proveedor_id = p.id) IS NOT NULL THEN 'CANCELADA' WHEN (SELECT COUNT(id) FROM  rechazar_compras WHERE orden_compra_id = oc.id) != 0 THEN 'RECHAZADA' WHEN (SELECT finalizada FROM orden_compra_estatuses WHERE orden_compra_id = oc.id) = 2 THEN 'FINALIZADA' ELSE 'EN PROCESO' END AS estatus, p.nombre, p.rfc, 'PEDIDO' AS tipo_contrato, UPPER(cm.numero_cm) AS id_contrato, UPPER(cm.nombre_cm) AS nombre_contrato, TO_CHAR(oc.created_at,'DD/MM/YYYY') AS fecha_creacion, (SELECT CONCAT(ocf.nombre,' ', ocf.primer_apellido,' ',ocf.segundo_apellido) FROM orden_compra_firmas AS ocf WHERE ocf.contrato_id = cm.id AND ocf.identificador = 1) AS director, (SELECT CONCAT(ocf.nombre,' ', ocf.primer_apellido,' ',ocf.segundo_apellido) FROM orden_compra_firmas AS ocf WHERE ocf.contrato_id = cm.id AND ocf.identificador = 2) AS responsable FROM orden_compra_biens AS ocb JOIN orden_compras AS oc ON ocb.orden_compra_id = oc.id JOIN requisiciones AS r ON ocb.requisicion_id = r.id JOIN urgs AS u ON ocb.urg_id = u.id JOIN proveedores_fichas_productos AS pfp ON ocb.proveedor_ficha_producto_id = pfp.id JOIN proveedores AS p ON ocb.proveedor_id = p.id JOIN habilitar_proveedores AS hp ON ocb.proveedor_id = hp.proveedor_id JOIN contratos_marcos AS cm ON hp.contrato_id = cm.id WHERE ocb.proveedor_id = $proveedorId ";

        if ($urgId != 0) $sql .= " AND ocb.urg_id = $urgId";
        if ($contratoMarcoId != 0) $sql .= " AND cm.id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND EXTRACT(year FROM oc.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND oc.created_at BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        // dd($sql);
        return DB::select($sql);
    }

    public static function getIncidenciasUrg($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT i.id_incidencia AS id_identificacion, u.nombre AS urg, cm.nombre_cm, cm.numero_cm, i.motivo, i.descripcion, u.ccg, i.created_at AS fecha_incidencia, i.etapa, i.etapa
                FROM incidencias AS i
                JOIN contratos_marcos_urgs AS cmu ON i.urg_id = cmu.urg_id
                JOIN urgs AS u ON cmu.urg_id = u.id
                JOIN contratos_marcos AS cm ON cmu.contrato_marco_id = cm.id
                WHERE i.reporta = 3
                AND i.proveedor_id = $proveedorId";

        if ($urgId != 0) $sql .= " AND i.urg_id = $urgId";
        if ($contratoMarcoId != 0) $sql .= " AND cmu.contrato_marco_id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND extract(year from i.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND i.created_at >= '" . $fechaInicio . "' AND i.created_at <= '" . $fechaFin . "'";

        // dd($sql);
        return DB::select($sql);
    }

    public static function getProductosContratoGeneral($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT pfp.id, cp.partida, cp.cabms, cp.capitulo, UPPER(pfp.nombre_producto) AS nombre_producto, to_char(hprod.fecha_publicacion,'DD/MM/YYYY') AS fecha_publicacion, CASE WHEN pfp.validacion_precio = true THEN 'SI' ELSE 'NO' END AS validacion_precio, CASE WHEN pfp.validacion_tecnica = true THEN 'SI' ELSE 'NO' END AS validacion_tecnica, CASE WHEN pfp.validacion_administracion = true THEN 'SI' ELSE 'NO' END AS validacion_administracion, UPPER(cm.nombre_cm) AS nombre_cm, UPPER(cm.numero_cm) AS numero_cm, CASE WHEN pfp.estatus = true THEN 'DISPONIBLE' ELSE 'NO DISPONIBLE' END AS estatus, p.nombre, cp.numero_ficha, pfp.version
                FROM contratos_marcos AS cm
                JOIN habilitar_proveedores AS hp ON hp.contrato_id = cm.id
                JOIN proveedores_fichas_productos AS pfp ON pfp.proveedor_id = hp.proveedor_id
                JOIN cat_productos AS cp ON cp.id = pfp.producto_id
                JOIN proveedores AS p ON hp.proveedor_id = p.id
                JOIN habilitar_productos AS hprod ON hprod.cat_producto_id = cp.id";

        if ($urgId != 0) $sql .= " JOIN contratos_marcos_urgs AS cmu ON cmu.contrato_marco_id= cm.id WHERE p.id = $proveedorId AND cm.urg_id = $urgId";
        else $sql .= " WHERE p.id = $proveedorId";

        if ($contratoMarcoId != 0) $sql .= " AND cm.id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND extract(year from pfp.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND pfp.created_at >= '" . $fechaInicio . "' AND pfp.created_at <= '" . $fechaFin . "'";

        // dd($sql);
        return DB::select($sql);
    }

    public static function getProductosContratoCompleto($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT pfp.id, substring(cp.partida,1,4) AS partida, cp.cabms, substring(cp.capitulo,1,4) AS capitulo, to_char(pfp.created_at, 'DD/MM/YYYY') AS fecha_publicacion, CASE WHEN pfp.validacion_precio = true THEN 'SI' ELSE 'NO' END AS validacion_economica, CASE WHEN pfp.validacion_administracion = true THEN 'SI' ELSE 'NO' END AS validacion_administrativa, CASE WHEN pfp.validacion_tecnica = true THEN 'SI' ELSE 'NO' END AS validacion_tecnica, UPPER(cm.nombre_cm) AS nombre_cm, UPPER(cm.numero_cm) AS numero_cm, CASE WHEN pfp.estatus = true THEN 'DISPONIBLE' ELSE 'NO DISPONIBLE' END AS estatus, p.nombre, pfp.precio_unitario, ((pfp.precio_unitario * .16) + pfp.precio_unitario) AS precio_unitario_iva, UPPER(cp.medida) AS unidad_medida, UPPER(pfp.nombre_producto) AS nombre_producto, UPPER(pfp.descripcion_producto) AS descripcion_producto, to_char(pfp.updated_at,'DD/MM/YYYY') AS fecha_modificacion_precio, cp.numero_ficha, pfp.version FROM proveedores_fichas_productos AS pfp JOIN cat_productos AS cp ON cp.id = pfp.producto_id JOIN contratos_marcos AS cm ON cp.contrato_marco_id = cm.id JOIN proveedores AS p ON pfp.proveedor_id = p.id";

        if ($urgId != 0) $sql .= " JOIN contratos_marcos_urgs AS cmu ON cmu.contrato_marco_id= cm.id WHERE p.id = $proveedorId AND cm.urg_id = $urgId";
        else $sql .= " WHERE p.id = $proveedorId";

        if ($contratoMarcoId != 0) $sql .= " AND cm.id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND EXTRACT(year FROM pfp.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND pfp.created_at BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        // dd($sql);
        return DB::select($sql);
    }

    public static function getAdhesionUrgContrato($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT cm.id, cmu.numero_archivo_adhesion, EXTRACT(MONTH FROM cmu.created_at) AS fecha_registro, UPPER(cm.numero_cm) AS numero_cm, UPPER(cm.nombre_cm) AS nombre_cm, UPPER(cm.objetivo) AS objetivo, UPPER(u.nombre) AS nombre, u.ccg, to_char(cmu.fecha_firma,'DD/MM/YYYY') AS fecha_firma, to_char(cm.f_fin,'DD/MM/YYYY') AS f_fin, CASE WHEN cmu.estatus = true THEN 'ACTIVO' ELSE 'INACTIVO' END AS estatus
                FROM contratos_marcos AS cm
                JOIN contratos_marcos_urgs AS cmu ON cmu.contrato_marco_id = cm.id
                JOIN urgs AS u ON cmu.urg_id = u.id
                JOIN habilitar_proveedores AS hp ON hp.contrato_id = cm.id
                WHERE hp.proveedor_id = $proveedorId";

        if ($urgId != 0) $sql .= " AND u.id = $urgId";
        if ($contratoMarcoId != 0) $sql .= " AND cm.id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND extract(year from cmu.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND cmu.created_at >= '" . $fechaInicio . "' AND cmu.created_at <= '" . $fechaFin . "'";

        // dd($sql);
        return DB::select($sql);
    }

    public static function getAnaliticosContratoCompleto($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT cm.id, EXTRACT(MONTH FROM cm.created_at) as mes, UPPER(cm.numero_cm) AS numero_cm, cm.objetivo, to_char(cm.created_at,'DD/MM/YYYY') AS fecha_creacion, to_char(cm.f_fin,'DD/MM/YYYY') AS f_fin, to_char(cm.updated_at,'DD/MM/YYYY') AS fecha_modificacion, CONCAT(us.nombre, ' ', us.primer_apellido, ' ', us.segundo_apellido) AS nombre_responsable_alta, to_char(cmu.fecha_firma,'DD/MM/YYYY') AS fecha_ingreso_urg, to_char(hp.fecha_adhesion,'DD/MM/YYYY') AS fecha_ingreso_proveedor, cm.capitulo_partida, UPPER(u.nombre) AS urg, CASE WHEN cmu.estatus = true THEN 'ACTIVO' ELSE 'INACTIVO' END AS estatus_urg, p.rfc, p.nombre AS nombre_proveedor, CASE WHEN hp.habilitado = true THEN 'ACTIVO' ELSE 'INACTIVO' END AS estatus_proveedor, CASE WHEN cm.eliminado = true THEN 'INACTIVO' ELSE 'ACTIVO' END AS estatus_contrato, cm.numero_cm,
                (SELECT c.orden_compra FROM contratos AS c WHERE c.proveedor_id = hp.proveedor_id) AS id_orden_compra
                FROM contratos_marcos AS cm
                JOIN users AS us ON cm.user_id_creo = us.id
                JOIN contratos_marcos_urgs AS cmu ON cmu.contrato_marco_id = cm.id
                JOIN habilitar_proveedores AS hp ON hp.contrato_id = cm.id
                JOIN urgs AS u ON cmu.urg_id = u.id
                JOIN proveedores AS p ON hp.proveedor_id = p.id
                WHERE hp.proveedor_id = $proveedorId";

        if ($urgId != 0) $sql .= " AND cmu.urg_id = $urgId";
        if ($contratoMarcoId != 0) $sql .= " AND cm.id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND extract(year from cm.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND cm.created_at >= '" . $fechaInicio . "' AND cm.created_at <= '" . $fechaFin . "'";

        // dd($sql);
        return DB::select($sql);
    }

    public static function getClavesCambsContrato($proveedorId, $urgId, $contratoMarcoId, $anio, $fechaInicio, $fechaFin) {
        $sql = "SELECT pfp.id, cp.partida, cp.capitulo, cp.cabms, UPPER(cm.numero_cm) AS numero_cm, UPPER(cm.nombre_cm) AS nombre_cm, UPPER(pfp.descripcion_producto) AS descripcion_producto 
                FROM contratos_marcos AS cm
                JOIN habilitar_proveedores AS hp ON hp.contrato_id = cm.id
                JOIN proveedores_fichas_productos AS pfp ON pfp.proveedor_id = hp.proveedor_id
                JOIN cat_productos AS cp ON cp.id = pfp.producto_id";

        if ($urgId != 0) $sql .= " JOIN contratos_marcos_urgs AS cmu ON cmu.contrato_marco_id= cm.id WHERE pfp.id = $proveedorId AND cm.urg_id = $urgId";
        else $sql .= " WHERE pfp.id = $proveedorId";

        if ($contratoMarcoId != 0) $sql .= " AND cm.id = $contratoMarcoId";
        if ($anio != 0) $sql .= " AND extract(year from cp.created_at) = $anio";
        if ($fechaInicio != 0 && $fechaFin != 0) $sql .= " AND cp.created_at >= '" . $fechaInicio . "' AND cp.created_at <= '" . $fechaFin . "'";

        // dd($sql);
        return DB::select($sql);
    }
}
