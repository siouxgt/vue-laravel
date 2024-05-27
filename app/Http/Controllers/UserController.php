<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Urg;
use App\Models\User;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    use HashIdTrait;

    public function apiStore(Request $request){
    	try {
            $response  = Http::post('https://dev.finanzas.cdmx.gob.mx/acceso_unico/public/api/api_encriptacion',[
                'action' => 'decrypt',
                'rfc' => $request->input('rfc'),
                'curp' => $request->input('curp'),
                'nombre' => $request->input('nombre'),
                'primer_apellido' => $request->input('primer_apellido'),
                'segundo_apellido' => $request->input('segundo_apellido'),
                'cargo' => $request->input('cargo'),
                'email' => $request->input('email'),
                'genero' => $request->input('genero'),
                'password' => $request->input('password'),
                'telefono' => $request->input('telefono'),
                'extension' => $request->input('extension'),
                'rol_id' => $request->input('rol_id'),
                'urg_id' => $request->input('urg_id')
            ]);
            $aux = json_decode($response->body());
            
    		$user = new User;
    		$user->rfc = $aux->rfc;
    		$user->curp = $aux->curp;
    		$user->nombre = $aux->nombre;
    		$user->primer_apellido = $aux->primer_apellido;
    		$user->segundo_apellido = $aux->segundo_apellido;
    		$user->cargo = $aux->cargo;
    		$user->email = $aux->email;
    		$user->genero = $aux->genero;
    		$user->password = $aux->password;
    		$user->telefono = $aux->telefono;
    		$user->extension = $aux->extension;
    		$user->rol_id = $aux->rol_id;
    		$user->urg_id = $aux->urg_id;
    		$user->save();

            $response = ['success' => true, 'code' => 200, 'message' => 'Usuario registrado con exito.'];
    		
    	} catch (\Exception $e) {
    		$response = ['success' => false, 'code' => 200, 'message' => 'Usuario no registrado.'];
    	}
    	return $response;
    }

    public function apiUpdate(Request $request, $rfc){
        $response  = Http::post('https://dev.finanzas.cdmx.gob.mx/acceso_unico/public/api/api_encriptacion',[
                'action' => 'decrypt',
                'rfc' => $rfc,
                'password' => $request->input('password'),
                'rol_id' => $request->input('rol_id'),
                'urg_id' => $request->input('urg_id')
            ]);
        $response = json_decode($response->body());
    	try {
    		$aux = User::where('rfc',$response->rfc)->get();
    		if($aux != '[]'){
    			$user = User::find($aux[0]->id);
    			$user->password = $response->password;
                if($response->rol_id != "" && $response->urg_id != ""){
                    $user->rol_id = $response->rol_id;
                    $user->urg_id = $response->urg_id;
                }
    			$user->update();
                $response = ['success' => true, 'code' => 200, 'message' => 'Usuario actualizado con exito.'];
    		}else{ 
                $response = ['success' => false, 'code' => 200, 'message' => 'Usuario no encontrado.'];
            }
    	} catch (\Exception $e) {
    		$response = ['success' => false, 'code' => 200, 'message' => 'Usuario no actualizado.'];
    	}
    	return $response;
    }

    public function openCypher($string){
        $myKey = str_replace(' ', '+', "rH%y56+dt9");
        $myIV = str_replace(' ', '+', "B(1!u793u^");
        $encrypt_method = 'AES-256-CBC';
        $secret_key = hash('sha256', $myKey);
        $secret_iv = substr(hash('sha256', $myIV), 0, 16);
        $string = str_replace(' ', '+', $string);
        $string = str_replace('_', '/', $string);
        $output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);

        return $output;
    }

    public function index(){
        return view('admin.usuarios.index');
    }

    public function show($id){

        $id = $this->hashDecode($id);
        $usuario = User::find($id);

        return view('admin.usuarios.show')->with(['usuario' => $usuario]);
    }

    public function edit($id){
        $id = $this->hashDecode($id);
        $usuario = $this->hashEncode(User::find($id));

        $roles = $this->hashEncode(Rol::all());
        $urgs = $this->hashEncode(Urg::all());

        return view('admin.usuarios.modal_edit')->with(['usuario' => $usuario, 'roles' => $roles, 'urgs' => $urgs]);
    }

    public function update(Request $request, $id){
        $id = $this->hashDecode($id);
        try {
            $usuario = User::find($id);
            $usuario->estatus = $request->input('estatus')? 1 : 0;
            $usuario->email = $request->input('email');
            $usuario->telefono = $request->input('telefono');
            $usuario->extension = $request->input('extension');
            $usuario->rol_id = $this->hashDecode($request->input('rol'));
            $usuario->urg_id = $this->hashDecode($request->input('urg'));
            $usuario->update();
            $response = array('success' => true, 'message' => 'Usuario actualizado correctamente.');
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al actualizar el usuario.'];    
        }
        return $response;
    }

    public function destroy($id){
        
    }

    public function data(){
        $usuarios = $this->hashEncode(User::allUsuarios());
        
        return Datatables::of($usuarios)->toJson();
    }
}
