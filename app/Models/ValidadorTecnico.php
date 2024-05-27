<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ValidadorTecnico extends Model
{
    use HasFactory;

    public static function tecnicoAll($id){
        return DB::select("SELECT vt.id, vt.aceptada, vt.fecha_revision, vt.comentario, vt.created_at, fp.nombre_producto FROM validador_tecnicos AS vt JOIN proveedores_fichas_productos AS fp ON vt.producto_id = fp.id WHERE vt.producto_id = " .$id ." ORDER BY vt.id DESC");
    }
}
