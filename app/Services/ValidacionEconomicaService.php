<?php

namespace App\Services;

use App\Models\HabilitarProducto;
use App\Models\ProveedorFichaProducto;
use App\Models\ValidacionEconomica;
use App\Traits\HashIdTrait;

class ValidacionEconomicaService {
	use HashIdTrait;

	public function validar($id){
		$id = $this->hashDecode($id);
		$fichaProducto = ProveedorFichaProducto::find($id);
		$habilitarProducto = HabilitarProducto::where('cat_producto_id',$fichaProducto->producto_id)->get();
		$valido = false;
		if(is_null($fichaProducto->validacion_precio) or $fichaProducto->validacion_precio == false){
			if($fichaProducto->precio_unitario <= $habilitarProducto[0]->precio_maximo){
				$valido = true;
			}
			$this->store($fichaProducto, $valido);
			$this->updateFichaProducto($fichaProducto->id, $valido);
		}
	}


	public function store($fichaProducto, $valido){
		$intento = ValidacionEconomica::where('producto_id',$fichaProducto->id)->count();

		$economica = new ValidacionEconomica();
		$economica->precio = $fichaProducto->precio_unitario;
		$economica->producto_id = $fichaProducto->id;
		$economica->intento = $intento+1;
		$economica->validado = $valido;
		$economica->save();

	}

	public function updateFichaProducto($fichaProducto,$valido){
		$producto = ProveedorFichaProducto::find($fichaProducto);
		if($valido){
			$producto->validacion_precio = $valido;
		}
		else{
			$producto->validacion_precio = $valido;
			$producto->validacion_administracion = null;
        	$producto->validacion_tecnica = null;
        	$producto->publicado = false;
		}
		$producto->validacion_cuenta += 1;
		$producto->update();
	}
}