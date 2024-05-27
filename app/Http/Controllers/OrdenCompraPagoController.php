<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraPago;
use App\Models\Reporte;
use App\Traits\IncidenciasTrait;
use App\Traits\ReportesTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class OrdenCompraPagoController extends Controller
{
    use ReportesTrait, IncidenciasTrait;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrdenCompraPago  $ordenCompraPago
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenCompraPago $ordenCompraPago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrdenCompraPago  $ordenCompraPago
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenCompraPago $ordenCompraPago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrdenCompraPago  $ordenCompraPago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenCompraPago $ordenCompraPago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrdenCompraPago  $ordenCompraPago
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrdenCompraPago $ordenCompraPago)
    {
        //
    }

    public function reporteGuardar(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'motivo' => "required|in:Retraso en el pago,Comunicación,Otro|max:100",
                'descripcion' => "required|max:1000",
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $this->reporteStore($request, 'pago', 3);
            $cantidadReportes = Reporte::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->where('etapa', 'pago')->where('reporta', 3)->count();
            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
            if ($cantidadReportes === 1) { //Se comprueba si es el primer reporte generado para proceder a actualizar los estatuses // si hay más de un reporte entonces ya no se actualiza
                $ordenCompraEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "Se generó reporte", 'css' => 'text-rojo-estatus']);
                $ordenCompraEstatus->pago_boton_proveedor = json_encode(['mensaje' => "Validar pago", 'css' => 'boton-verde']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Detectamos un retraso.", 'css' => 'alert-warning']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Pago', 'estatus' => "Deuda", 'css' => 'rojo']);
                $ordenCompraEstatus->pago_estatus_urg = json_encode(['mensaje' => "Retraso en el pago", 'css' => 'text-rojo-estatus']);
                $ordenCompraEstatus->pago_boton_urg = json_encode(['mensaje' => "Adjuntar CLC", 'css' => 'boton-verde']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Pago', 'estatus' => "Deuda", 'css' => 'rojo']);
            }
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Tienes " . (session()->get('diasTranscurridos') - 20) . " días de retraso en el pago.", 'css' => 'alert-warning']);
            $ordenCompraEstatus->update();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Reporte levantado correctamente.'
            ]);
        }
    }

    public function incidenciaGuardar(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'motivo' => 'required',
                'descripcion' => "required|max:1000",
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $this->incidenciaStore($request, 'pago', 3);
            $cantidadIncidencias = Incidencia::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->where('etapa', 'pago')->where('reporta', 3)->count(); //origen = etapa // reporta = 3 = proveedor
            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
            if ($cantidadIncidencias === 1) { //Se comprueba si es la primer incidencia generada para proceder a actualizar los estatuses // si hay más de una incidencia entonces ya no se actualiza
                $ordenCompraEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "Se abrió una incidencia", 'css' => 'text-rojo-estatus']);
                $ordenCompraEstatus->pago_boton_proveedor = json_encode(['mensaje' => "Validar pago", 'css' => 'boton-verde']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Detectamos un retraso.", 'css' => 'alert-warning']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Pago', 'estatus' => "Deuda", 'css' => 'rojo']);
                $ordenCompraEstatus->pago_estatus_urg = json_encode(['mensaje' => "Retraso en el pago", 'css' => 'text-rojo-estatus']);
                $ordenCompraEstatus->pago_boton_urg = json_encode(['mensaje' => "Adjuntar CLC", 'css' => 'boton-verde']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Pago', 'estatus' => "Deuda", 'css' => 'rojo']);
            }
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Tienes " . (session()->get('diasTranscurridos') - 20) . " días de retraso en el pago.", 'css' => 'alert-warning']);
            $ordenCompraEstatus->update();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Incidencia generada correctamente.'
            ]);
        }
    }

    public function confirmarPago(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'estatus' => "required",
            ],
            [
                'estatus.required' => 'Estatus requerido',
            ],

        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $pago = OrdenCompraPago::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->first();
            $pago = OrdenCompraPago::find($pago->id);
            $pago->validado = true;
            $pago->update();

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
            $ordenCompraEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "Acreditado", 'css' => 'text-verde-estatus']);
            $ordenCompraEstatus->pago_boton_proveedor = json_encode(['mensaje' => "CLC", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Confirmación exitosa.", 'css' => 'alert-success']);
            $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Pago', 'estatus' => "Acreditado", 'css' => 'verde']);
            $ordenCompraEstatus->pago_estatus_urg = json_encode(['mensaje' => "Acreditado", 'css' => 'text-verde-estatus']);
            $ordenCompraEstatus->pago_boton_urg = json_encode(['mensaje' => "CLC", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->evaluacion_boton_urg = json_encode(['mensaje' => "Calificar compra", 'css' => 'boton-verde']);
            $ordenCompraEstatus->evaluacion_estatus_urg = json_encode(['mensaje' => "Activa", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Pago', 'estatus' => "Acreditado", 'css' => 'verde']);
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Confirmación exitosa.", 'css' => 'alert-success']);
            $ordenCompraEstatus->pago = 2;
            $ordenCompraEstatus->evaluacion = 1;
            $ordenCompraEstatus->update();

            return response()->json([
                'status' => 200,
                'mensaje' => 'Pago confirmado.',
            ]);
        }
    }

    public function descargarArchivo($archivo)
    { //Funcion que permite buscar el archivo acuse subido por la URG para su visualización
        $file = Storage::disk('public')->get('comprobante-clc/'  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }
}
