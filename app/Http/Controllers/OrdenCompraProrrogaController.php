<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\ContratoMarcoUrg;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraFirma;
use App\Models\OrdenCompraProrroga;
use App\Models\OrdenCompraProveedor;
use Illuminate\Http\Request;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use App\Traits\SessionTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class OrdenCompraProrrogaController extends Controller
{

    use HashIdTrait, SessionTrait, ServicesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $consultaProrroga = OrdenCompraProrroga::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
        if (count($consultaProrroga) > 0) return false; //Ya existe prorroga, no se permite generar otra
            
        $now = $this->obtenerFechaHoy();
        $consultaContrato = Contrato::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
        $fechaFinContrato = $consultaContrato[0]->fecha_fin;

        $validator = Validator::make(
            $request->all(),
            [
                'fecha_solicitud' => "required|date|after_or_equal:$now|before_or_equal:$fechaFinContrato", //Fecha solicitud igual o mayor a la fecha de hoy (fecha actual) pero menor o igual a la fecha de termino del contrato
                'dias_solicitados' => 'required|integer|min:1|max:20', //Maximo de dias solicitados : 1 al 20
                'fecha_compromiso_entrega' => "required|date|after_or_equal:$now|before_or_equal:$fechaFinContrato", //Fecha compromiso de entrega igual o mayor a la fecha de hoy (fecha actual) pero menor o igual a la fecha de termino del contrato
                'descripcion_situacion_solicitud' => 'required|max:1000',
                'documento_justificacion' => 'mimes:pdf|max:5120', //PDF Maximo de 5MB                
            ],
            [
                'dias_solicitados.required' => 'Declare cuanto días desea solicitar para la prórroga.',
                'dias_solicitados.min' => 'Solo puede solicitar de 1 a 20 días de prorroga.',
                'dias_solicitados.max' => 'Solo puede solicitar de 1 a 20 días de prorroga.',
                'fecha_compromiso_entrega.required' => 'Es necesario que exista una fecha de compromiso para la entrega.',
                'descripcion_situacion_solicitud.required' => 'Indique un motivo por la que solicita la prorroga.',
            ],

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $prorroga = new OrdenCompraProrroga();
            $prorroga->id_prorroga = str_replace('-','',session()->get('ordenCompraReqId'))."PR".date('dmY'); 
            $prorroga->fecha_solicitud = \Carbon\Carbon::now();
            $prorroga->fecha_entrega_compromiso = $request->input('fecha_compromiso_entrega');
            $prorroga->dias_solicitados = $request->input('dias_solicitados');
            $prorroga->descripcion = $request->input('descripcion_situacion_solicitud');
            $prorroga->solicitud = 'solicitud_prorroga_' . time() . Str::random(8) . '.pdf';
            $prorroga->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
            $prorroga->proveedor_id = session()->get('proveedorId');
            $prorroga->urg_id = session()->get('urgId');
            //-------------------------------------------------------------------------------
            if ($request->hasFile('documento_justificacion')) { //Comprobando si existe archivo nuevo
                if (Storage::disk('public')->exists("proveedor/orden_compra/envios/prorroga_justificacion/" . $prorroga->justificacion)) { //Comprobando existencia de archivo
                    Storage::disk('public')->delete("proveedor/orden_compra/envios/prorroga_justificacion/" . $prorroga->justificacion); // Borrando archivo
                }
                $file = $request->file('documento_justificacion');
                $nombreArchivo = time() . Str::random(8) . $file->getClientOriginalName();
                Storage::disk('public')->put('proveedor/orden_compra/envios/prorroga_justificacion/' . $nombreArchivo, File::get($file));
                $prorroga->justificacion = $nombreArchivo;
            }
            //-------------------------------------------------------------------------------
            $prorroga->save();

            $this->crearSession(['ordenCompraProrrogaId' => $prorroga->id]);            
            $this->generarSolicitud($prorroga->solicitud);

            return response()->json([
                'status' => 200,
                'seguimiento' => 3,
                'seccion' => 'pdf_firma_prorroga',
            ]);
        }
    }

    public function firmarProrroga(Request $request)
    { //Funcion que permitira comprobar si la firma es correcta
        $validator = Validator::make(
            $request->all(),
            [
                'archivo_cer' => "required",
                'archivo_key' => "required",
                'contrasenia' => "required",
            ],
            [
                'archivo_cer.required' => 'Es necesario que proporcione su archivo .cer',
                'archivo_key.required' => 'Es necesario que proporcione su archivo .key',
                'contrasenia.required' => 'Proporcione su contraseña por favor.',
            ],

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $cer = base64_encode($request->file('archivo_cer')->get());
            $key = base64_encode($request->file('archivo_key')->get());
            $pass = base64_encode($request->input('contrasenia'));

            $efirma = $this->efirma($cer, $key, $pass);

            if ($efirma->error->code != 0) {
                return redirect()->back()->with(['error' => $efirma->error->msg]);
            }

            if ($efirma->data->RFC == Auth::guard('proveedor')->user()->rfc) {
                $prorroga = OrdenCompraProrroga::find(session('ordenCompraProrrogaId'));
                $prorroga->estatus = 0; //La prorroga ya fue firmada por el proveedor y se está en espera de que la URG acepte
                $prorroga->update();

                $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
                $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "Prórroga solicitada", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->envio_boton_proveedor = json_encode(['mensaje' => "Confirmar entrega", 'css' => 'boton-verde']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Envío', 'estatus' => "Prórroga", 'css' => 'dorado']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Prórroga solicitada", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "Prórroga solicitada", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->envio_boton_urg = json_encode(['mensaje' => "Seguimiento", 'css' => 'boton-verde']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Envío', 'estatus' => "Retraso", 'css' => 'dorado']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Has recibido una solicitud de Prórroga", 'css' => 'alert-warning']);
                $ordenCompraEstatus->update();

                return response()->json([
                    'status' => 200,
                    'mensaje' => 'Prórroga firmada correctamente',
                    'seguimiento' => 3,
                    'seccion' => 'index',
                ]);
            } else {
                return redirect()->back()->with(['error' => 'El RFC no coincide con el usuario.']);
            }
        }
    }

    public function descargarSolicitud($archivo)
    { //Funcion que permite buscar el archivo para su posterior visualización
        $file = Storage::disk('public')->get('proveedor/orden_compra/envios/prorroga_solicitud/'  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }

    public function descargarAcuse($archivo)
    { //Funcion que permite buscar el archivo acuse subido por la URG para su visualización
        $file = Storage::disk('public')->get('proveedor/orden_compra/envios/prorroga_acuse/'  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }

    public function generarSolicitud($nombreArchivo)
    { //Generar el pdf de la solicitud de la prorroga
        $contrato = Contrato::find(session()->get('contratoId'));
        $consultaTitular = OrdenCompraFirma::where('contrato_id', session()->get('contratoId'))->where('identificador', 1)->get();
        $consultaProveedor = OrdenCompraFirma::where('contrato_id', session()->get('contratoId'))->where('identificador', 3)->get();
        $consultaProrroga = OrdenCompraProrroga::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
        $consultaProveedorFull = OrdenCompraProveedor::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();

        $content = \PDF::loadView('pdf.solicitud_prorroga', ['fecha' => $this->obtenerFechaHoy(true), 'contrato' => $contrato, 'consultaTitular' => $consultaTitular, 'consultaProveedor' => $consultaProveedor, 'consultaProrroga' => $consultaProrroga, 'fechas' => $consultaProveedorFull])
            ->setPaper('letter', 'portrait')->output();
        Storage::disk('public')->put('proveedor/orden_compra/envios/prorroga_solicitud/' . $nombreArchivo, $content);
    }

    public function obtenerFechaHoy($diagonal = false)
    { //Funcion usada por algunos modales para evitar seleccionar fechas antiguas a hoy
        $carbon = new \Carbon\Carbon();
        $fecha_hoy = $carbon->now();
        if ($diagonal) {
            return $fecha_hoy->format('d/m/Y');
        } else {
            return $fecha_hoy->format('d-m-Y');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
