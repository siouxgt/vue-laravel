<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ValidacionesTecnicas extends Model
{
    use HasFactory;

    public function catProducto(){
        return $this->hasMany('App\Models\CatProducto');
    }

    public function urg(){
        return $this->belongsTo(Urg::class);
    }

    public static function allValidacion(){
        return DB::select("SELECT vt.id, u.nombre AS entidad, vt.direccion, CASE WHEN vt.estatus = true THEN 'Activo' ELSE 'Inactivo' END AS estatus FROM validaciones_tecnicas AS vt JOIN urgs AS u ON vt.urg_id = u.id");
    }

    public static function allValidaciones($estatus = null)
    {
        if ($estatus != null) { //En esta consulta se obtienen los registros tomando en cuenta si estan activas o no las validaciones
            return DB::select('SELECT vt.id, u.nombre AS entidad, vt.direccion, vt.siglas FROM validaciones_tecnicas AS vt JOIN urgs AS u ON vt.urg_id = u.id WHERE vt.estatus = '.$estatus);
        } else { //Consulta que no tomara en cuenta el estatus del validador tecnico
        }
    }
}
