<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenCompraEnvio;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraProrroga;
use App\Models\OrdenCompraProveedor;
use Illuminate\Support\Facades\Validator;
use App\Traits\HashIdTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;


class OrdenCompraEnvioController extends Controller
{

    use HashIdTrait;
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
        $now = $this->obtenerFechaHoy();
        if ($id == 1) { //Para declarar la fecha de envio
            $validator = Validator::make(
                $request->all(),
                [
                    'fecha_envio' => "required|date|after_or_equal:$now",
                    'txt_comentarios_confirmacion_envio' => 'required',
                ],
                [
                    'fecha_envio.required' => 'Es necesario que declares una fecha de envío!',
                    'txt_comentarios_confirmacion_envio.required' => 'Describe un comentario sobre el estado del envío!',
                ],
            );
        } else { //Para declarar la fecha de entrega
            $validator = Validator::make(
                $request->all(),
                [
                    'fecha_entrega_almacen' => "required|date|after_or_equal:$now",
                    'nota_remision' => 'required|mimes:pdf|max:31000',
                ],
                [
                    'fecha_entrega_almacen.required' => 'Es necesario que declares la fecha de la entrega en almacén!',
                    'nota_remision.required' => 'La nota de remisión es necesaria!',
                ],
            );
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $oce = OrdenCompraEnvio::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
            $oce = OrdenCompraEnvio::find($oce[0]->id);

            if ($id == 1) { //Para declarar la fecha de envio               
                $oce->fecha_envio = \Carbon\Carbon::now();
                $oce->comentarios = $request->input('txt_comentarios_confirmacion_envio');
            } else { //Para declarar la fecha de entrega               
                $oce->fecha_entrega_almacen = $request->input('fecha_entrega_almacen');
                if ($request->hasFile('nota_remision')) { //Comprobando si existe archivo nuevo
                    if (Storage::disk('public')->exists("proveedor/orden_compra/envios/notas_remision/" . $oce->nota_remision)) { //Comprobando existencia de archivo
                        Storage::disk('public')->delete("proveedor/orden_compra/envios/notas_remision/" . $oce->nota_remision); // Borrando archivo
                    }
                    $file = $request->file('nota_remision');
                    $nombreArchivo = time() . Str::random(8) . $file->getClientOriginalName();
                    Storage::disk('public')->put('proveedor/orden_compra/envios/notas_remision/' . $nombreArchivo, File::get($file));
                    $oce->nota_remision = $nombreArchivo;
                }
            }
            $oce->update();

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId')));
            if ($id == 1) { //Zona de fecha de envio //Trabajando con los estatuses
                $laFecha = OrdenCompraProveedor::select('fecha_entrega')->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                $laFecha = Carbon::parse($laFecha[0]->fecha_entrega)->format('d/m/Y');
                $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "En tránsito", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "En tránsito", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->envio_boton_urg = json_encode(['mensaje' => "Seguimiento", 'css' => 'boton-verde']);
                $ordenCompraEstatus->envio_boton_proveedor = json_encode(['mensaje' => "Confirmar entrega", 'css' => 'boton-verde']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Envío', 'estatus' => "En tránsito", 'css' => 'dorado']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Envío', 'estatus' => "En tránsito", 'css' => 'dorado']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Pedido en tránsito. Fecha de entrega: $laFecha", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Fecha de entrega $laFecha", 'css' => 'alert-secondary']);                
            }else{//Zona de fecha de entrega //Trabajo con los estatuses
                $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "Entregado", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->envio_boton_proveedor = json_encode(['mensaje' => "Nota remisión", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Pedido entregado el " . date('d/m/Y', strtotime(' +0 day')), 'css' => 'alert-secondary']);
                $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "Entregado", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->envio_boton_urg = json_encode(['mensaje' => "Nota remisión", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Pedido entregado. Acepta el pedido antes del " . date('d/m/Y', strtotime(' +1 day')), 'css' => 'alert-secondary']);
                $ordenCompraEstatus->envio = 2;
                $ordenCompraEstatus->entrega = 1;
                $ordenCompraEstatus->entrega_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->entrega_boton_proveedor = json_encode(['mensaje' => "Sustitución de bienes", 'css' => 'boton-gris']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Entrega', 'estatus' => "En espera", 'css' => 'gris']);
                $ordenCompraEstatus->entrega_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->entrega_boton_urg = json_encode(['mensaje' => "Aceptar pedido", 'css' => 'boton-verde']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Entrega', 'estatus' => "En espera", 'css' => 'gris']);
            }
            $ordenCompraEstatus->update();

            $this->cancelarProrroga();//Se checa si es necesario cancelar la prorroga
            return response()->json([
                'status' => 200,
                'message' => $id == 1 ? 'Envío registrado exitosamente' : 'Entrega registrada exitosamente',
            ]);
        }
    }

    public function descargarNotaRemision($archivo)
    { //Funcion que permite buscar el archivo mendiante su id para su posterior visualización
        //return response()->download(storage_path('/app/anexos_contrato/' . $archivo)); //Descargado archivo
        $file = Storage::disk('public')->get('proveedor/orden_compra/envios/notas_remision/'  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }

    public function cancelarProrroga()
    { //Funcion que intenta cancelar la prorroga y verifica si la fecha para aceptar la prorroga aun no ha rebasado las 24 horas, si ya se paso de 24 horas se procede a actualizar el estatus de la prorroga como rechazado
        $consultaProrroga = OrdenCompraProrroga::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
        if ($consultaProrroga->isNotEmpty()) { //Primero se comprueba si ya existe una prorroga levantada
            $intervalo = \Carbon\Carbon::parse($consultaProrroga[0]->fecha_solicitud)->diffInHours(\Carbon\Carbon::now());
            if ($consultaProrroga[0]->estatus === 0 && $intervalo >= 24) { //Despues se checa si ya se acepto o rechazo la prorroga (Si estan en 0 significa que no han aceptado), tambien se comprueba si ya han pasado las 24 horas
                $prorroga = OrdenCompraProrroga::find($consultaProrroga[0]->id);
                $prorroga->estatus = 2; //Si ya pasaron o transcurrieron las 24 horas se procede a rechazar la prorroga
                $prorroga->update();
            } else if ($consultaProrroga[0]->estatus === 0) { //Si no han aceptado la prorroga se procede a cancelarla
                $prorroga = OrdenCompraProrroga::find($consultaProrroga[0]->id);
                $prorroga->estatus = 3; //Cancelando prorroga
                $prorroga->update();
            }
        }
    }

    public function guardarPenalizacion($dias)
    {
        $oce = OrdenCompraEnvio::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
        $oce = OrdenCompraEnvio::find($oce[0]->id);

        $oce->penalizacion = $dias;
        $oce->update();
    }

    public function obtenerFechaHoy()
    { //Funcion usada por algunos modales para evitar seleccionar fechas antiguas a hoy
        $carbon = new \Carbon\Carbon();
        $fecha_hoy = $carbon->now();
        return $fecha_hoy->format('d-m-Y');
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
