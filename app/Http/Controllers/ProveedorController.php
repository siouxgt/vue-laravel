<?php

namespace App\Http\Controllers;

use App\Mail\CodigoConfirmacionMailable;
use App\Models\CatProducto;
use App\Models\ContratoMarco;
use App\Models\Mensaje;
use App\Models\OrdenCompraBien;
use App\Models\OrdenCompraEvaluacionProveedor;
use App\Models\OrdenCompraProveedor;
use App\Models\ProductoFavoritoUrg;
use App\Models\ProductosPreguntasRespuestas;
use App\Models\Proveedor;
use App\Models\ProveedorFichaProducto;
use App\Traits\HashIdTrait;
use App\Traits\ProveedoresTrait;
use App\Traits\ServicesTrait;
use App\Traits\MensajeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller {
    use HashIdTrait, ProveedoresTrait, ServicesTrait, MensajeTrait;

    //-------------------------------------------------------------
    //                     Matriz de escalamiento

    public function acceso() {
        return view('proveedores.index');
    }

    public function checarPerfil(Request $request) { /*Busqueda de perfil de proveedor*/
        $request->validate(
            [
                'rfc' => 'required',
                'password' => 'required'
            ],
            [
                'rfc.required' => 'Ingresa el RFC',
                'password.required' => 'Ingresa una contraseña'
            ]
        );

        $estatus = $this->checarEstatusProveedor($request->input('rfc'));
        if ($estatus != '') return back()->withErrors(['rfc' => $estatus])->onlyInput('rfc');

        if ($this->verificarContraseniaAPIBD($request->input('rfc'))) {
            $credentials = $request->only('rfc', 'password');
            $credentials += ['estatus' => true]; //Verificar que el proveedor no haya sido dado de baja por el admin
            $recordar_credencial = $request->filled('recordar_credencial');
            if (Auth::guard('proveedor')->attempt($credentials, $recordar_credencial)) {
                $request->session()->regenerate();

                if (!Auth::guard('proveedor')->user()->perfil_completo) { //Perfil no completo
                    if (Auth::guard('proveedor')->user()->constancia == "true") {
                        if (Auth::guard('proveedor')->user()->confirmacion == "") { //Si aun no tiene codigo de confirmacion entonces no ha llenado su perfil, por lo tanto se le enviara a esa seccion                                       
                            return redirect()->route("proveedor.perfil_completar");
                        } else { //Si el proveedor ya lleno la matriz pero su perfil aun no esta completo, entonces esta solo en espera de confirmar el codigo de confirmación
                            return redirect()->route("proveedor.perfil_confirmar");
                        }
                    } else {
                        return redirect()->route("proveedor.vencida");
                    }
                } else {
                    return redirect()->route("proveedor.aip"); //Abrir Home (Inicio) proveedor                    
                }
            }
            return back()->withErrors(['rfc' => 'El RFC y/o la contraseña que ingresaste no coinciden con nuestros registros. Por favor, revisa e inténtalo de nuevo.',])->onlyInput('rfc');
        } else {
            return back()->withErrors(['rfc' => 'El RFC y/o la contraseña que ingresaste no coinciden con nuestros registros. Por favor, revisa e inténtalo de nuevo.',])->onlyInput('rfc');
        }
    }

    public function checarEstatusProveedor($rfc) { //Funcion que verifica si el proveedor ya existe en el contrato marco, tambien checa que este esté activo
        $proveedor = Proveedor::where('rfc', $rfc)->get();
        if (count($proveedor) == 1) {
            if (!$proveedor[0]->estatus) return 'El RFC que ingresaste se encuentra suspendido por incumplir los lineamientos de Contrato Marco. Para mayor información, contacta al administrador.';
        } else {
            return 'El RFC y/o la contraseña que ingresaste no coinciden con nuestros registros. Por favor, revisa e inténtalo de nuevo.';
        }
    }

    public function abrirPerfilCompletar() {
        $this->guardarRutaActiva("proveedor.matriz", 'perfil_completar');
        return view('proveedores.matriz_escalamiento.perfil_completar');
    }

    public function abrirME() {
        if (Auth::guard('proveedor')->user()->constancia == 'true') {
            if (session('quien') == 'perfil_completar') {
                return redirect()->route("proveedor.vigente");
            } else {
                return redirect()->route("proveedor.vigente_editar");
            }
        } else {
            return redirect()->route("proveedor.vencida");
        }
    }

    public function matrizVigente() {
        return view('proveedores.matriz_escalamiento.matriz_vigente');
    }

    public function matrizVigenteEditar() {
        return view('proveedores.matriz_escalamiento.matriz_vigente_editar');
    }

    public function matrizVencida() {
        return view('proveedores.matriz_escalamiento.matriz_vencida');
    }

    public function salirMatrizVencida() { //Salir de la matriz vencida
        Auth::guard('proveedor')->logout();
        $this->eliminarRutaActiva();
        return redirect()->away('https://tianguisdigital.finanzas.cdmx.gob.mx/');
    }

    public function guardarMatrizEscalamiento(Request $request) {
        $expRegNombre = 'regex:/^[A-Z,a-z, ,Á,É,Í,Ó,Ú,Ü,Ñ,á,é,í,ó,ú,ü,ñ]+$/';
        $reglas = [
            'nombre_tres' => "required|min:3|max:50|$expRegNombre",
            'cargo_tres' => "required|min:3|max:100|$expRegNombre",
            'telefono_3' => 'nullable|regex:/^[0-9]{10}$/',
            'extension_3' => 'nullable|regex:/^[0-9]{3,5}$/',
            'celular_3' => 'required|regex:/^[0-9]{10}$/',
            'correo_tres' => 'required|max:100|email',
            //---------------------------------------------------------------
            'nombre_dos' => "required|min:3|max:50|$expRegNombre",
            'cargo_dos' => "required|min:3|max:100|$expRegNombre",
            'telefono_2' => 'nullable|regex:/^[0-9]{10}$/',
            'extension_2' => 'nullable|regex:/^[0-9]{3,5}$/',
            'celular_2' => 'required|regex:/^[0-9]{10}$/',
            'correo_dos' => 'required|max:100|email',
            //---------------------------------------------------------------
            'nombre_uno' => "required|min:3|max:50|$expRegNombre",
            'cargo_uno' => "required|min:3|max:100|$expRegNombre",
            'telefono_1' => 'nullable|regex:/^[0-9]{10}$/',
            'extension_1' => 'nullable|regex:/^[0-9]{3,5}$/',
            'celular_1' => 'required|regex:/^[0-9]{10}$/',
            'correo_uno' => 'required|max:100|email',
        ];

        //Reglas condicionales
        if ($request->input('primer_apellido_tres') != '') $reglas['primer_apellido_tres'] = "min:1|max:50|$expRegNombre";
        if ($request->input('segundo_apellido_tres') != '') $reglas['segundo_apellido_tres'] = "min:1|max:50|$expRegNombre";
        if ($request->input('primer_apellido_dos') != '') $reglas['primer_apellido_dos'] = "min:1|max:50|$expRegNombre";
        if ($request->input('segundo_apellido_dos') != '') $reglas['segundo_apellido_dos'] = "min:1|max:50|$expRegNombre";
        if ($request->input('primer_apellido_uno') != '') $reglas['primer_apellido_uno'] = "min:1|max:50|$expRegNombre";
        if ($request->input('segundo_apellido_uno') != '') $reglas['segundo_apellido_uno'] = "min:1|max:50|$expRegNombre";

        $validator = Validator::make($request->all(), $reglas);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $proveedor = Proveedor::find(Auth::guard('proveedor')->user()->id);
            $proveedor->nombre_tres = $request->input('nombre_tres');
            $proveedor->primer_apellido_tres = $request->input('primer_apellido_tres');
            $proveedor->segundo_apellido_tres = $request->input('segundo_apellido_tres');
            $proveedor->cargo_tres = $request->input('cargo_tres');
            $proveedor->telefono_tres = $request->input('telefono_3');
            $proveedor->extension_tres = $request->input('extension_3');
            $proveedor->celular_tres = $request->input('celular_3');
            $proveedor->correo_tres = strtolower($request->input('correo_tres'));
            $proveedor->nombre_dos = $request->input('nombre_dos'); //###################
            $proveedor->primer_apellido_dos = $request->input('primer_apellido_dos');
            $proveedor->segundo_apellido_dos = $request->input('segundo_apellido_dos');
            $proveedor->cargo_dos = $request->input('cargo_dos');
            $proveedor->telefono_dos = $request->input('telefono_2');
            $proveedor->extension_dos = $request->input('extension_2');
            $proveedor->celular_dos = $request->input('celular_2');
            $proveedor->correo_dos = strtolower($request->input('correo_dos'));
            $proveedor->nombre_uno = $request->input('nombre_uno'); //###################
            $proveedor->primer_apellido_uno = $request->input('primer_apellido_uno');
            $proveedor->segundo_apellido_uno = $request->input('segundo_apellido_uno');
            $proveedor->cargo_uno = $request->input('cargo_uno');
            $proveedor->telefono_uno = $request->input('telefono_1');
            $proveedor->extension_uno = $request->input('extension_1');
            $proveedor->celular_uno = $request->input('celular_1');
            $proveedor->correo_uno = strtolower($request->input('correo_uno'));

            //---------------------------------------------------------------
            if (session('quien') == 'perfil_completar') {
                $proveedor->confirmacion = Str::random(8);
                $proveedor->confirmacion_fecha = $this->fechaActual();
                $this->enviarCorreoCodigo($proveedor->correo_tres, $proveedor->nombre, $proveedor->confirmacion);
            }
            //---------------------------------------------------------------

            $proveedor->update();

            if (session('quien') == 'perfil_completar') {
                return response()->json(['status' => 200, 'message' => 'Datos guardados correctamente, se ha enviado un código de confirmación al correo electrónico ' . $proveedor->correo_tres]);
            } else { // Permiso vigente editar
                $this->guardarRutaActiva("proveedor.perfil_exitoso", 'perfil_editado_exitoso');
                return response()->json(['status' => 200, 'message' => 'Datos actualizados correctamente, da clic para continuar.']);
            }
        }
    }

    public function redirigirGuardado() {
        if (session('quien') == 'perfil_completar') {
            Session::flash("mensaje", 'Código enviado a tu correo correctamente.');
            return redirect()->route("proveedor.perfil_confirmar");
        } else { // Permiso vigente editar            
            return redirect()->route("proveedor.aip");
        }
    }

    public function enviarCorreoCodigo($email, $name, $code) {
        try {
            $mailData = ['name' => $name, 'code' => $code];
            Mail::to($email)->send(new CodigoConfirmacionMailable($mailData));
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Error al registrar matriz de escalamiento.'];
        }
    }

    public function reenviarCorreoCodigo() {
        $proveedor = Proveedor::find(Auth::guard('proveedor')->user()->id);
        //---------------------------------------------------------------
        $tiempoTranscurrido = ($this->fechaActual())->diffInRealSeconds($proveedor->confirmacion_fecha);
        //---------------------------------------------------------------
        if ($tiempoTranscurrido >= 3600) { //Se comprueba si ya transcurrieron las 12 horas, si ya transcurrio se envía codigo
            $proveedor->confirmacion = Str::random(8);
            $proveedor->confirmacion_fecha = $this->fechaActual();
            $this->enviarCorreoCodigo($proveedor->correo_tres, $proveedor->nombre, $proveedor->confirmacion);
            //---------------------------------------------------------------
            $proveedor->update();
            Session::flash("mensaje", 'Código reenviado correctamente, revisa tu correo electrónico.');
        } else {
            $tiempoRestante = $this->convertirSegundosEnHoras(3600 - $tiempoTranscurrido);
            Session::flash("mensaje", "Espera $tiempoRestante, para poder generarte un nuevo código.");
        }

        return redirect()->route("proveedor.perfil_confirmar");
    }

    public function abrirPerfilConfirmar() {
        $proveedor = Proveedor::where("id", "=", Auth::guard('proveedor')->user()->id)->whereNotNull("confirmacion")->where("perfil_completo", "=", false)->select("correo_tres")->get();
        return view('proveedores.matriz_escalamiento.perfil_confirmar')->with(['proveedor' => $proveedor]);
    }

    public function comprobarCodigo(Request $request) {
        $request->validate(['codigo' => 'required',]);
        $proveedor =  Proveedor::where("id", "=", Auth::guard('proveedor')->user()->id)->where("confirmacion", "=", $request->codigo)->get();
        if (count($proveedor) == 1) {
            $proveedor = Proveedor::find(Auth::guard('proveedor')->user()->id);
            $proveedor->perfil_completo = true;
            $proveedor->update();

            $this->guardarRutaActiva("proveedor.perfil_exitoso", 'perfil_exitoso');
            return redirect()->route("proveedor.perfil_exitoso");
        } else {
            Session::flash("respuesta", 'Código inválido');
            return redirect()->route("proveedor.perfil_confirmar");
        }
    }

    public function abrirPerfilExitoso() {
        if (session('quien') == 'perfil_editado_exitoso') {
            return view('proveedores.matriz_escalamiento.perfil_editado_exitoso');
        } else {
            return view('proveedores.matriz_escalamiento.perfil_registro_exitoso');
        }
    }

    public function abrirInicioProveedor() { //Inicio (Home)
        $proveedorId = Auth::guard('proveedor')->user()->id;
        $totalContratos = ContratoMarco::totalContratosProveedor($proveedorId)[0]->total;
        $penalizacionEnvio = OrdenCompraBien::totalPenalizacionEnvioProveedor($proveedorId)[0]->total; // Ventas
        $penalizacionSust = OrdenCompraBien::totalPenalizacionSustProveedor($proveedorId)[0]->total;
        $totalSinIva = OrdenCompraBien::totalPorProveedor($proveedorId)[0]->total;
        $totalSinIva = ($totalSinIva != null) ? $totalSinIva : 0;
        $totalSinIva = $totalSinIva - (($totalSinIva * ($penalizacionEnvio / 100)) + ($totalSinIva * ($penalizacionSust / 100)));
        $totalConIva = $totalSinIva + ($totalSinIva * .16);
        $totalPendientesFirmar = OrdenCompraProveedor::totalPendientesFirmar(Auth::guard('proveedor')->user()->rfc)[0]->total;
        $totalPendientesConfirmar = OrdenCompraProveedor::totalPendientesConfirmar($proveedorId)[0]->total;
        $totalVendidos = OrdenCompraProveedor::totalVendidos($proveedorId)[0]->total;
        $totalFormulariosActivos = CatProducto::totalFormulariosActivos($proveedorId)[0]->total; // Información sobre tus productos
        $estatusVerificacion = ProveedorFichaProducto::estatusVerificaciones($proveedorId)[0];
        $totalPreguntas = ProductosPreguntasRespuestas::totalPreguntasPorProveedor($proveedorId)[0]->total; // Posibles ventas
        $totalFavoritos = ProductoFavoritoUrg::totalFavoritosPorProveedor($proveedorId)[0]->total;
        $totalCambs = OrdenCompraBien::totalCabmsPorProveedor($proveedorId)[0]->total;
        $evaluacion = OrdenCompraEvaluacionProveedor::evaluacionGeneral($proveedorId);
        $ultimosMensajes = Mensaje::ultimosMensajesProveedor($proveedorId);

        $this->guardarRutaActiva("proveedor.aip", 'inicio');
        $this->guardarRutaActiva("proveedor.perfil_completar", 'perfil_editar');
        return view('proveedores.inicio')->with(['totalContratos' => $totalContratos, 'totalVendidos' => $totalVendidos, 'totalPendientesConfirmar' => $totalPendientesConfirmar, 'totalPendientesFirmar' => $totalPendientesFirmar, 'totalConIva' => $totalConIva, 'totalFavoritos' => $totalFavoritos, 'totalPreguntas' => $totalPreguntas, 'totalCambs' => $totalCambs, 'estatusVerificacion' => $estatusVerificacion, 'totalFormulariosActivos' => $totalFormulariosActivos, 'evaluacion' => $evaluacion, 'ultimosMensajes' => $ultimosMensajes]);
    }

    public function modalEnviarMensaje() {
        return view('proveedores.modal_enviar_mensaje');
    }

    public function guardarMensaje(Request $request) {

        $validator = Validator::make(
            $request->all(),
            [
                'asunto' => 'required|max:100',
                'mensaje' => 'required|max:1000',
                'imagen' => 'image'
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $data = [
                'remitente' => Auth::guard('proveedor')->user()->id,
                'receptor' => 0,
                'tipo_remitente' => 2,
                'tipo_receptor' => 1,
                'origen' => 'HOME PROVEEDOR'
            ];
            return $this->storeManual($request, $data);
        }
    }

    public function logout() {
        Auth::guard('proveedor')->logout();
        $this->eliminarRutaActiva();
        return redirect()->route("proveedor.login");
    }

    //------------------------------------------------------------
    //                 Trabajando con las rutas

    public function guardarRutaActiva($ruta, $quien) {
        session(['ruta' => $ruta, 'quien' => $quien]);
    }

    public function eliminarRutaActiva() {
        if (session()->exists('ruta')) session()->forget('ruta');
        if (session()->exists('quien')) session()->forget('quien');
    }

    //------------------------------------------------------------
    //               Trabajando con la API de LOGIN

    public function verificarContraseniaAPIBD($rfc) {
        $datosAPI = $this->proveedoresLogin($rfc); //Buscar por medio de RFC los datos del proveedor en API
        if ($datosAPI != false) { //Se comprueba que sí se hayan obtenido datos del proveedor por medio de RFC
            $consultado =  Proveedor::where("rfc", "=", $rfc)->get();
            if (!Hash::check($consultado[0]->password, $datosAPI->proveedor[0]->password)) {
                $proveedor  = Proveedor::find($consultado[0]->id);
                $proveedor->password = $datosAPI->proveedor[0]->password;//Si la contraseña de la BD es diferente (o no existe contraseña), entonces, guardar la nueva contraseña obtenida de API
                // $proveedor->constancia = ($datosAPI->tiene_constancia == 'SI') ? 'true' : 'false'; //Actualización de la constancia (vigente / no vigente)
                $proveedor->update();
                return true;
            }
            return true;
        }
        return false;
    }

    //------------------------------------------------------------
    //               Funciones extra

    public function fechaActual() {
        return now();
    }

    public function convertirSegundosEnHoras($segundos) {
        $minutos = $segundos / 60;
        $horas = floor($minutos / 60);
        $minutos2 = $minutos % 60;
        $segundos_2 = $segundos % 60 % 60 % 60;
        if ($minutos2 < 10) $minutos2 = '0' . $minutos2;
        if ($segundos_2 < 10) $segundos_2 = '0' . $segundos_2;

        if ($segundos < 60) { /* segundos */
            $resultado = round($segundos) . ' Segundos';
        } elseif ($segundos > 60 && $segundos < 3600) { /* minutos */
            $resultado = $minutos2 . ' minutos con ' . $segundos_2 . ' segundos';
        } else { /* horas */
            $resultado = $horas . ' hora(s) con ' . $minutos2 . ' minutos y ' . $segundos_2 . ' segundos';
        }
        return $resultado;
    }
}
