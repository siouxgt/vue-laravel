<?php

namespace App\Traits;

use Hashids\Hashids;

trait HashIdTrait{
	
	public function hash()
	{
		return new Hashids('', 8,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
	}

	public function hashEncode($objetos){
		if(isset($objetos->id)){
			$objetos->id_e = $this->hash()->encode($objetos->id);
		}
		else{
			foreach($objetos as $key => $objeto)
			{
				$objetos[$key]->id_e = $this->hash()->encode($objeto->id);
			}
			
		}
		
		return $objetos;  
	}

	public function hashDecode($id_hast){

		$id = $this->hash()->decode($id_hast);

		return implode("",$id);
	}

	public function hashEncodeId($arreglo,$clave){
		if(isset($arreglo->$clave)){
			$arreglo->$clave = $this->hash()->encode($arreglo->$clave);
		}
		else{
			foreach($arreglo as $key => $value){
				$arreglo[$key]->$clave = $this->hash()->encode($value->$clave);
			}
		}
		
		return $arreglo;
	}

	public function hashEncodeIdClave($arreglo,$clave,$nuevaClave){
		if(isset($arreglo->$clave)){
			$arreglo->$nuevaClave = $this->hash()->encode($arreglo->$clave);
		}
		else{
			foreach($arreglo as $key => $value){
				$arreglo[$key]->$nuevaClave = $this->hash()->encode($value->$clave);
			}
		}
		
		return $arreglo;
	}
}

