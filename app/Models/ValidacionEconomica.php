<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ValidacionEconomica extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:d/m/Y',
   ];

   public static function economicaAll($id){
    return DB::select("SELECT ve.id, ve.intento, ve.validado, ve.created_at, fp.nombre_producto FROM validacion_economicas AS ve JOIN proveedores_fichas_productos AS fp ON ve.producto_id = fp.id WHERE ve.producto_id = " .$id ." ORDER BY ve.id DESC");
   }
}
