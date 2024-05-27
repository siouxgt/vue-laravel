<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AnexosPublica extends Model
{
    use HasFactory;

    public static function anexos($id){
        return DB::select('SELECT id, nombre, archivo_original, archivo_publica, licitacion_publica_id as carpeta  FROM anexos_publicas WHERE licitacion_publica_id = '.$id);
         
    }
}
