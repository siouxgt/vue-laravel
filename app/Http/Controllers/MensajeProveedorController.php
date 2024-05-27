<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Traits\HashIdTrait;

class MensajeProveedorController extends Controller {

    use HashIdTrait;

    public function __construct() {
        $this->middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia', 'perfilActivo']);
    }

    public function proveedorId() {
        return Auth::guard('proveedor')->user()->id;
    }

    public function index() {
        return view('proveedores.mensajes.index')->with(['sinLeer' => Mensaje::countProveedorSinLeer($this->proveedorId())[0]]);
    }

    public function edit($id) {
        $mensaje = $this->hashEncode(Mensaje::getMensajeProveedor($this->hashDecode($id)));
        return view('proveedores.mensajes.modals.responder')->with(['mensaje' => $mensaje[0]]);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make(
            $request->all(),
            [
                'respuesta' => "required|max:1000",
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $mensaje = Mensaje::find($this->hashDecode($id));
            $mensaje->respuesta = $request->input('respuesta');
            $mensaje->leido = true;
            $mensaje->update();

            return response()->json(['status' => 200, 'mensaje' => 'Respuesta enviada correctamente.',]);
        }
    }

    public function destacar(Request $request) {
        try {
            foreach ($request->ids as $id) {
                $mensaje = Mensaje::find($this->hashDecode($id));
                // dd($mensaje->tipo_remitente);
                if ($mensaje->tipo_remitente == 2) { //Destacar mensaje del propio remitente (proveedor = 2)
                    $mensaje->destacado_remitente = ($mensaje->destacado_remitente) ? false : true;
                } else {
                    $mensaje->destacado = ($mensaje->destacado) ? false : true;
                }
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => $this->formularMensaje(1, count($request->ids), $mensaje)];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se ha podido destacar."];
        }
        return $response;
    }

    public function archivar(Request $request) {
        try {
            foreach ($request->ids as $id) {
                $mensaje = Mensaje::find($this->hashDecode($id));

                if ($mensaje->tipo_remitente == 2) { //Archivar mensaje del propio remitente (proveedor = 2)
                    if (!$mensaje->eliminado_remitente) {
                        $mensaje->archivado_remitente = ($mensaje->archivado_remitente) ? false : true;
                    } else {
                        $response = ['success' => false, 'message' => "El mensaje no se puede archivar."];
                    }
                } else {
                    if (!$mensaje->eliminado) { //Comprobando que el mensaje a archivar no este eliminado (los eliminados no se pueden archivar)
                        $mensaje->archivado = ($mensaje->archivado) ? false : true;
                    } else {
                        $response = ['success' => false, 'message' => "El mensaje no se puede archivar."];
                    }
                }
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => $this->formularMensaje(2, count($request->ids), $mensaje)];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se ha podido archivar."];
        }
        return $response;
    }

    public function borrar(Request $request) {
        try {
            foreach ($request->ids as $id) {
                $mensaje = Mensaje::find($this->hashDecode($id));
                if ($mensaje->tipo_remitente == 2) { //Archivar mensaje del propio remitente (proveedor = 2)
                    if ($mensaje->archivado_remitente) $mensaje->archivado_remitente = false; // Si esta archivado se desarchiva                    
                    $mensaje->eliminado_remitente = ($mensaje->eliminado_remitente) ? false : true;
                } else {
                    if ($mensaje->archivado) $mensaje->archivado = false; // Si esta archivado se desarchiva                    
                    $mensaje->eliminado = ($mensaje->eliminado) ? false : true;
                }
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => $this->formularMensaje(3, count($request->ids), $mensaje)];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se ha podido eliminar."];
        }
        return $response;
    }

    private function formularMensaje($quien, $cantidad, $mensaje) {
        if ($cantidad > 1) {
            if ($quien == 1) return 'Mensajes destacados y/o no destacados correctamente';
            if ($quien == 2) return 'Mensajes archivados y/o desarchivados correctamente';
            if ($quien == 3) return 'Mensajes eliminados y/o recuperados correctamente';
        } else { //Unitario            
            if ($mensaje->tipo_remitente == 2) {
                if ($quien == 1) return ($mensaje->destacado_remitente) ? 'Mensaje destacado correctamente' : 'Mensaje no destacado correctamente';
                if ($quien == 2) return ($mensaje->archivado_remitente) ? 'Mensaje archivado correctamente' : 'Mensaje desarchivado correctamente';
                if ($quien == 3) return ($mensaje->eliminado_remitente) ? 'Mensaje eliminado correctamente' : 'Mensaje recuperado correctamente';
            } else {
                if ($quien == 1) return ($mensaje->destacado) ? 'Mensaje destacado correctamente' : 'Mensaje no destacado correctamente';
                if ($quien == 2) return ($mensaje->archivado) ? 'Mensaje archivado correctamente' : 'Mensaje desarchivado correctamente';
                if ($quien == 3) return ($mensaje->eliminado) ? 'Mensaje eliminado correctamente' : 'Mensaje recuperado correctamente';
            }
        }
    }

    public function leido(Request $request) {
        $validator = Validator::make($request->all(), ['leido' => "required", 'id' => "required"],);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $mensaje = Mensaje::find($this->hashDecode($request->input('id')));
            $mensaje->leido = true;
            $mensaje->update();

            return response()->json(['status' => 200, 'mensaje' => Mensaje::countProveedorSinLeer($this->proveedorId())[0],]);
        }
    }

    public function destacadoUnico(Request $request) {
        $validator = Validator::make($request->all(), ['destacado' => "required", 'id' => "required"],);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $mensaje = Mensaje::find($this->hashDecode($request->input('id')));
            if ($mensaje->tipo_remitente == 2) { //Destacar mensaje del propio remitente (proveedor = 2)
                $mensaje->destacado_remitente = ($mensaje->destacado_remitente) ? false : true;
            } else {
                $mensaje->destacado = ($mensaje->destacado) ? false : true;
            }
            $mensaje->update();

            return response()->json(['status' => 200, 'mensaje' => ($mensaje->destacado) ? 'Destacado correctamente.' : 'Quitado de destacados.',]);
        }
    }

    public function fetchMensajes($estatus) {
        switch ($estatus) {
            case 1: //Todos
                $mensajes = $this->hashEncode(Mensaje::mensajesProveedorTodos($this->proveedorId()));
                break;
            case 2: //Enviados 
                $mensajes = $this->hashEncode(Mensaje::mensajesProveedorEnviados($this->proveedorId()));
                break;
            case 3: //Archivados 
                $mensajes = $this->hashEncode(Mensaje::mensajesProveedorArchivados($this->proveedorId()));
                break;
            case 4: //Eliminados
                $mensajes = $this->hashEncode(Mensaje::mensajesProveedorEliminados($this->proveedorId()));
                break;
            default:
                return redirect()->back();
                break;
        }
        return Datatables::of($mensajes)->toJson();
    }
}
