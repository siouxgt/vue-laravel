<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Incidencia extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'fecha_respuesta' => 'date:d/m/Y',
        'fecha_cierre' => 'date:d/m/Y',
        'created_at' => 'date:d/m/Y',
    ];

    public static function getUrgs($proveedorId, $reporta)
    {
        return DB::select("SELECT distinct(u.nombre) AS nombre FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id WHERE i.reporta = $reporta AND i.proveedor_id = $proveedorId");
    }

    public static function getTotalesUrg($proveedorId)
    {
        $sql = " SELECT
                    (SELECT COUNT(DISTINCT(i.urg_id)) AS total_urgs FROM incidencias AS i WHERE i.reporta = 3 AND i.proveedor_id = $proveedorId),
                    (SELECT COUNT(i.id) AS total_incidencias FROM incidencias AS i WHERE i.reporta = 3 AND i.proveedor_id = $proveedorId),
                    (SELECT COUNT(i.id) AS total_abiertas FROM incidencias AS i WHERE i.created_at IS NOT NULL AND i.fecha_respuesta IS NULL AND fecha_cierre IS NULL AND i.reporta = 3 AND i.proveedor_id = $proveedorId),
                    (SELECT COUNT(i.id) AS total_respuestas FROM incidencias AS i WHERE i.created_at IS NOT NULL AND i.fecha_respuesta IS NOT NULL AND fecha_cierre IS NULL AND i.reporta = 3 AND i.proveedor_id = $proveedorId),
                    (SELECT COUNT(i.id) AS total_cerradas FROM incidencias AS i WHERE i.created_at IS NOT NULL AND i.fecha_respuesta IS NOT NULL AND fecha_cierre IS NOT NULL AND i.reporta = 3 AND i.proveedor_id = $proveedorId)";
        return DB::select($sql);
    }

    public static function getTotalesAdmin($proveedorId)
    {
        $sql = " SELECT                    
                    (SELECT COUNT(i.id) AS total_incidencias FROM incidencias AS i WHERE i.reporta = 1 AND i.proveedor_id = $proveedorId),
                    (SELECT COUNT(i.id) AS total_leves FROM incidencias AS i WHERE LOWER(i.escala) = 'leve' AND i.reporta = 1 AND i.proveedor_id = $proveedorId),
                    (SELECT COUNT(i.id) AS total_moderadas FROM incidencias AS i WHERE LOWER(i.escala) = 'moderada' AND i.reporta = 1 AND i.proveedor_id = $proveedorId),
                    (SELECT COUNT(i.id) AS total_graves FROM incidencias AS i WHERE LOWER(i.escala) = 'grave' AND i.reporta = 1 AND i.proveedor_id = $proveedorId)";
        return DB::select($sql);
    }

    public static function getOrigenes($proveedorId)
    {
        return DB::select("SELECT DISTINCT(i.etapa) FROM incidencias i WHERE i.reporta = 1 AND i.proveedor_id = $proveedorId");
    }

    public static function getMotivos($proveedorId)
    {
        return DB::select("SELECT DISTINCT(i.motivo) FROM incidencias i WHERE i.reporta = 1 AND i.proveedor_id = $proveedorId");
    }

    public static function allIncidenciasProveedor($proveedorId)
    {
        $sql = "SELECT i.id, u.nombre AS urg, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, initcap(i.etapa) AS origen, i.id_incidencia AS id_origen, i.motivo, CASE WHEN i.fecha_cierre IS NOT NULL THEN 'Cerrada' WHEN i.fecha_respuesta IS NOT NULL THEN 'Respuesta' ELSE 'Abierta' END AS estatus, i.fecha_cierre AS solucionado, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS fecha_respuesta, extract(days from (i.fecha_respuesta - i.created_at)) AS tiempo_respuesta, to_char(i.fecha_cierre,'DD/MM/YYYY') AS fecha_cierre, i.id_incidencia, oc.orden_compra, i.descripcion, i.escala, i.sancion, i.respuesta, CASE WHEN i.conformidad = true THEN 'SÍ' WHEN i.conformidad = false THEN 'NO' ELSE 'NO DISPONIBLE' END AS conformidad, i.comentario
                FROM incidencias AS i
                JOIN urgs AS u ON i.urg_id = u.id
                JOIN orden_compras AS oc ON i.orden_compra_id = oc.id
                WHERE i.reporta = 3
                AND i.proveedor_id = $proveedorId ORDER BY i.id";
        
        return DB::select($sql);
    }

    public static function allIncidenciasAdmin($proveedorId)
    { //Incidencias generadas por el admin
        $sql = "SELECT i.id, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.id_incidencia AS id_incidencia, initcap(i.etapa) AS origen, i.id_incidencia AS id_origen, i.motivo, i.escala, i.sancion, i.descripcion
                FROM incidencias AS i
                JOIN orden_compras AS oc ON i.orden_compra_id = oc.id
                WHERE i.reporta = 1
                AND i.proveedor_id = $proveedorId ORDER BY i.id";

        return DB::select($sql);
    }

    public static function adminUrgCount(){
        return DB::select("SELECT (SELECT DISTINCT COUNT(i.proveedor_id) FROM incidencias AS i WHERE i.reporta = 3) AS proveedores, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 3) AS todos, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 3 AND i.estatus = true) AS abiertas, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 3 AND i.estatus = false) AS cerradas, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.respuesta IS NOT NULL AND i.reporta = 3 ) AS respuestas");
    }

    public static function adminIncidenciaUrg(){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 3 ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroUrg($urg_id){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 3 AND i.urg_id = ".$urg_id." ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroUrgOrigen($origen){
         return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 3 AND i.etapa = '".$origen."' ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroUrgEstatus($estatus){
         return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 3 AND i.estatus = ".$estatus." ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroUrgFecha($de,$hasta){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 3 AND i.created_at BETWEEN '".$de."' AND '".$hasta."' ORDER BY i.id DESC");
    }

    public static function adminProveedorCount(){
        return DB::select("SELECT (SELECT COUNT(DISTINCT i.urg_id) FROM incidencias AS i WHERE i.reporta = 2) AS urgs, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 2) AS todos, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 2 AND i.estatus = true) AS abiertas, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 2 AND i.estatus = false) AS cerradas, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.respuesta IS NOT NULL AND i.reporta = 2 ) AS respuestas");
    }

    public static function adminIncidenciaProveedor(){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, i.user_creo, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 2 ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroProveedor($proveedor_id){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, i.user_creo, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 2 AND i.proveedor_id = ".$proveedor_id." ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroProveedorOrigen($origen){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, i.user_creo, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 2 AND i.etapa = '".$origen."' ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroProveedorEstatus($estatus){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, i.user_creo, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 2 AND i.estatus = ".$estatus." ORDER BY i.id DESC");
    }

    public static function adminIncidenciaFiltroProveedorFecha($de,$hasta){
        return DB::select("SELECT i.id, i.id_incidencia, u.nombre AS urg, i.proveedor_id, i.user_creo, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.created_at, i.etapa, oc.orden_compra, i.motivo, i.descripcion, i.estatus, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, i.escala, i.sancion, i.respuesta, i.conformidad, i.comentario FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.reporta = 2 AND i.created_at BETWEEN '".$de."' AND '".$hasta."' ORDER BY i.id DESC");
    }
    
    public static function adminCount($admin_id){
        return DB::select("SELECT (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.escala = 'Leve' AND i.reporta = 1 AND i.user_creo = ".$admin_id.") AS leve, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.escala = 'Moderada' AND i.reporta = 1 AND i.user_creo = ".$admin_id.") AS moderada, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.escala = 'Grave' AND i.reporta = 1 AND i.user_creo = ".$admin_id.") AS grave, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id.") AS total, (SELECT COUNT( DISTINCT i.urg_id) FROM incidencias AS i WHERE i.user_id IS NOT NULL AND i.reporta = 1 AND i.user_creo = ".$admin_id.") AS urg,  (SELECT COUNT(DISTINCT i.proveedor_id) FROM incidencias AS i WHERE i.proveedor_id IS NOT NULL  AND i.reporta = 1 AND i.user_creo = ".$admin_id.") AS proveedor");
    }

    public static function adminIncidencia($admin_id){
        return DB::select("SELECT i.id, i.id_incidencia, CASE WHEN i.user_id IS NOT NULL THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = i.user_id) ELSE (SELECT p.nombre FROM proveedores AS p WHERE p.id = i.proveedor_id) END AS usuario, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.etapa, i.etapa_id, i.motivo, i.escala, i.sancion, i.descripcion FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id);
    }

    public static function adminIncidenciaFiltroUrgs($admin_id, $urg_id){
        return DB::select("SELECT i.id, i.id_incidencia, CASE WHEN i.user_id IS NOT NULL THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = i.user_id) ELSE (SELECT p.nombre FROM proveedores AS p WHERE p.id = i.proveedor_id) END AS usuario, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.etapa, i.etapa_id, i.motivo, i.escala, i.sancion, i.descripcion FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id." AND i.urg_id =".$urg_id);
    }

    public static function adminIncidenciaFiltroProveedores($admin_id, $proveedor_id){
        return DB::select("SELECT i.id, i.id_incidencia, CASE WHEN i.user_id IS NOT NULL THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = i.user_id) ELSE (SELECT p.nombre FROM proveedores AS p WHERE p.id = i.proveedor_id) END AS usuario, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.etapa, i.etapa_id, i.motivo, i.escala, i.sancion, i.descripcion FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id." AND i.proveedor_id = ".$proveedor_id);
    }

    public static function adminIncidenciaFiltroOrigen($admin_id, $origen){
        return DB::select("SELECT i.id, i.id_incidencia, CASE WHEN i.user_id IS NOT NULL THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = i.user_id) ELSE (SELECT p.nombre FROM proveedores AS p WHERE p.id = i.proveedor_id) END AS usuario, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.etapa, i.etapa_id, i.motivo, i.escala, i.sancion, i.descripcion FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id." AND i.etapa = '".$origen."'");
    }

    public static function adminIncidenciaFiltroEscala($admin_id, $escala){
        return DB::select("SELECT i.id, i.id_incidencia, CASE WHEN i.user_id IS NOT NULL THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = i.user_id) ELSE (SELECT p.nombre FROM proveedores AS p WHERE p.id = i.proveedor_id) END AS usuario, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.etapa, i.etapa_id, i.motivo, i.escala, i.sancion, i.descripcion FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id." AND i.escala = '".$escala."'");
    }

    public static function adminIncidenciaFiltroFecha($admin_id, $de, $hasta){
        return DB::select("SELECT i.id, i.id_incidencia, CASE WHEN i.user_id IS NOT NULL THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = i.user_id) ELSE (SELECT p.nombre FROM proveedores AS p WHERE p.id = i.proveedor_id) END AS usuario, to_char(i.created_at,'DD/MM/YYYY') AS fecha_apertura, i.etapa, i.etapa_id, i.motivo, i.escala, i.sancion, i.descripcion FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id." AND i.created_at BETWEEN '".$de."' AND '".$hasta."'");
    }

    public static function ultimo(){
        return DB::select("SELECT MAX(i.id) AS id FROM incidencias AS i");
    }

    public static function origenUrg(){
        return DB::select("SELECT DISTINCT(i.etapa) FROM incidencias AS i WHERE i.reporta = 3");
    }

    public static function urgs(){
        return DB::select("SELECT DISTINCT(u.nombre), u.id FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id WHERE i.reporta = 3");
    }

    public static function origenProveedor(){
        return DB::select("SELECT DISTINCT(i.etapa) FROM incidencias AS i WHERE i.reporta = 2");
    }

    public static function proveedores(){
        return DB::select("SELECT DISTINCT(p.nombre), p.id FROM incidencias AS i JOIN proveedores AS p ON i.proveedor_id = p.id WHERE i.reporta = 2");
    }

    public static function adminUrg($admin_id){
        return DB::select("SELECT DISTINCT(u.nombre), u.id FROM incidencias AS i JOIN urgs AS u ON i.urg_id = u.id WHERE i.reporta = 1 AND i.user_creo = ".$admin_id);
    }

    public static function adminProveedor($admin_id){
        return DB::select("SELECT DISTINCT(p.nombre), p.id FROM incidencias AS i JOIN proveedores AS p ON i.proveedor_id = p.id WHERE i.reporta = 1 AND i.user_creo = ".$admin_id);
    }

    public static function adminOrigen($admin_id){
        return DB::select("SELECT DISTINCT(i.etapa) FROM incidencias AS i WHERE i.reporta = 1 AND i.user_creo = ".$admin_id);
    }

    public static function urgCount($urg_id){
        return DB::select("SELECT (SELECT COUNT(DISTINCT i.proveedor_id) FROM incidencias AS i WHERE i.reporta = 3 AND i.urg_id = ".$urg_id.") AS proveedores, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 3 AND i.urg_id = ".$urg_id.") AS todos, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 3 AND i.urg_id = ".$urg_id." AND i.estatus = true) AS abiertas, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 3 AND i.urg_id = ".$urg_id." AND i.estatus = false) AS cerradas, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 3 AND i.respuesta IS NOT NULL AND i.urg_id = ".$urg_id." ) AS respuestas");
    }

    public static function incidenciasAllUrg($urg_id){
        return DB::select("SELECT i.id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.created_at, i.etapa, i.etapa_id, i.id_incidencia, i.motivo, i.estatus, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, i.descripcion, i.sancion, i.escala, i.respuesta, i.conformidad, i.comentario, oc.orden_compra FROM incidencias AS i JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.urg_id = ".$urg_id." AND i.reporta = 3");
    }

    public static function urgAdminCount($user_id){
        return DB::select("SELECT (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 1 AND i.user_id = ".$user_id.") AS total, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 1 AND i.escala = 'Leve' AND i.user_id = ".$user_id.") AS leve, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 1 AND i.escala = 'Moderada' AND i.user_id = ".$user_id.") AS moderada, (SELECT COUNT(i.id) FROM incidencias AS i WHERE i.reporta = 1 AND i.escala = 'Grave' AND i.user_id = ".$user_id.") AS grave");
    }

    public static function urgIncidenciaFiltroProveedor($urg_id, $proveedor_id){
        return DB::select("SELECT i.id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.created_at, i.etapa, i.etapa_id, i.id_incidencia, i.motivo, i.estatus, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, i.descripcion, i.sancion, i.escala, i.respuesta, i.conformidad, i.comentario, oc.orden_compra FROM incidencias AS i JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.urg_id = ".$urg_id." AND i.reporta = 3 AND i.proveedor_id = ".$proveedor_id);
    }

    public static function urgIncidenciaFiltroEstatus($urg_id, $estatus){
        return DB::select("SELECT i.id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.created_at, i.etapa, i.etapa_id, i.id_incidencia, i.motivo, i.estatus, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, i.descripcion, i.sancion, i.escala, i.respuesta, i.conformidad, i.comentario, oc.orden_compra FROM incidencias AS i JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.urg_id = ".$urg_id." AND i.reporta = 3 AND i.estatus = '".$estatus."'");
    }

    public static function urgIncidenciaFiltroFecha($urg_id, $de, $hasta){
        return DB::select("SELECT i.id, p.nombre AS proveedor, to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.created_at, i.etapa, i.etapa_id, i.id_incidencia, i.motivo, i.estatus, to_char(i.fecha_respuesta,'DD/MM/YYYY') AS s_fecha_respuesta, i.fecha_respuesta, to_char(i.fecha_cierre,'DD/MM/YYYY') AS s_fecha_cierre, i.fecha_cierre, i.descripcion, i.sancion, i.escala, i.respuesta, i.conformidad, i.comentario, oc.orden_compra FROM incidencias AS i JOIN proveedores AS p ON i.proveedor_id = p.id JOIN orden_compras AS oc ON i.orden_compra_id = oc.id WHERE i.urg_id = ".$urg_id." AND i.reporta = 3 AND i.created_at BETWEEN '".$de."' AND '".$hasta."'");
    }

    public static function proveedoresUrg($urg_id){
        return DB::select("SELECT DISTINCT(p.nombre), p.id FROM incidencias AS i JOIN proveedores AS p ON i.proveedor_id = p.id WHERE i.reporta = 3 AND i.urg_id = ".$urg_id);
    }

    public static function urgOrigen($user_id){
        return DB::select("SELECT DISTINCT(i.etapa) FROM incidencias AS i WHERE i.reporta = 1 AND i.user_id = ".$user_id);
    }

    public static function urgMotivo($user_id){
        return DB::select("SELECT DISTINCT(i.motivo) FROM incidencias AS i WHERE i.reporta = 1 AND i.user_id = ".$user_id);
    }

    public static function incidenciasUrgAdmin($user_id){
        return DB::select("SELECT to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.id_incidencia, i.etapa, i.etapa_id, i.motivo, i.sancion, i.escala, i.descripcion FROM incidencias AS i WHERE i.user_id = ".$user_id);
    }

    public static function urgIncidenciaAdminFiltroOrigen($user_id,$origen){
        return DB::select("SELECT to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.id_incidencia, i.etapa, i.etapa_id, i.motivo, i.sancion, i.escala, i.descripcion FROM incidencias AS i WHERE i.user_id = ".$user_id." AND i.etapa = '".$origen."'");
    }

    public static function urgIncidenciaAdminFiltroMotivo($user_id,$motivo){
         return DB::select("SELECT to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.id_incidencia, i.etapa, i.etapa_id, i.motivo, i.sancion, i.escala, i.descripcion FROM incidencias AS i WHERE i.user_id = ".$user_id." AND i.motivo = '".$motivo."'");
    }

    public static function urgIncidenciaAdminFiltroEscala($user_id,$escala){
         return DB::select("SELECT to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.id_incidencia, i.etapa, i.etapa_id, i.motivo, i.sancion, i.escala, i.descripcion FROM incidencias AS i WHERE i.user_id = ".$user_id." AND i.escala = '".$escala."'");
    }

    public static function urgIncidenciaAdminFiltroFecha($user_id,$de,$hasta){
         return DB::select("SELECT to_char(i.created_at,'DD/MM/YYYY') AS s_fecha_apertura, i.id_incidencia, i.etapa, i.etapa_id, i.motivo, i.sancion, i.escala, i.descripcion FROM incidencias AS i WHERE i.user_id = ".$user_id." AND i.created_at BETWEEN '".$de."' AND '".$hasta."'");
    }
    
}
