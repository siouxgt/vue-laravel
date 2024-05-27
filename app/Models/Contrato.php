<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_inicio' => 'date:d/m/Y',
        'fecha_fin' => 'date:d/m/Y',
        'fecha_fallo' => 'date:d/m/Y',
        'fecha_entrega' => 'date:d/m/Y',
        'fecha_constitucion_identidad' => 'date:d/m/Y',
        'fecha_reg_identidad' => 'date:d/m/Y',
        'fecha_reg_representante' => 'date:d/m/Y',
        'fecha_contrato_marco' => 'date:d/m/Y',
        'created_at' => 'date:d/m/Y',
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function urg(){
        return $this->belongsTo(Urg::class);
    }

    public function requisiciones(){
        return $this->belongsTo(Requisicione::class, 'requisicion_id');
    }

    public static function ultimo()
    {
        return DB::select("SELECT id FROM contratos ORDER BY id DESC LIMIT 1");
    }

    public static function allFirmante($rfc){
        return DB::select("SELECT c.id, c.contrato_pedido, c.orden_compra, c.nombre_proveedor, ocf.identificador, c.created_at, TO_CHAR(c.created_at, 'DD/MM/YYYY') AS s_fecha, c.updated_at, ocf.sello FROM contratos AS c JOIN orden_compra_firmas as ocf ON ocf.contrato_id = c.id WHERE ocf.rfc = '$rfc'");
    }

    public static function allFirmantePorProveedor($rfc){
        return DB::select("SELECT c.id, c.orden_compra, c.contrato_pedido, to_char(c.created_at, 'DD/MM/YYYY') AS fecha_alta_contrato, u.nombre AS urg, c.contrato_pedido AS archivo_contrato FROM contratos AS c JOIN urgs AS u ON c.urg_id = u.id WHERE c.rfc_proveedor = '$rfc'");
    }

    public static function firmados($rfc){
        return DB::select('SELECT c.id, ocf.sello FROM contratos AS c JOIN orden_compra_firmas as ocf ON ocf.contrato_id = c.id WHERE ocf.sello IS NOT NULL AND ocf.rfc = \''.$rfc.'\'');
    }
}
