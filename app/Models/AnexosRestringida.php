<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AnexosRestringida extends Model
{
    use HasFactory;

    public static function anexos($id){
        return DB::select('SELECT id, nombre, archivo_original, archivo_publica, invitacion_restringida_id as carpeta FROM anexos_restringidas WHERE invitacion_restringida_id = '.$id);
    }
}
