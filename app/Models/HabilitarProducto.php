<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HabilitarProducto extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_estudio' => 'date:d/m/Y',
        'fecha_formulario' => 'date:d/m/Y',
        'fecha_carga' => 'date:d/m/Y',
        'fecha_administrativa' => 'date:d/m/Y',
        'fecha_tecnica' => 'date:d/m/Y',
        'fecha_publicacion' => 'date:d/m/Y',
    ];

    public static function todos($id){
        return DB::select("SELECT hp.id, hp.cat_producto_id, cp.cabms, cp.descripcion, (SELECT count(fp.id) FROM proveedores_fichas_productos AS fp WHERE fp.producto_id = cp.id ) AS producto, CASE WHEN cp.estatus = true THEN 'Activo' ELSE 'Inactivo' END AS estatus, cp.habilitado FROM habilitar_productos AS hp JOIN cat_productos AS cp ON hp.cat_producto_id = cp.id WHERE cp.contrato_marco_id = ".$id);
    }

    public static function countProducto($id){
        return DB::select('SELECT hp.id FROM habilitar_productos AS hp JOIN cat_productos AS cp ON hp.cat_producto_id = cp.id WHERE hp.precio_maximo IS NOT NULL and cp.contrato_marco_id = '.$id);
    }

    public static function productoHabilitado($id){
        return DB::select('SELECT gr.convocatoria, hp.precio_maximo, hp.fecha_estudio, hp.archivo_estudio_original, hp.archivo_estudio_publico, hp.fecha_formulario, hp.fecha_carga, hp.fecha_administrativa, hp.fecha_tecnica, hp.fecha_publicacion FROM habilitar_productos AS hp JOIN grupo_revisors AS gr ON hp.grupo_revisor_id = gr.id WHERE hp.cat_producto_id ='. $id);
    }

    public static function pmr($cabms){
        return DB::select("SELECT hp.id, hp.precio_maximo FROM habilitar_productos AS hp JOIN cat_productos AS cp ON hp.cat_producto_id = cp.id WHERE cp.cabms = '".$cabms."' AND hp.precio_maximo IS NOT null ORDER BY hp.id desc LIMIT 1 ");
    }
}
