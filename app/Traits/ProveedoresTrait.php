<?php

namespace App\Traits;

use App\Models\HabilitarProveedore;
use App\Models\Proveedor;
use App\Traits\hashDecode;
use Illuminate\Support\Facades\Storage;


trait ProveedoresTrait{
	
	
	public function proveedoresJson($request){

		foreach($request->input('rfc') as $key => $rfc){
            $proveedores['proveedores'][$key]['rfc'] = $rfc;
            
            if(isset($request->input('estatus')[$key])){
                $proveedores['proveedores'][$key]['seleccionado'] = $request->input('estatus')[$key];
            }
            else{
                $proveedores['proveedores'][$key]['seleccionado'] = 0;
            }
        }
        
		return $proveedores;  
	}

	public function proveedoresJson_($request){
		
		foreach($request->input('_rfc') as $key1 => $rfc){
            $proveedores['proveedores'][$key1]['rfc'] = $rfc;
	        $proveedores['proveedores'][$key1]['seleccionado'] = 0;
            if($request->input('_estatus')){
                foreach($request->input('_estatus') as $key2 => $estatus){
               		 if($key2 == $rfc){
                    	$proveedores['proveedores'][$key1]['seleccionado'] = 1;
                    	break;
    	            }
                }
            }
        }

		return $proveedores;  
	}

	public function proveedoresSeleccionados($proveedores){
		$proveedoresActivados['proveedores'] = [];
        $cont = 0;
		foreach ($proveedores['proveedores'] as $key => $value) {
            if($value['seleccionado'] == 1){
                $proveedoresActivados['proveedores'][$cont]['rfc'] = $value['rfc'];
            $cont++;
            }
        }
        return $proveedoresActivados;
	}

    public function proveedoresSeleccionadosObjeto($proveedores){
        $cont = 0;
        $proveedoresSeleccionados = [];
        foreach ($proveedores as $key => $value) {
            if($value->seleccionado == 1){
                $value->seleccionado = 0;
                $proveedoresSeleccionados[$cont] = $proveedores[$key];
                $cont++;
            }
        }
        
        return $proveedoresSeleccionados;
    }

    public function proveedoresEdit($proveedores){
        foreach ($proveedores as $key => $value) {
            $proveedores[$key]->seleccionado = 0;
        }
        
        return $proveedores;
    }

    public function proveedoresCalificados($proveedores){
    	$proveedoresCalificados['proveedores'] = [];
		foreach ($proveedores['proveedores'] as $key => $value) {
            if($value['seleccionado'] == 0){
                $proveedoresCalificados['proveedores'][$key]['rfc'] = $value['rfc'];
            }
        }
        
        return $proveedoresCalificados;
    }

    public function proveedoresCalificadosObjeto($proveedores){
        $cont = 0;
        $proveedoresCalificados = [];
        foreach ($proveedores as $key => $value) {
            if($value->seleccionado == 0){
                $proveedoresCalificados[$cont] = $proveedores[$key];
                $cont++;
            }
        }
        
        return $proveedoresCalificados;
    }

    public function proveedoresComparacion($proveedor1, $proveedor2){
        $count = 0;
        foreach ($proveedor1 as $key1 => $value1) {
            if($value1->seleccionado == 1){
                foreach ($proveedor2 as $key2 => $value2) {
                    $value1->seleccionado = 0;
                    $proveedorSiguiente['proveedores'][$count]['rfc'] = $value1->rfc;
                    $proveedorSiguiente['proveedores'][$count]['seleccionado'] = $value1->seleccionado; 
                    if($value1->rfc == $value2->rfc){
                        if($value2->seleccionado == 1){
                            $proveedorSiguiente['proveedores'][$count]['seleccionado'] = 1;    
                            break;
                        }
                    }
                }
                $count++;
            }
        }
        
        return $proveedorSiguiente;
    }

    public function habilitarProveedor($proveedorAdjudicado, $expediente){
        $proveedores = Proveedor::all();
        $contratoId = $this->hashDecode(session('contrato'));
        foreach($proveedores as $proveedor){
            foreach($proveedorAdjudicado['proveedores'] as $value){
                if($value['seleccionado'] == 1){
                    if($proveedor->rfc  ==  $value['rfc']){
                        $proveedorHabilitado = HabilitarProveedore::select('id')->where('expediente_id',$expediente)->where('proveedor_id',$proveedor->id)->first();
                        if(empty($proveedorHabilitado->id)){
                            HabilitarProveedore::create([
                                'proveedor_id' => $proveedor->id,
                                'expediente_id' => $expediente,
                                'contrato_id' => $contratoId
                            ]);
                        }
                    }
                }
                else{
                    if($proveedor->rfc  ==  $value['rfc']){
                        $proveedorHabilitado = HabilitarProveedore::where('expediente_id',$expediente)->where('proveedor_id',$proveedor->id)->first();
                        if(!empty($proveedorHabilitado)){
                            if(Storage::disk('contrato_adhesion')->exists($proveedorHabilitado->archivo_adhesion)){
                                Storage::disk('contrato_adhesion')->delete($proveedorHabilitado->archivo_adhesion);
                            }
                            $proveedorHabilitado->delete();
                        }
                    }
                }
            }
        }
    }

    public function crearSession($idProveedor){
        session(['idProveedor' => $idProveedor]);		
	}

	public function eliminarSession(){
		if(session()->exists('idProveedor')){
            session()->forget('idProveedor');            
        }
	}

}