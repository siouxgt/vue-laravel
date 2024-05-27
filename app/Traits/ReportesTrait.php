<?php

namespace App\Traits;

use App\Models\Reporte;
use App\Traits\HashIdTrait;

trait ReportesTrait
{
    use HashIdTrait;

    public function reporteStore($request, $etapa, $reporta)
    { //Guardar/generar reporte
        Reporte::create([
            'id_reporte' => str_replace('-', '', session()->get('ordenCompraReqId')) . "R" . date('dmY'),
            'motivo' => $request->input('motivo'),
            'descripcion' => $request->input('descripcion'),
            'etapa' => $etapa,
            'reporta' => $reporta,
            'urg_id' => session()->get('urgId'),
            'orden_compra_id' => $this->hashDecode(session()->get('ordenCompraId')),
            'proveedor_id' => session()->get('proveedorId'),
        ]);
    }
}
