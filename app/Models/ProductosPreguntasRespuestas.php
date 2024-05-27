<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductosPreguntasRespuestas extends Model
{
    use HasFactory;
    protected $table = "productos_preguntas_respuestas";

    public static function cargarPreguntasRespuestas($idPFP, $limitado = true) {
        $sql = "SELECT ppr.tema_pregunta, ppr.pregunta, ppr.respuesta, to_char(ppr.created_at , 'DD-MM-YYYY') as fecha_pregunta, to_char(ppr.updated_at , 'DD-MM-YYYY') as fecha_respuesta, CONCAT(p.nombre_legal, ' ', p.primer_apellido_legal, ' ', p.segundo_apellido_legal) AS nombre_proveedor, u.nombre AS nombre_urg
                FROM productos_preguntas_respuestas AS ppr, proveedores_fichas_productos AS pfp, proveedores AS p, urgs u
                WHERE ppr.urg_id = u.id AND ppr.proveedor_ficha_producto_id = pfp.id AND pfp.proveedor_id = p.id AND ppr.proveedor_ficha_producto_id = $idPFP ORDER BY ppr.id DESC";
        
        if ($limitado) $sql .= " LIMIT 3";
        return ["datos" => DB::select($sql), "total" => ProductosPreguntasRespuestas::contarTotalPreguntas($idPFP)];
    }

    public static function contarTotalPreguntas($id) { //Función que permite contar la cantidad de preguntas que se han hecho de determinado producto
        $sql = "SELECT count(ppr.id) AS total FROM productos_preguntas_respuestas AS ppr, proveedores_fichas_productos AS pfp, proveedores AS p, urgs u WHERE ppr.urg_id = u.id AND ppr.proveedor_ficha_producto_id = pfp.id AND pfp.proveedor_id = p.id AND ppr.proveedor_ficha_producto_id = $id";
        $total = DB::select($sql);
        return $total[0]->total;
    }

    public static function totalPreguntasPorProveedor($proveedorId) {
        return DB::select("SELECT count(ppr.id) total FROM productos_preguntas_respuestas ppr JOIN proveedores_fichas_productos AS pfp ON ppr.proveedor_ficha_producto_id = pfp.id WHERE pfp.proveedor_id = $proveedorId");
    }

    public static function getPreguntasParaProveedor($proveedorFichaProductoId){//Se obtienen y se ordenan por las ultimas hechas tambien trayendo primero aquellas que aun no han sido contestadas
        return DB::select("SELECT ppr.id, ppr.tema_pregunta, ppr.pregunta, ppr.respuesta , to_char(ppr.created_at, 'DD-MM-YYYY') AS fecha_pregunta, to_char(ppr.updated_at, 'DD-MM-YYYY') AS fecha_respuesta, u.nombre AS nombre_urg FROM productos_preguntas_respuestas AS ppr JOIN urgs AS u ON ppr.urg_id = u.id WHERE ppr.proveedor_ficha_producto_id = $proveedorFichaProductoId ORDER BY respuesta NULLS FIRST, ppr.created_at DESC");
    }
}
