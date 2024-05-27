<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;
use App\Models\User;

trait PersonalTrait{
	
	public function personalSeleccionado($request){
		$personas = array('personal' => []);
		if( $request->input('nombre') != null){
			foreach($request->input('nombre') as $key => $nombre){
			    $personas['personal'][$key]['nombre'] = $nombre;
			    $personas['personal'][$key]['rfc'] = $request->input('rfc')[$key];
			    $personas['personal'][$key]['cargo'] = $request->input('cargo')[$key];
			    $personas['personal'][$key]['permiso'] = $request->input('permiso')[$key];
			    $personas['personal'][$key]['seleccionado'] = 0;
			    
			    if( isset($request->input('estatus')[$request->input('rfc')[$key]]) )
			    {
			    	$personas['personal'][$key]['seleccionado'] = 1;
			    }
			}
		}

		return $personas;	
	}

	 public function usuariosSave($personal, $urg){

	 	foreach($personal['personal'] as $user){

	 		if($user['seleccionado']){
		 		$response = Http::get('https://tics.finanzas.cdmx.gob.mx/accesounicotianguis/public/api/users/'.$user['rfc']);
		 		if($response->status() == 200){
		 			$usuario = json_decode($response->body());
		 			User::create([
		 				'rfc' => $usuario[0]->rfc,
		 				'curp' => $usuario[0]->curp,
		 				'nombre' => $usuario[0]->nombre,
		 				'primer_apellido' => $usuario[0]->primer_apellido,
		 				'segundo_apellido' => $usuario[0]->segundo_apellido,
		 				'rol' => $user['permiso'],
		 				'cargo' => $usuario[0]->cargo,
		 				'email' => $usuario[0]->email,
		 				'genero' => $usuario[0]->genero,
		 				'password' => $usuario[0]->password,
		 				'urg_id' => $urg
		 			]);
		 		
		 		}
		 	}
	 	}
	 }
	
}

