<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AnexosContratoMarco extends Model {
    use HasFactory;
    protected $table = "anexos_contratos_marcos";
    protected $fillable = [
        'contrato_marco_id',
        'nombre_documento',
        'archivo_original',
        'archivo_publico',
        'estatus'
    ];

    public static function allAnexosCM($contratoMarcoId) {
        return  DB::select("SELECT id, nombre_documento, archivo_original, archivo_publico FROM anexos_contratos_marcos WHERE contrato_marco_id = $contratoMarcoId");
    }

    public static function registradosPorContrato($contratoMarcoId) {
        return DB::select("SELECT nombre_documento FROM anexos_contratos_marcos WHERE contrato_marco_id = $contratoMarcoId");
    }
}
