<?php

namespace App\Traits;

use App\Models\ContratoMarco;
use App\Models\Submenu;
use Carbon\Carbon;


trait ContratoTrait{

	public function porcentajeContrato($porcentaje,$contratoId){
		$cm = ContratoMarco::find($contratoId);
        $cm->porcentaje += $porcentaje;
        $cm->update(); 
	}
	
	public function fechasContrato($contratoId){
		return Submenu::where('contrato_id',$contratoId)->first();
	}

	public function seccionTerminada($seccion,$contratoId)
	{
		$submenuId = Submenu::select('id')->where('contrato_id',$contratoId)->first();
		$submenu = Submenu::find($submenuId->id);
		$submenu->$seccion = true;
		$submenu->update();
	}

	public function fechasDiff($contratos){
		foreach($contratos as $key => $contrato) {
			$contrato->created_at = Carbon::parse($contrato->created_at)->diffInDays(now());
			$contrato->updated_at = Carbon::parse($contrato->updated_at)->diffForHumans(now());
		}
		return $contratos;
	}
}

