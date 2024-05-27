<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContratoMarcoUrg extends Model
{
    use HasFactory;

    protected $table = "contratos_marcos_urgs";
    protected $fillable = [
        'urg_id',
        'contrato_marco_id',
        'fecha_firma',
        'a_terminos_especificos',
        'estatus'
    ];

    public function contratos(){
        return $this->belongsTo(ContratoMarco::class,'contrato_marco_id');
    }

    public static function allCMU($id_cm)
    {
        return  DB::select("SELECT cmu.id AS id_cmu, u.id, u.ccg, u.nombre, TO_CHAR(cmu.fecha_firma, 'DD/MM/YYYY') AS fecha_firma, cmu.a_terminos_especificos, cmu.estatus 
                        FROM contratos_marcos_urgs as cmu
                        JOIN urgs as u ON cmu.urg_id = u.id
                        JOIN contratos_marcos as cm ON cmu.contrato_marco_id = cm.id
                        WHERE cm.id = $id_cm"); //Mejorar con Inner más adelante
    }

    public static function buscarContratosM($id)
    {
        return DB::select("SELECT DISTINCT(cm.id), cm.numero_cm, cm.nombre_cm FROM contratos_marcos AS cm
                    JOIN contratos_marcos_urgs AS cmu ON cm.id = cmu.contrato_marco_id
                    WHERE cmu.urg_id = $id AND cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1");
    }

    public static function comboOrigenCmUrg($urg_id){
        return DB::select("SELECT cm.numero_cm AS origen FROM contratos_marcos_urgs AS cmu JOIN contratos_marcos AS cm ON cmu.contrato_marco_id = cm.id WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND cmu.estatus = true AND cmu.urg_id = ".$urg_id);
    }
}
