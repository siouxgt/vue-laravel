<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mensaje extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:d/m/Y',
        'updated_at' => 'date:d/m/Y',
    ];

    public static function mensajesProveedorTodos($proveedorId){ // Archivados y eliminados no entran en todos
        $sql = "SELECT m.id, to_char(m.created_at, 'DD/MM/YYYY') AS fecha, m.remitente, m.asunto, m.origen, m.producto, m.leido, m.destacado, m.archivado, m.eliminado, m.mensaje, m.respuesta, m.tipo_remitente, CASE WHEN m.destacado = false THEN 'no-elegido' ELSE 'destacado' END AS estado_destacado, CASE WHEN m.leido = false THEN 'no-leido' ELSE 'lectura' END AS estado_leido, m.imagen,
                (SELECT CONCAT(u.nombre, ' ', u.primer_apellido, ' ', u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) AS nombre_usuario,
                CASE WHEN m.producto IS NOT NULL THEN (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE pfp.id = m.producto) ELSE 'SIN PRODUCTO' END AS nombre_producto
                FROM mensajes m
                WHERE m.tipo_receptor = 2 AND m.receptor = $proveedorId AND m.archivado = false AND m.eliminado = false
                ORDER BY m.id DESC";
        // dd($sql);
        return DB::select($sql);
    }

    public static function mensajesProveedorEnviados($proveedorId){
        $sql = "SELECT m.id, to_char(m.created_at, 'DD/MM/YYYY') AS fecha, m.remitente, m.asunto, m.origen, m.producto, m.leido, m.destacado_remitente, m.archivado_remitente, m.eliminado_remitente, m.mensaje, m.respuesta, m.tipo_remitente, CASE WHEN m.destacado = false THEN 'no-elegido' ELSE 'destacado' END AS estado_destacado, CASE WHEN m.leido = false THEN 'no-leido' ELSE 'lectura' END AS estado_leido, m.imagen,
                (SELECT CONCAT(u.nombre, ' ', u.primer_apellido, ' ', u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) AS nombre_usuario,
                CASE WHEN m.producto IS NOT NULL THEN (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE pfp.id = m.producto) ELSE 'SIN PRODUCTO' END AS nombre_producto
                FROM mensajes m
                WHERE m.tipo_remitente = 2 AND m.remitente = $proveedorId AND m.archivado_remitente = false AND m.eliminado_remitente = false
                ORDER BY m.id DESC";
        return DB::select($sql);
    }

    public static function mensajesProveedorArchivados($proveedorId){
        $sql = "SELECT m.id, to_char(m.created_at, 'DD/MM/YYYY') AS fecha, m.remitente, m.asunto, m.origen, m.producto, m.leido, m.destacado, m.archivado, m.eliminado, m.destacado_remitente, m.archivado_remitente, m.eliminado_remitente, m.mensaje, m.respuesta, m.tipo_remitente, CASE WHEN m.destacado = false THEN 'no-elegido' ELSE 'destacado' END AS estado_destacado, CASE WHEN m.destacado_remitente = false THEN 'no-elegido' ELSE 'destacado' END AS estado_destacado_remitente, CASE WHEN m.leido = false THEN 'no-leido' ELSE 'lectura' END AS estado_leido, m.imagen,
                (SELECT CONCAT(u.nombre, ' ', u.primer_apellido, ' ', u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) AS nombre_usuario,
                CASE WHEN m.producto IS NOT NULL THEN (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE pfp.id = m.producto) ELSE 'SIN PRODUCTO' END AS nombre_producto
                FROM mensajes m
                WHERE (m.tipo_receptor = 2 OR m.tipo_remitente = 2) AND (m.receptor = $proveedorId OR m.remitente = $proveedorId) AND (m.archivado = true OR m.archivado_remitente = true) AND (m.eliminado = false OR m.eliminado_remitente = false)
                ORDER BY m.id DESC";
                // dd($sql);
        return DB::select($sql);
    }

    public static function mensajesProveedorEliminados($proveedorId){
        $sql = "SELECT m.id, to_char(m.created_at, 'DD/MM/YYYY') AS fecha, m.remitente, m.asunto, m.origen, m.producto, m.leido, m.destacado, m.archivado, m.eliminado, m.destacado_remitente, m.archivado_remitente, m.eliminado_remitente, m.mensaje, m.respuesta, m.tipo_remitente, CASE WHEN m.destacado = false THEN 'no-elegido' ELSE 'destacado' END AS estado_destacado, CASE WHEN m.destacado_remitente = false THEN 'no-elegido' ELSE 'destacado' END AS estado_destacado_remitente, CASE WHEN m.leido = false THEN 'no-leido' ELSE 'lectura' END AS estado_leido, m.imagen,
                (SELECT CONCAT(u.nombre, ' ', u.primer_apellido, ' ', u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) AS nombre_usuario,
                CASE WHEN m.producto IS NOT NULL THEN (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE pfp.id = m.producto) ELSE 'SIN PRODUCTO' END AS nombre_producto
                FROM mensajes m
                WHERE (m.tipo_receptor = 2 OR m.tipo_remitente = 2) AND (m.receptor = $proveedorId OR m.remitente = $proveedorId) AND (m.eliminado = true OR m.eliminado_remitente = true)
                ORDER BY m.id DESC";
                // dd($sql);
        return DB::select($sql);
    }

    public static function countProveedorSinLeer($proveedorId){
        return DB::select("SELECT COUNT(m.id) AS sin_leer FROM mensajes AS m WHERE m.receptor = ".$proveedorId." AND m.leido = false");
    }

    public static function getMensajeProveedor($mensajeId){
        $sql = "SELECT m.id, to_char(m.created_at, 'DD/MM/YYYY') AS fecha, m.origen, m.asunto, m.mensaje, m.respuesta, 
                (SELECT u.nombre FROM urgs AS u WHERE u.id = m.remitente) AS nombre_usuario
                FROM mensajes m
                WHERE m.id = $mensajeId";
        return DB::select($sql);
    }

    public static function ultimosMensajesProveedor($proveedorId){//Los ultimos 5 mensajes enviados a proveedor
        return DB::select("SELECT asunto, mensaje FROM mensajes WHERE tipo_receptor = 2 AND receptor = $proveedorId ORDER BY created_at LIMIT 5");
    }

    public static function mensaje($id){
         return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, m.created_at, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.id = ".$id);
    }

    public static function mensajesEnviados($user_id){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido = true, m.destacado, m.archivado, true as enviado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.remitente =".$user_id." AND m.tipo_remitente = 1");
    }

    public static function countAdminSinLeer(){
        return DB::select("SELECT COUNT(m.id) AS sin_leer FROM mensajes AS m WHERE m.receptor = 0 AND m.leido = false");
    }

    public static function mensajesAdminAll(){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = 0");
    }

    public static function mensajesAdmin(){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = 0 AND m.archivado = false AND m.eliminado = false");
    }

    public static function mensajesAdminArchivado(){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = 0 AND m.archivado = true AND m.eliminado = false");
    }

    public static function mensajesAdminEliminado(){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = 0 AND m.eliminado = true");
    }


    public static function mensajesAdminDestacados(){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = 0 AND m.destacado = true");
    }

   public static function mensajesAdminNoLeidos(){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = 0 AND m.leido = false");
    }



    public static function countUserSinLeer($user_id){
        return DB::select("SELECT COUNT(m.id) AS sin_leer FROM mensajes AS m WHERE m.receptor = ".$user_id." AND m.leido = false");
    }

    public static function mensajesUserAll($user_id){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = ".$user_id);
    }

    public static function mensajesUser($user_id){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = ".$user_id." AND m.archivado = false AND m.eliminado = false");
    }

    public static function mensajesUserArchivado($user_id){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = ".$user_id." AND m.archivado = true AND m.eliminado = false");
    }

    public static function mensajesUserEliminado($user_id){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = ".$user_id." AND m.eliminado = true");
    }

    public static function mensajesUserDestacados($user_id){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = ".$user_id." AND m.destacado = true");
    }

    public static function mensajesUserNoLeidos($user_id){
        return DB::select("SELECT m.id, m.mensaje, m.asunto, m.imagen, m.respuesta, TO_CHAR(m.created_at,'DD/MM/YYYY') AS fecha, m.origen, m.tipo_remitente, m.leido, m.destacado, m.archivado, (SELECT pfp.nombre_producto FROM proveedores_fichas_productos AS pfp WHERE m.producto = pfp.id) AS producto, (SELECT oc.orden_compra FROM orden_compras AS oc WHERE m.orden_compra = oc.id) AS orden_compra, CASE WHEN m.tipo_remitente = 0 THEN 'Sistema' WHEN m.tipo_remitente = 1 THEN (SELECT CONCAT(u.nombre,' ',u.primer_apellido,' ',u.segundo_apellido) FROM users AS u WHERE u.id = m.remitente) WHEN m.tipo_remitente = 2 THEN (SELECT p.nombre FROM proveedores AS p WHERE p.id = m.remitente) END AS remitente FROM mensajes AS m WHERE m.receptor = ".$user_id." AND m.leido = false");
    }

}