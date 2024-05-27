<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Requisicione extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function urg(){
        return $this->belongsTo(Urg::class);
    }

    public function carritoCompra(){
        return $this->hasMany(CarritoCompra::class,'requisicion_id');
    }

    public function ordenCompra(){
        return $this->hasMany(OrdenCompra::class, 'requisicion_id');
    }

    public function contratos(){
        return $this->hasMany(Contrato::class, 'requisicion_id');
    }

    public static function comprobarBienServicio($id, $cabms)
    { //Función que permite comprobar si el producto que ha seleccionado la URG pertenece a un bien servicio de alguna requisición (devuleve una cantidad)
        $sql = "SELECT CASE WHEN count(bs.id) > 0 THEN true ELSE false END AS existe
                    FROM bien_servicios AS bs 
                    JOIN requisiciones AS req ON bs.requisicion_id = req.id
                    WHERE req.urg_id = $id AND bs.cotizado = true
                    AND bs.cabms = '$cabms'";

        return DB::select($sql);
    }

    public static function obtenerRequisicionObjeto($id,$cabms)
    {
        $sql = "SELECT req.id, req.requisicion, req.objeto_requisicion
                    FROM bien_servicios AS bs 
                    JOIN requisiciones AS req ON bs.requisicion_id = req.id
                    WHERE req.urg_id = $id AND bs.cotizado = true AND bs.cabms = '$cabms'
                    GROUP BY(req.id)";

        return DB::select($sql);
    }

    public static function allRequisicion($urg)
    {
        return DB::select('SELECT r.id, r.requisicion, r.objeto_requisicion, r.monto_autorizado, r.monto_adjudicado, r.estatus,  (SELECT count(b.*) FROM bien_servicios AS b WHERE b.cotizado = true AND b.requisicion_id = r.id) AS cotizada FROM requisiciones AS r WHERE r.urg_id = ' . $urg);
    }

    public static function  contador($urg){
        return DB::select('SELECT (SELECT COUNT(*) FROM requisiciones WHERE estatus = false AND urg_id = '.$urg.') AS disponible, (SELECT COUNT(*) FROM requisiciones WHERE estatus = true AND urg_id = '.$urg.') AS adjudicada');
    }

    public static function cotizado($urg)
    {
        return DB::select('SELECT count(b.*) AS cotizados FROM bien_servicios AS b WHERE b.cotizado = true AND b.requisicion_id = ' . $urg);
    }

    public static function registradas($urg){
        return DB::select('SELECT r.requisicion FROM requisiciones AS r WHERE r.urg_id = ' . $urg);
    }
}
