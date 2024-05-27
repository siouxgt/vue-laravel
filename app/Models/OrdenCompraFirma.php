<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompraFirma extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_firma' => 'date:d/m/Y',
    ];

    public static function firmantes($contrato_id){
        return DB::select('SELECT ocf.nombre, ocf.primer_apellido, ocf.segundo_apellido, ocf.puesto, ocf.sello, ocf.folio_consulta, ocf.identificador FROM orden_compra_firmas AS ocf WHERE ocf.contrato_id = '.$contrato_id);
    }

    public static function firmas($contrato_id){
        return DB::select('SELECT ocf.identificador FROM orden_compra_firmas AS ocf WHERE ocf.sello IS NOT NULL AND ocf.contrato_id = '.$contrato_id);   
    }

    public static function totalFirmados($contrato_id){
        return DB::select("SELECT
                            (SELECT COUNT(id) AS total_firmantes FROM orden_compra_firmas WHERE contrato_id = $contrato_id),
                            (SELECT COUNT(id) AS total_firmados FROM orden_compra_firmas WHERE sello IS NOT NULL AND contrato_id = $contrato_id)");
    }
}
