<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompraBien;
use App\Models\Requisicione;
use App\Models\User;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Yajra\Datatables\Datatables;

class PruebaController extends Controller
{
    use SessionTrait;

    public function login_url(Request $request) {
        $data = $this->openCypher('decrypt',[$request->input('rfc'),$request->input('password'), $request->input('url_acceso_unico')],$request->input('token'));
        $this->crearSession(['acceso_unico' => $data[2],'rfc' => $request->input('rfc'), 'password' => $request->input('password')]);
        return $this->procesar($data[0], $data[1]);
        $response  = Http::post('https://dev.finanzas.cdmx.gob.mx/acceso_unico/public/api/api_encriptacion',[
                'action' => 'decrypt',
                'rfc' => $request->input('rfc'),
                'password' => $request->input('password'), 
                'acceso_unico' => $request->input('url_acceso_unico'),
            ]);
        $body = json_decode($response->body());
        $this->crearSession(['acceso_unico' => $body->acceso_unico,'rfc' => $request->input('rfc'), 'password' => $request->input('password')]);
        if ($response->status() == 200) {

            return $this->procesar($body->rfc, $body->password);
        }
        $this->eliminarSession(['acceso_unico','rfc', 'password']);
        return  redirect($body->acceso_unico . '?rfc=' . $request->input('rfc') . '&password=' . $request->input('password'));
    }


    private function openCypher($action = 'encrypt', $string_array = false, $token = ['',''])
    {
        $output = false;
        $myKey = str_replace(' ', '+', $token[0]);
        $myIV = str_replace(' ', '+', $token[1]);
        $encrypt_method = 'AES-256-CBC';
        $secret_key = hash('sha256', $myKey);
        $secret_iv = substr(hash('sha256', $myIV), 0, 16);
        $outputs = array();
        foreach (!is_array($string_array)?array($string_array):$string_array as $key => $string) {
            $string = str_replace(' ', '+', $string);
            $string = $action==='decrypt'?str_replace('_', '/', $string):$string;
            if ($action && ($action == 'encrypt' || $action == 'decrypt') && $string) {
                $string = trim(strval($string));
                if ($action == 'decrypt') {
                    $output = openssl_decrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
                }
                 $outputs[$key] = $action==='encrypt'?str_replace('/', '_', $output):$output;
            }
        }
        return $outputs;
    }

    private function procesar($rfc, $password){
            //busca al usuario
            $userlogin = User::where('rfc', $rfc)->first();
            Auth::loginUsingId($userlogin->id);
            if(auth()->user()->rol_id == 1){
                $ruta = redirect()->route('index');
            }
            if(auth()->user()->rol_id == 4){
                $ruta = redirect()->route('tienda_urg.index');
            }
            if(auth()->user()->rol_id == 6){
                $ruta = redirect()->route('validador_tecnico.index');
            }
            if(auth()->user()->rol_id == 7){
                $ruta = redirect()->route('firmante.index');
            }
                 
            return $ruta;
        }

    public function logout(){
        $accesoUnico = session()->get('acceso_unico') . '?rfc=' . session()->get('rfc') . '&password=' . session()->get('password');
        session()->flush();
        return  redirect($accesoUnico);
    }

}