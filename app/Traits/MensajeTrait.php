<?php

namespace App\Traits;

use App\Models\Mensaje;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait MensajeTrait{

	public function storeManual($request, $data){
		try {
			$mensaje = new Mensaje();
			$mensaje->asunto = $request->input('asunto'); 
			$mensaje->mensaje = $request->input('mensaje');
			$mensaje->remitente = $data['remitente'];
			$mensaje->receptor = $data['receptor'];
			$mensaje->tipo_remitente = $data['tipo_remitente'];
			$mensaje->tipo_receptor = $data['tipo_receptor'];
			$mensaje->origen = $data['origen'];
			if($request->file('imagen')){
	            $nombre = time() . $request->file('imagen')->getClientOriginalName(); 
	            Storage::disk('img_mensaje')->put($nombre, File::get($request->file('imagen')));
	            $mensaje->imagen = $nombre; 
	        }
	        if(isset($data['producto'])){	    
	        	$mensaje->producto = $data['producto'];
	        }
	        if(isset($data['orden_compra'])){
	        	$mensaje->orden_compra = $data['orden_compra'];
	        }
			$mensaje->save();
			
			$response = ['success' => true, 'message' => 'Mensaje enviado.'];
			
		} catch (\Exception $e) {
			$response = ['success' => false, 'message' => 'Error al mandar el mensaje.'];
		}
		return $response;
	}

	public function storeAuto($data){
		$mensaje = new Mensaje();
		$mensaje->asunto = $data['asunto']; 
		$mensaje->mensaje = $data['mensaje'];
		$mensaje->remitente = $data['remitente'];
		$mensaje->receptor = $data['receptor'];
		$mensaje->tipo_remitente = $data['tipo_remitente'];
		$mensaje->tipo_receptor = $data['tipo_receptor'];
		$mensaje->origen = $data['origen'];
		if(isset($data['producto'])){	    
	       	$mensaje->producto = $data['producto'];
	    }
	    if(isset($data['orden_compra'])){
	       	$mensaje->orden_compra = $data['orden_compra'];
	    }
		$mensaje->save();

	}

}

