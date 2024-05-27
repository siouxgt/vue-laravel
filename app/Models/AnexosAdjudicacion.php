<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AnexosAdjudicacion extends Model
{
    use HasFactory;

    public static function anexos($id){
    	return DB::select('SELECT id, nombre, archivo_original, archivo_publica, adjudicacion_directa_id as carpeta  FROM anexos_adjudicacions WHERE adjudicacion_directa_id = '.$id);
    	 
    }
}
