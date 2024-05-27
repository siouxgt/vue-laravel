<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ValidacionAdministrativa extends Model {
    use HasFactory;

    protected $casts = [
        'fecha_revision' => 'date:d/m/Y',
        'created_at' => 'date:d/m/Y',
    ];

    public static function adminAll($id) {
        return DB::select("SELECT va.id, va.aceptada, va.fecha_revision, va.comentario, va.created_at FROM validacion_administrativas AS va WHERE va.producto_id = " . $id . " ORDER BY va.id DESC");
    }

    public static function getComentario($idProducto) {
        return DB::select("SELECT va.aceptada, va.fecha_revision, va.comentario, va.created_at, pfp.nombre_producto FROM validacion_administrativas AS va JOIN proveedores_fichas_productos AS pfp ON va.producto_id = pfp.id WHERE va.producto_id = " . $idProducto . " ORDER BY va.id DESC");
    }
}
