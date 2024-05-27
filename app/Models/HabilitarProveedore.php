<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HabilitarProveedore extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'fecha_adhesion' => 'date:d/m/Y',
    ];

    public static function todos($contrato){
        return DB::select("SELECT hp.id, hp.archivo_adhesion, hp.habilitado, hp.proveedor_id, TO_CHAR(hp.fecha_adhesion, 'DD/MM/YYYY') AS fecha_adhesion, p.rfc, p.perfil_completo, e.num_procedimiento FROM habilitar_proveedores AS hp  JOIN proveedores AS p ON hp.proveedor_id = p.id JOIN expedientes_contratos_marcos AS e ON hp.expediente_id = e.id WHERE hp.contrato_id =".$contrato." AND e.liberado = true");
    }

    public static function proveedor($id){
        return DB::select('SELECT p.rfc, e.num_procedimiento, hp.fecha_adhesion, hp.archivo_adhesion, p.perfil_completo, hp.habilitado FROM habilitar_proveedores AS hp JOIN proveedores AS p ON hp.proveedor_id = p.id JOIN expedientes_contratos_marcos AS e ON hp.expediente_id = e.id WHERE hp.proveedor_id ='.$id);
    }

    public static function fechaFallo($proveedorId, $contratoMarcoId){
        return DB::select('SELECT hp.id, hp.fecha_adhesion, cm.created_at FROM habilitar_proveedores AS hp JOIN contratos_marcos AS cm ON hp.contrato_id = cm.id  WHERE hp.proveedor_id = '.$proveedorId.' AND hp.contrato_id = '.$contratoMarcoId.' AND hp.fecha_adhesion IS NOT NULL ORDER BY hp.id DESC LIMIT 1');
    }

    public static function comboOrigenCmPro($proveedor_id){
        return DB::select("SELECT DISTINCT(cm.numero_cm) AS origen FROM habilitar_proveedores AS hp JOIN contratos_marcos AS cm ON hp.contrato_id = cm.id WHERE cm.liberado = true AND EXTRACT(DAYS FROM (CAST(cm.f_fin AS TIMESTAMP) - CAST(CURRENT_DATE AS TIMESTAMP))) > 1 AND hp.habilitado = true AND hp.proveedor_id = ".$proveedor_id);
    }

}
