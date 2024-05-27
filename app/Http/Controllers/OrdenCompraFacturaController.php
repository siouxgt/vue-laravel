<?php

namespace App\Http\Controllers;

use App\Models\FacturasCorreccion;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraFactura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Traits\HashIdTrait;
use App\Traits\SessionTrait;
use Carbon\Carbon;

class OrdenCompraFacturaController extends Controller {
    use HashIdTrait, SessionTrait;

    public function store(Request $request) {
        if (session()->exists('tipoArchivo')) { //Se comprueba que exista la sesion
            if (session('tipoArchivo') === 'Archivo primera versión') { //Envio de primera prefactura
                $now = $this->obtenerFechaHoy();
                $validator = Validator::make(
                    $request->all(),
                    [
                        'archivo_prefactura' => 'required|mimes:pdf|max:5120', //PDF Maximo de 5MB                
                        'fecha_envio' => "required|date|after_or_equal:$now",
                    ],
                    [
                        'archivo_prefactura.max' => 'El archivo de prefactura no debe pesar más de 5 megabytes.',
                        'archivo_prefactura.required' => 'Es necesario que proporcione su archivo de prefactura.',
                        'fecha_envio.required' => 'Fecha de envío necesaria.',
                    ],
                );

                if ($validator->fails()) {
                    return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
                } else {
                    $prefactura = new OrdenCompraFactura();
                    if ($request->hasFile('archivo_prefactura')) { //Comprobando si existe archivo nuevo a subir
                        $archivo = $request->file('archivo_prefactura');
                        $nombreArchivo = time() . Str::random(8) . $archivo->getClientOriginalName();
                        Storage::disk('public')->put('proveedor/orden_compra/facturas/prefactura/' . $nombreArchivo, File::get($archivo));
                        $prefactura->archivo_prefactura = $nombreArchivo;
                    }
                    $prefactura->fecha_prefactura_envio = \Carbon\Carbon::now();
                    $prefactura->tipo_archivo = session('tipoArchivo');
                    $prefactura->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
                    $prefactura->proveedor_id = session()->get('proveedorId');
                    $prefactura->urg_id = session()->get('urgId');
                    $prefactura->save();

                    $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
                    $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Prefactura enviada", 'css' => 'text-gris-estatus']);
                    $ordenCompraEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Enviar prefactura", 'css' => 'boton-verde']);
                    $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Envío exitoso", 'css' => 'alert-secondary']);
                    $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Facturación', 'estatus' => "Prefactura", 'css' => 'verde']);
                    $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Prefactura recibida", 'css' => 'text-gris-estatus']);
                    $ordenCompraEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Aceptar prefactura", 'css' => 'boton-verde']);
                    $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Recibiste la prefactura. Acéptala antes " . date('d/m/Y', strtotime(session()->get('fechaLimite') . " +5 day")), 'css' => 'alert-secondary']);
                    $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Facturación', 'estatus' => "Prefactura", 'css' => 'verde']);
                    $ordenCompraEstatus->update();

                    return response()->json(['status' => 200, 'mensaje' => 'Prefactura enviada correctamente.']);
                }
            } else if (session('tipoArchivo') === 'Prefactura corregida') {
                return $this->update($request, 1); //1 === Prefactura correccion
            } else if (session('tipoArchivo') === 'Factura timbrada') {
                return $this->update($request, 2); //2 === Factura timbrada
            }
        } else {
            return redirect()->back();
        }
    }

    public function obtenerFechaHoy($diagonal = false) { //Funcion usada por algunos modales para evitar seleccionar fechas antiguas a hoy
        $carbon = new \Carbon\Carbon();
        $fecha_hoy = $carbon->now();
        if ($diagonal) {
            return $fecha_hoy->format('d/m/Y');
        } else {
            return $fecha_hoy->format('d-m-Y');
        }
    }

    public function update(Request $request, $id) {
        $now = $this->obtenerFechaHoy();
        $tipoFactura = ($id) === 1 ? 'el archivo de prefactura.' : 'la factura timbrada.';

        $validator = Validator::make(
            $request->all(),
            [
                'archivo_prefactura' => 'required|mimes:pdf|max:5120', //PDF Maximo de 5MB                
                'fecha_envio' => "required|date|after_or_equal:$now", //Fecha compromiso de entrega igual o mayor a la fecha de hoy (fecha actual) pero menor o igual a la fecha de termino del contrato                
            ],
            [
                'archivo_prefactura.max' => 'El archivo de prefactura no debe pesar más de 5 megabytes.',
                'archivo_prefactura.required' => 'Es necesario que proporcione ' . $tipoFactura,
                'fecha_envio.required' => 'Fecha de envío necesaria.',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $prefactura = OrdenCompraFactura::find(session()->get('ordenCompraFacturasId'));
            //-------------------------------------------------------------------------------
            if ($request->hasFile('archivo_prefactura')) { //Comprobando si existe archivo nuevo a subir
                $archivo = $request->file('archivo_prefactura');
                $nombreArchivo = time() . Str::random(8) . $archivo->getClientOriginalName();
                if ($id === 1) { //Prefactura correccion
                    if (Storage::disk('public')->exists("proveedor/orden_compra/facturas/prefactura/" . $prefactura->archivo_prefactura)) {
                        Storage::disk('public')->delete("proveedor/orden_compra/facturas/prefactura/" . $prefactura->archivo_prefactura);
                    }
                    Storage::disk('public')->put('proveedor/orden_compra/facturas/prefactura/' . $nombreArchivo, File::get($archivo));
                    $prefactura->archivo_prefactura = $nombreArchivo;
                } else { //Factura timbrada
                    Storage::disk('public')->put('proveedor/orden_compra/facturas/factura/' . $nombreArchivo, File::get($archivo));
                    $prefactura->archivo_factura = $nombreArchivo;
                }
            }

            if ($id === 1) { //Prefactura correccion
                $prefactura->fecha_prefactura_envio = \Carbon\Carbon::now();
                $prefactura->estatus_prefactura = 0;
                $prefactura->contador_rechazos_prefactura = $prefactura->contador_rechazos_prefactura + 1;
                $prefactura->tipo_archivo = session('tipoArchivo');
            } else { //Factura timbrada
                $prefactura->fecha_factura_envio = \Carbon\Carbon::now();
                $prefactura->tipo_archivo = session('tipoArchivo');
            }
            $prefactura->update();

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
            if ($id === 1) { //Prefactura correccion
                $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Prefactura corregida", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Enviar prefactura", 'css' => 'boton-verde']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Envío exitoso", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Facturación', 'estatus' => "Cambios", 'css' => 'dorado']);
                $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Prefactura corregida", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Aceptar prefactura", 'css' => 'boton-verde']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Prefactura corregida. Acéptala antes del " . date('d/m/Y', strtotime(session()->get('fechaLimite') . " +5 day")), 'css' => 'alert-secondary']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Facturación', 'estatus' => "Cambios", 'css' => 'dorado']);
            } else { //Factura timbrada
                $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Factura timbrada", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Enviar factura", 'css' => 'boton-verde']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Envío exitoso", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Facturación', 'estatus' => "Timbrada", 'css' => 'verde']);
                $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Factura timbrada", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Factura en SAP GRP", 'css' => 'boton-verde']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Confirma su ingreso en SAP GRP antes del " . date('d/m/Y', strtotime(session()->get('fechaLimite') . " +6 day")), 'css' => 'alert-secondary']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Facturación', 'estatus' => "Timbrada", 'css' => 'verde']);
            }
            $ordenCompraEstatus->update();
            $this->eliminarSession(['fechaLimite']);

            return response()->json(['status' => 200, 'mensaje' => $id === 1 ? 'Prefactura enviada correctamente.' : 'Factura timbrada enviada correctamente.']);
        }
    }

    public function descargarArchivo($archivo, $tipo) { //Funcion que permite buscar el archivo
        $ruta = ($tipo === '0') ?  'prefactura/' : 'factura/';

        $file = Storage::disk('public')->get('proveedor/orden_compra/facturas/' . $ruta  . $archivo); //Instrucciones que permiten visualizar archivo
        return  Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }
}
