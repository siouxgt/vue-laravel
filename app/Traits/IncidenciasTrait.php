<?php

namespace App\Traits;

use App\Models\Incidencia;
use App\Traits\HashIdTrait;

trait IncidenciasTrait
{
    use HashIdTrait;

    public function incidenciaStore($request, $etapa, $reporta)
    { //Guardar/generar incidencia
        Incidencia::create([
            'id_incidencia' => str_replace('-', '', session()->get('ordenCompraReqId')) . "I" . date('dmY'),
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
