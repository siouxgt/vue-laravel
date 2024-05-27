<?php

namespace App\Models;

use App\Models\AdjudicacionDirecta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpedienteContratoMarco extends Model
{
    use HasFactory;
    protected $table = "expedientes_contratos_marcos";
    protected $fillable = [
        'f_creacion',
        'metodo',
        'num_procedimiento'
    ];

    protected $casts = [
        'f_creacion' => 'date:d/m/Y',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id_creo');
    }

    public static function fecha($id, $metodo){
        switch ($metodo) {
            case 'Convocatoria Directa Contrato Marco':
                $aux = DB::select("SELECT created_at, updated_at FROM adjudicacion_directas WHERE expediente_id = ".$id);
            break;
            case 'Convocatoria Restringida Contrato Marco':
               $aux = DB::select("SELECT created_at, updated_at FROM invitacion_restringidas WHERE expediente_id = ".$id);
            break;
            case 'Convocatoria Pública Contrato Marco':
                $aux = DB::select("SELECT created_at, updated_at FROM licitacion_publicas WHERE expediente_id = ".$id);
            break;
        }

        if($aux == []){
            $aux = DB::select("SELECT created_at, updated_at FROM expedientes_contratos_marcos WHERE id = ".$id);
        }
        
        return $fecha = [Carbon::parse($aux[0]->created_at), Carbon::parse($aux[0]->updated_at)];
    }

    public static function expediente($id,$tipo){
                
        return DB::select("SELECT ecm.id, ecm.metodo, ecm.imagen, ecm.num_procedimiento, ecm.liberado, ecm.porcentaje, ecm.created_at, ecm.updated_at FROM expedientes_contratos_marcos AS ecm WHERE ecm.metodo = '".$tipo."' AND ecm.contrato_id = ".$id." ORDER BY ecm.id DESC");
    }

}
