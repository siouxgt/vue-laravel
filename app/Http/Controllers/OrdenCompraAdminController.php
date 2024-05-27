<?php

namespace App\Http\Controllers;

use App\Models\CancelarCompra;
use App\Models\Contrato;
use App\Models\FacturasCorreccion;
use App\Models\Incidencia;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraBien;
use App\Models\OrdenCompraEnvio;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraEvaluacionProducto;
use App\Models\OrdenCompraEvaluacionProveedor;
use App\Models\OrdenCompraFactura;
use App\Models\OrdenCompraFirma;
use App\Models\OrdenCompraPago;
use App\Models\OrdenCompraProrroga;
use App\Models\OrdenCompraProveedor;
use App\Models\OrdenCompraSustitucion;
use App\Models\RechazarCompra;
use App\Models\Reporte;
use App\Models\Retraso;
use App\Models\SolicitudCompra;
use App\Traits\HashIdTrait;
use App\Traits\SessionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class OrdenCompraAdminController extends Controller
{
    use HashIdTrait, SessionTrait;

    public function index(){
        $todasCabms = OrdenCompraBien::todasCabms()[0];
        $cabmsConfirmadas = OrdenCompraBien::cabmsAceptadas()[0];
        $cabmsRechazadas = OrdenCompraBien::cabmsRechazadas()[0];

        $totalOC = OrdenCompra::all()->count();
        
        return view('admin.orden-compra.index')->with(['todasCabms' => $todasCabms, 'cabmsConfirmadas' => $cabmsConfirmadas, 'cabmsRechazadas' => $cabmsRechazadas, 'totalOC' => $totalOC]);

    }

    public function data(){
        $ordenes = $this->hashEncode(OrdenCompra::allOrden());
        $ordenes = $this->hashEncodeId($ordenes,'solicitud_id');
        
        return Datatables::of($ordenes)->toJson();
    }

    public function showSolicitud($id)
    {
        $id = $this->hashDecode($id);
        $solicitud = $this->hashEncode(SolicitudCompra::find($id));
        $solicitud->producto = json_decode($solicitud->producto);

        return view('admin.orden-compra.solicitud_compra_enviada')->with(['solicitud' => $solicitud]);
    }

    public function show($id){
        $this->eliminarSession(['nombreProveedor','ordenCompraEstatus','ordenCompraReqId','proveedorId','contratoId', 'envioId','ordeProveedor', 'sustitucionId','facturacionId','pagoId']);
        $ordenCompra = $this->hashEncode(OrdenCompra::find($this->hashDecode($id)));

        $this->crearSession(['ordenCompraId' => $ordenCompra->id_e]);

        return view('admin.orden-compra.show')->with(['ordenCompra' => $ordenCompra]);
    }

    public function dataShow($id){
        $proveedores = $this->hashEncode(OrdenCompraEstatus::ordenCompraFind($this->hashDecode($id)));
        $proveedores = $this->hashEncodeId($proveedores,'proveedor_id');
        $estatusCss = ['gris', 'verde', 'dorado', 'rojo'];
        foreach($proveedores as $key => $proveedor){
            $aux = json_decode($proveedor->indicador);
            $proveedores[$key]->estatus = $aux->estatus;
            $proveedores[$key]->etapa = $aux->etapa;
            $proveedores[$key]->css = $aux->css;
        }
        
        return Datatables::of($proveedores)->toJson(); 
    }

    public function dataProductos($id){
        $productos = OrdenCompraBien::productos($this->hashDecode($id),$this->hashDecode(session('ordenCompraId')));
        $estadoConfirmacion = ["En espera", "Aceptada", "Rechazado", "Sustituido", "Cancelado"];
        $estadoCss = ['', 'text-aler-verde','text-aler-rojo', 'text-aler-amarillo','text-aler-rojo'];
        foreach($productos as $key => $producto){
            $productos[$key]->estatusId = $producto->estatus;
            if($producto->estatus != null)
            {
                $productos[$key]->estatusCss = $estadoCss[$producto->estatus];
                $productos[$key]->estatus = $estadoConfirmacion[$producto->estatus];
            }else{
                $productos[$key]->estatus = $estadoConfirmacion[0];
                $productos[$key]->estatusCss = " ";
            }
        }

        $response = ['success' => true, 'data' => json_encode($productos)];

        return $response;
    }

    public function acuseProductosConfirmados($proveedor){
        $datosOrdenCompra =  OrdenCompra::datosOrdenCompraConfirmada($this->hashDecode(session()->get('ordenCompraId')));
        $datosFechaEntrega =  OrdenCompraProveedor::obtenerFechaEntrega($this->hashDecode(session()->get('ordenCompraId')), $this->hashDecode($proveedor));
        $productosConfirmados =  OrdenCompraProveedor::todosProductosConfirmados($this->hashDecode(session()->get('ordenCompraId')), $this->hashDecode($proveedor));
        $this->crearSession(['proveedorId' => $proveedor]);

        return view('admin.orden-compra.acuse_confirmada')->with(['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados]);
    }

    public function exportOrdenConfirmada(){
        $datosOrdenCompra =  OrdenCompra::datosOrdenCompraConfirmada($this->hashDecode(session()->get('ordenCompraId')));
        $datosFechaEntrega =  OrdenCompraProveedor::obtenerFechaEntrega($this->hashDecode(session()->get('ordenCompraId')), $this->hashDecode(session()->get('proveedorId')));
        $productosConfirmados =  OrdenCompraProveedor::todosProductosConfirmados($this->hashDecode(session()->get('ordenCompraId')), $this->hashDecode(session()->get('proveedorId')));
        $pdf = \PDF::loadView('pdf.acuse_compra_confirmada', ['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados])->setPaper('A4', 'landscape');
        return $pdf->download('acuse_orden_compra_confirmada' . $datosOrdenCompra[0]->orden_compra . '.pdf');
    }

    public function seguimiento($id){
        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode($id));
        $this->crearSession(['nombreProveedor' => $ordenCompraEstatus->proveedor->nombre,'ordenCompraEstatus' => $id, 'ordenCompraReqId' => $ordenCompraEstatus->ordenCompra->orden_compra,'proveedorId' => $this->hashEncodeIdClave($ordenCompraEstatus,'proveedor_id','proveedor_id')->proveedor_id, 'urgId' => $ordenCompraEstatus->urg_id]);
        $envio = $this->hashEncode(OrdenCompraEnvio::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', $this->hashDecode(session()->get('proveedorId')))->where('urg_id', $ordenCompraEstatus->urg_id)->get());
        if($envio != '[]'){
            $this->crearSession(['envioId' => $envio[0]->id]);
        }

        $contrato = $this->hashEncode(Contrato::where('urg_id', $ordenCompraEstatus->urg_id)->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode($ordenCompraEstatus->proveedor_id))->get());
        if($contrato != "[]"){
            $this->crearSession(['contratoId' => $contrato[0]->id_e]);
        }
       
        return  view('admin.orden-compra.seguimiento')->with(['ordenCompraEstatus' => $ordenCompraEstatus]);
    }

    public function confirmacion(){
         $tituloEtapa = 'Orden de compra confirmada';
        $contProductoAceptados = count($this->bienesAceptados());
        $contProductoRechazados = count($this->bienesRechazados());
        $countTodosProducto = count($this->todosBienes());
        $ordenCompraProveedor = OrdenCompraProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', $this->hashDecode(session()->get('proveedorId')))->get();
        $cancelacion = CancelarCompra::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('seccion','confirmacion')->get();
        $rechazo = RechazarCompra::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->get();
        
        $vista = 'admin.orden-compra.confirmacion';
        
        if(count($rechazo) != 0){
            $vista = 'admin.orden-compra.rechazo';
        }
        
        return view($vista)->with(['tituloEtapa' => $tituloEtapa,'contProductoAceptados' => $contProductoAceptados, 'contProductoRechazados' => $contProductoRechazados, 'countTodosProducto' => $countTodosProducto, 'fechaEntrega' => $ordenCompraProveedor[0]->fecha_entrega, 'cancelacion' => $cancelacion,'rechazo' => $rechazo]);
    }

    public function bienesAceptados(){
        return OrdenCompraBien::aceptados($this->hashDecode(session()->get('ordenCompraId')),$this->hashDecode(session()->get('proveedorId')));
    } 

    public function bienesRechazados(){
        return OrdenCompraBien::rechazadas($this->hashDecode(session()->get('ordenCompraId')),$this->hashDecode(session()->get('proveedorId')));
    }

    public function todosBienes(){
        return OrdenCompraBien::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', $this->hashDecode(session()->get('proveedorId')))->get();
    }

    public function acuseConfirmada(){
        $datosOrdenCompra =  OrdenCompra::datosOrdenCompraConfirmada($this->hashDecode(session()->get('ordenCompraId')));
        $datosFechaEntrega =  OrdenCompraProveedor::obtenerFechaEntrega($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
        $productosConfirmados =  OrdenCompraProveedor::todosProductosConfirmados($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
        return view('admin.orden-compra.acuse_confirmada')->with(['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados]);
    }

    public function rechazadasModal(){
        $bienes = $this->bienesRechazados();

        return view('admin.orden-compra.modals.rechazadas_modal')->with(['bienes' => $bienes]);
    }

    public function contrato(){
        $tituloEtapa = "Contrato creado";
        $contrato = $this->hashEncode(Contrato::where('urg_id', session()->get('urgId'))->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->get());
        
        $data = [];
        if($contrato[0]->estatus != 0){
            $this->crearSession(['contratoId' => $contrato[0]->id_e]);
            $firmantes = $this->hashEncode(OrdenCompraFirma::where('contrato_id',$contrato[0]->id)->get());
            
            foreach ($firmantes as $key => $firmante){
                $data[$firmante->identificador] = ['id' => $firmante->id_e, 'rfc' => $firmante->rfc, 'nombre' => $firmante->nombre,'primer_apellido' => $firmante->primer_apellido, 'segundo_apellido' => $firmante->segundo_apellido, 'puesto' => $firmante->puesto, 'telefono' => $firmante->telefono, 'extension' => $firmante->extension, 'correo' => $firmante->correo, 'fecha_firma' => $firmante->fecha_firma];
            }
        }

        return view('admin.orden-compra.contrato')->with(['tituloEtapa' => $tituloEtapa,'contrato' => $contrato[0], 'firmantes' => $data]);
    }

    public function envio(){
        $tituloEtapa = "Seguimiento del envío"; 
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        $fechaEntrega  = OrdenCompraProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->get();
        $envio = $this->hashEncode(OrdenCompraEnvio::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id', session()->get('urgId'))->get());
        $this->crearSession(['envioId' => $envio[0]->id,'ordeProveedor' => $fechaEntrega[0]->id]);
        $prorroga = OrdenCompraProrroga::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id', session()->get('urgId'))->get();
        $cancelacion = CancelarCompra::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('seccion','envio')->get();
        
        
        if($prorroga != '[]')
        {
            $prorroga = $this->hashEncode($prorroga);
        }
        
        $diasDiferencia = Carbon::parse($envio[0]->fecha_entrega_almacen)->diffInDays($fechaEntrega[0]->fecha_entrega, false);

        if($prorroga != '[]' and $prorroga[0]->estatus == 1){
            $diasDiferencia = Carbon::parse($envio[0]->fecha_entrega_almacen)->diffInDays($prorroga[0]->fecha_entrega_compromiso, false);
        }

        $penalizacion = 0;

        if($diasDiferencia < 0){
            $penalizacion = $this->penalizacion($diasDiferencia,'envio');
        }

        $reportes = Reporte::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id',session()->get('urgId'))->where('etapa', 'envio')->get();

        $incidencias = Incidencia::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id',session()->get('urgId'))->where('etapa', 'envio')->get();

        return view('admin.orden-compra.envio')->with(['tituloEtapa' => $tituloEtapa, 'contrato' => $contrato,'envio' => $envio[0], 'fechaEntrega' => $fechaEntrega[0], 'prorroga' => $prorroga,'penalizacion' => $penalizacion, 'diasDiferencia' => $diasDiferencia, 'cancelacion' => $cancelacion, 'reportes' => $reportes, 'incidencias' => $incidencias]);
    }

    public function penalizacion($diasDiferencia,$etapa){

        $productos = $etapa == 'envio'? OrdenCompraBien::productosPenalizacionEnvio($this->hashDecode(session()->get('ordenCompraId')),$this->hashDecode(session()->get('proveedorId')),session()->get('urgId')) : OrdenCompraBien::productosPenalizacionSustitucion($this->hashDecode(session()->get('ordenCompraId')),$this->hashDecode(session()->get('proveedorId')),session()->get('urgId'));

        if($diasDiferencia < -16){
            $diasDiferencia = -15;
        }
        $total = 0;
        foreach($productos as $producto){
            $total += $producto->cantidad * $producto->precio;
        }
        
        return ($total * .01) * ($diasDiferencia * -1);

    }

    public function sustitucion(){
        $tituloEtapa = "Aceptar pedido";        
        $contrato = $this->hashEncode(Contrato::where('urg_id', session()->get('urgId'))->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->get());
        $envio = $this->hashEncode(OrdenCompraEnvio::find(session()->get('envioId')));
        $fechaEntrega  = OrdenCompraProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->get();
        $prorroga = OrdenCompraProrroga::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id', session()->get('urgId'))->get();
        $sustitucion = OrdenCompraSustitucion::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id', session()->get('urgId'))->get();
        
        if($sustitucion != '[]'){
            $this->crearSession(['sustitucionId' => $sustitucion[0]->id]);
        }
        
        $diasDiferencia = 0;

        if($envio->estatus == false and $envio->fecha_entrega_aceptada != null){
            $diasDiferencia = Carbon::parse($envio->fecha_entrega_aceptada->addDay(6))->diffInDays(date(now()), false) * -1;
            if($sustitucion != '[]' and $sustitucion[0]->fecha_aceptada){
                $diasDiferencia = Carbon::parse($envio->fecha_entrega_aceptada->addDay(6))->diffInDays($sustitucion[0]->fecha_aceptada, false) * -1;
            }
        }


        $penalizacion = 0;

        if($diasDiferencia < 0){
            if($diasDiferencia <= -5){
                $diasDiferencia = -5;
            }
            $penalizacion = $this->penalizacion($diasDiferencia,'sustitucion');
        }

        $diasSustitucion = "";

        if($envio->fecha_entrega_aceptada != null and $envio->estatus == false and $sustitucion[0]->motivo != null){
            $diasSustitucion = Carbon::parse($envio->fecha_entrega_aceptada->addDay(6))->diffInDays(date(now()), false) * -1;
            if($sustitucion[0]->fecha_aceptada != null and $sustitucion[0]->aceptado == 1){
                $diasSustitucion = Carbon::parse($envio->fecha_entrega_aceptada->addDay(6))->diffInDays($sustitucion[0]->fecha_aceptada, false) * -1;
            }
        }
        
        return view('admin.orden-compra.sustitucion')->with(['tituloEtapa' => $tituloEtapa, 'contrato' => $contrato, 'envio' => $envio,'fechaEntrega' => $fechaEntrega[0], 'diasDiferencia' => $diasDiferencia, 'penalizacion' => $penalizacion, 'sustitucion' => $sustitucion, 'diasSustitucion' => $diasSustitucion]);
    }

    public function datosFacturacion(){
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        return view('admin.orden-compra.modals.datos_facturacion_modal')->with(['contrato' => $contrato]);
    }

    public function facturacion(){
        $tituloEtapa = "Facturación";        
        
        $sustitucion = OrdenCompraSustitucion::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id', session()->get('urgId'))->get();

        $envio = OrdenCompraEnvio::find(session()->get('envioId'));

        $facturacion = OrdenCompraFactura::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id', session()->get('urgId'))->get();

        
        $penalizacionSustitucion = 0;
        $penalizacionEnvio = $this->penalizacion($envio->penalizacion,'envio');

        $diasPenalizacionEnvio = $envio->penalizacion;
        $diasPenalizacionSustitucion = 0;

        if($sustitucion != '[]'){
            $diasRestan = Carbon::parse($sustitucion[0]->fecha_aceptada->addDay(7))->diffInDays(date(now()), false) * -1;
            $penalizacionSustitucion = $this->penalizacion($sustitucion[0]->penalizacion,'sustitucion');
            $diasPenalizacionSustitucion = $sustitucion[0]->penalizacion;
        }
        else{
            $diasRestan = Carbon::parse($envio->fecha_entrega_aceptada->addDay(7))->diffInDays(date(now()), false) * -1;
        }

        $reportes = Reporte::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id',session()->get('urgId'))->where('etapa', 'facturacion')->get();

        $incidencias = Incidencia::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id',session()->get('urgId'))->where('etapa', 'facturacion')->get();

        $facturacionCorrecciones = [];
        if($facturacion != '[]'){
            $facturacionCorrecciones = FacturasCorreccion::where('orden_compra_facturas_id', $facturacion[0]->id)->orderByDesc('id')->limit(1)->get();
            $facturacion = $this->hashEncode($facturacion);
            $this->crearSession(['facturacionId' => $facturacion[0]->id]);
        }

        return view('admin.orden-compra.facturacion')->with(['tituloEtapa' => $tituloEtapa, 'diasRestan' => $diasRestan,'facturacion' => $facturacion,'penalizacionSustitucion' => $penalizacionSustitucion, 'penalizacionEnvio' => $penalizacionEnvio, 'diasPenalizacionEnvio' => $diasPenalizacionEnvio, 'diasPenalizacionSustitucion' => $diasPenalizacionSustitucion, 'reportes' => $reportes, 'incidencias' => $incidencias, 'facturacionCorrecciones' => $facturacionCorrecciones]);
    }

    public function pago(){
        $tituloEtapa = "Confirmación de pago";
        $pago = OrdenCompraPago::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id',session()->get('urgId'))->get();
        $retraso = Retraso::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->where('urg_id',session()->get('urgId'))->get();

        if($pago != '[]'){
            $this->crearSession(['pagoId' => $pago[0]->id]);
        }

        return view('admin.orden-compra.pago')->with(['tituloEtapa' => $tituloEtapa,'pago' => $pago, 'retraso' => $retraso]);
    }

    public function evaluacion(){
        $tituloEtapa = "Evaluación";

        $productos = $this->hashEncode(OrdenCompraBien::evaluacion($this->hashDecode(session()->get('ordenCompraId')),$this->hashDecode(session()->get('proveedorId'))));

        $productosEvaluados = $this->hashEncode(OrdenCompraEvaluacionProducto::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('urg_id',session()->get('urgId'))->get());

        $evaluacionProveedor = OrdenCompraEvaluacionProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$this->hashDecode(session()->get('proveedorId')))->get();
        
        if($evaluacionProveedor != '[]'){
            $evaluacionProveedor = $evaluacionProveedor[0];
        }
        
        return view('admin.orden-compra.evaluacion_edit')->with(['tituloEtapa' => $tituloEtapa, 'evaluacionProveedor' => $evaluacionProveedor, 'productos' => $productos, 'productosEvaluados' => $productosEvaluados]);
    }
}
