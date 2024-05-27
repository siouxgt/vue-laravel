<?php

namespace App\Exports;

use App\Models\BienServicio;
use App\Models\Requisicione;
use App\Traits\ServicesTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;


class RequisicionExport implements FromView, WithStrictNullComparison
{
	use ServicesTrait;

	protected $requisicion;

    public function __construct(string $requisicion)
    {
        $this->requisicion = $requisicion;
    }

	public function view(): View
	{
		$requisicion = Requisicione::find($this->requisicion);
		$requisicion->clave_partida = json_decode($requisicion->clave_partida)->clave_partida;
		$requisicion->monto_disponible = $requisicion->monto_autorizado - ($requisicion->monto_por_confirmar + $requisicion->monto_adjudicado + $requisicion->monto_pagado);
		$bienServicio = BienServicio::where('requisicion_id',$this->requisicion)->get();
		foreach($bienServicio as $key => $value){ 
            $partida = substr($value->cabms,0,4);
            $bienServicio[$key]->descripcion = $this->cabmsDescripcion($partida,$value->cabms);
            $bienServicio[$key]->precio_maximo = $value->precio_maximo;
            $bienServicio[$key]->subtotal = $value->precio_maximo * $value->cantidad;
            $bienServicio[$key]->iva = ($value->precio_maximo * $value->cantidad) *.16;
            $bienServicio[$key]->total = (($value->precio_maximo * $value->cantidad) *.16) + ($value->precio_maximo * $value->cantidad);
        }
		
		return view('export.requisicion', ['requisicion' => $requisicion,'bienServicio' => $bienServicio]);
	}
}