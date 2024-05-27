<?php

namespace App\Http\Controllers;

use App\Models\CatProducto;
use App\Models\ContratoMarco;
use App\Models\Mensaje;
use App\Models\Proveedor;
use App\Models\ProveedorFichaProducto;
use App\Models\Urg;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class UrgGeneralController extends Controller
{
    use HashIdTrait;

    function mensajesUrg()
    {
        $layout = 'layouts.urg';
        $sinLeer = Mensaje::countUserSinLeer(auth()->user()->id);

        return view('mensajes-user.mensaje')->with(['layout' => $layout, 'sinLeer' => $sinLeer]);
    }

    public function dataMensajes($id){
        switch ($id) {
            case 1: //mensajes
                $mensajes = $this->hashEncode(Mensaje::mensajesUser(auth()->user()->id));
                break;
            case 2: //todos 
                $mensajes = $this->hashEncode(Mensaje::mensajesUserAll(auth()->user()->id));
                break;
            case 3: //enviados
                $mensajes = $this->hashEncode(Mensaje::mensajesEnviados(auth()->user()->id));
                break;
            case 4://archivados
                $mensajes = $this->hashEncode(Mensaje::mensajesUserArchivado(auth()->user()->id));
                break;
            case 5://eliminados
                $mensajes = $this->hashEncode(Mensaje::mensajesUSerEliminado(auth()->user()->id));
                break;
            case 6://destacados
                $mensajes = $this->hashEncode(Mensaje::mensajesUserDestacados(auth()->user()->id));
                break;
            case 7://no leidos
                $mensajes = $this->hashEncode(Mensaje::mensajesUserNoLeidos(auth()->user()->id));
                break;
        }
        
        
        return Datatables::of($mensajes)->toJson();
    }

    public function destacarMensaje(Request $request){
        try {
            foreach($request->ids as $id){
                $mensaje = Mensaje::find($this->hashDecode($id));
                $mensaje->destacado = 1;
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => "Mensaje destacado."];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido destacado."];
        }
        return $response;
    }

    public function archivarMensaje(Request $request){
         try {
            foreach($request->ids as $id){
                $mensaje = Mensaje::find($this->hashDecode($id));
                $mensaje->archivado = 1;
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => "Mensaje archivado."];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido archivar."];
        }
        return $response;
    }

    public function eliminarMensaje(Request $request){
        try {
            foreach($request->ids as $id){
                $mensaje = Mensaje::find($this->hashDecode($id));
                $mensaje->eliminado = 1;
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => "Mensaje eliminado."];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido eliminar."];
        }
        return $response;
    }

    public function leido(Request $request){
        try {
            $mensaje = Mensaje::find($this->hashDecode($request->input('id')));
            $mensaje->leido = 1;
            $mensaje->update();

            $response = ['success' => true];            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido actualizar."];
        }

        return $response;
    }

    public function responderModal($id){
        $mensaje =  $this->hashEncode(Mensaje::mensaje($this->hashDecode($id)));
        return view('admin.modals.responder_mensaje_modal')->with(['mensaje' => $mensaje[0]]);
    }

    public function responderSave(Request $request){
        try {
            $mensaje = Mensaje::find($this->hashDecode($request->input('mensaje')));
            $mensaje->respuesta = $request->input('respuesta');
            $mensaje->leido = 1;
            $mensaje->update();

            $response = ['success' => true, 'message' => 'Mensaje respondido.'];            

        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al responder el mensaje.'];
        }
        return $response;
    }
}