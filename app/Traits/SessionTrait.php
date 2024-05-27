<?php

namespace App\Traits;


trait SessionTrait{
	
	public function crearSession($arreglo){
		foreach($arreglo as $key => $value){
			session([$key=>$value]);
		}
	}

	public function eliminarSession($arreglo){
		foreach($arreglo as $value){
			if(session()->exists($value)){
				session()->forget($value);
			}
		}
	}	
}

