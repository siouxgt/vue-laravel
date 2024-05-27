<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProveedorComentario extends Model
{
    use HasFactory;

    public static function todosComentarios($urgId)
    {
        return DB::select("SELECT pc.comentario, to_char( pc.created_at, 'DD/MM/YYYY' ) AS fecha, p.nombre FROM proveedor_comentarios pc JOIN proveedores AS p ON p.id = pc.proveedor_id WHERE urg_id = $urgId");
    }
}
