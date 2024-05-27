<?php

namespace App\Http\Controllers;

use App\Models\CancelarCompra;
use App\Models\Contrato;
use App\Models\ContratoMarcoUrg;
use App\Models\FacturasCorreccion;
use App\Models\HabilitarProveedore;
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
use App\Models\User;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use App\Traits\SessionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class OrdenCompraUrgController extends Controller
{
    use HashIdTrait, SessionTrait, ServicesTrait;


    public function index($id){
        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode($id));
        $this->crearSession(['nombreProveedor' => $ordenCompraEstatus->proveedor->nombre,'ordenCompraEstatus' => $id, 'ordenCompraReqId' => $ordenCompraEstatus->ordenCompra->orden_compra,'proveedorId' => $ordenCompraEstatus->proveedor_id]);
        $envio = $this->hashEncode(OrdenCompraEnvio::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', auth()->user()->urg_id)->get());
        if($envio != '[]'){
            $this->crearSession(['envioId' => $envio[0]->id]);
        }

        $contrato = $this->hashEncode(Contrato::where('urg_id', auth()->user()->urg_id)->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',$ordenCompraEstatus->proveedor_id)->get());
        if($contrato != "[]"){
            $this->crearSession(['contratoId' => $contrato[0]->id_e]);
        }
       
        return  view('urgs.orden-compra.seguimiento.index')->with(['ordenCompraEstatus' => $ordenCompraEstatus]);
    }

    public function confirmacion(){

        $tituloEtapa = 'Orden de compra confirmada';
        $contProductoAceptados = count($this->bienesAceptados());
        $contProductoRechazados = count($this->bienesRechazados());
        $countTodosProducto = count($this->todosBienes());
        $ordenCompraProveedor = OrdenCompraProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
        $cancelacion = CancelarCompra::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('seccion','confirmacion')->get();
        $rechazo = RechazarCompra::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->get();
        
        $vista = 'urgs.orden-compra.seguimiento.confirmacion';
        
        if(count($rechazo) != 0){
            $vista = 'urgs.orden-compra.seguimiento.rechazo';
        }
        
        return view($vista)->with(['tituloEtapa' => $tituloEtapa,'contProductoAceptados' => $contProductoAceptados, 'contProductoRechazados' => $contProductoRechazados, 'countTodosProducto' => $countTodosProducto, 'fechaEntrega' => $ordenCompraProveedor[0]->fecha_entrega, 'cancelacion' => $cancelacion,'rechazo' => $rechazo]);
    }

    public function bienesAceptados(){
        return OrdenCompraBien::aceptados($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId'));
    } 

    public function bienesRechazados(){
        return OrdenCompraBien::rechazadas($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId'));
    }

    public function todosBienes(){
        return OrdenCompraBien::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
    }

    public function rechazadasModal(){

        $bienes = $this->bienesRechazados();

        return view('urgs.orden-compra.modals.rechazadas_modal')->with(['bienes' => $bienes]);
    }

    public function cancelarModal($etapa){
        $combos = ['confirmacion' => ['Error al elegir el producto','Error al seleccionar características','Inconveniente con el pedido'],'envio' => ['Fuera del plazo de entrega','No respondió mensajes'] ];

        return view('urgs.orden-compra.modals.cancelar_modal')->with(['combos' => $combos[$etapa]]);
    }

    public function cancelarSave(Request $request){

        $cancelar = new CancelarCompra();
        $cancelar->cancelacion = str_replace('-','',session()->get('ordenCompraReqId'))."C".date('dmY'); 
        $cancelar->motivo = $request->input('motivo');
        $cancelar->descripcion = $request->input('descripcion');
        $cancelar->seccion = $request->input('seccion');
        $cancelar->urg_id = auth()->user()->urg_id;
        $cancelar->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
        $cancelar->usuario_id = auth()->user()->id;
        $cancelar->proveedor_id = session()->get('proveedorId');
        $cancelar->save();

        $productos = OrdenCompraBien::cancelarProductos($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId'));
        foreach($productos as $value){
            $producto = OrdenCompraBien::find($value->id);
            $producto->estatus = 4;
            $producto->update();
        }
        
        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
        if($request->input('seccion') == "confirmacion"){
            $ordenCompraEstatus->confirmacion = 2;
            $ordenCompraEstatus->confirmacion_estatus_urg = json_encode(['mensaje' => "Orden cancelada", 'css' => 'text-alert-danger']);
            $ordenCompraEstatus->confirmacion_boton_urg = json_encode(['mensaje' => "Orden cancelada", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->confirmacion_estatus_proveedor = json_encode(['mensaje' => "Orden cancelada", 'css' => 'text-alert-danger']);
            $ordenCompraEstatus->confirmacion_boton_proveedor = json_encode(['mensaje' => "Orden cancelada", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Confirmación','estatus' => "Cancelada", 'css' => 'rojo']);
            $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Confirmación','estatus' => "Cancelada", 'css' => 'rojo']);
        }
        if($request->input('seccion') == "envio"){
            $ordenCompraEstatus->envio = 2;
            $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "Orden cancelada", 'css' => 'text-alert-danger']);
            $ordenCompraEstatus->envio_boton_urg = json_encode(['mensaje' => "Orden cancelada", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "Orden cancelada", 'css' => 'text-alert-danger']);
            $ordenCompraEstatus->envio_boton_proveedor = json_encode(['mensaje' => "Orden cancelada", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->evaluacion = 1;
            $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Envío','estatus' => "Cancelada", 'css' => 'rojo']);
            $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Envío','estatus' => "Cancelada", 'css' => 'rojo']);
        }
        $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "La compra fue cancelada", 'css' => 'alert-danger']);
        $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "La compra fue cancelada", 'css' => 'alert-danger']);
        $ordenCompraEstatus->update();
        return ['success' => true,'data' => $cancelar];
    }

    public function acuseConfirmada()
    {
        $datosOrdenCompra =  OrdenCompra::datosOrdenCompraConfirmada($this->hashDecode(session()->get('ordenCompraId')));
        $datosFechaEntrega =  OrdenCompraProveedor::obtenerFechaEntrega($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
        $productosConfirmados =  OrdenCompraProveedor::todosProductosConfirmados($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
        return view('urgs.orden-compra.seguimiento.acuse_confirmada')->with(['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados]);
    }

    public function altaContrato(){
        $tituloEtapa = "Alta del contrato";        
        $contrato = $this->hashEncode(Contrato::where('urg_id', auth()->user()->urg_id)->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->get());
        
        if($contrato[0]->razon_social_fiscal == NULL ){
            $this->saveDatosUrgFacturacion($contrato[0]->id);
        }
        $vista = 'urgs.orden-compra.seguimiento.alta_contrato1';

        if($contrato[0]->estatus != 0){
            $tituloEtapa = "Contrato creado";
            $vista = 'urgs.orden-compra.seguimiento.contrato';
        }


        $this->crearSession(['contratoId' => $contrato[0]->id_e]);
        $firmantes = $this->hashEncode(OrdenCompraFirma::where('contrato_id',$contrato[0]->id)->get());
        $data = [];
        foreach ($firmantes as $key => $firmante){
            $data[$firmante->identificador] = ['id' => $firmante->id_e, 'rfc' => $firmante->rfc, 'nombre' => $firmante->nombre,'primer_apellido' => $firmante->primer_apellido, 'segundo_apellido' => $firmante->segundo_apellido, 'puesto' => $firmante->puesto, 'telefono' => $firmante->telefono, 'extension' => $firmante->extension, 'correo' => $firmante->correo, 'fecha_firma' => $firmante->fecha_firma];
        }

        return view($vista)->with(['tituloEtapa' => $tituloEtapa,'contrato' => $contrato[0], 'firmantes' => $data]);
    }

    public function saveDatosUrgFacturacion($contrato_id){

        $contrato = Contrato::find($contrato_id);
        $contrato->institucion = auth()->user()->urg->nombre;
        $contrato->direccion_urg = auth()->user()->urg->direccion;
        $contrato->orden_compra = session()->get('ordenCompraReqId');
        $contrato->area_requiriente = $contrato->requisiciones->area_requirente;
        $contrato->requisicion = $contrato->requisiciones->requisicion;
        $contrato->partida = substr($this->partidas($contrato->requisiciones->clave_partida), 0, -1);
        $contrato->anio_fiscal = date('Y');
        $contrato->razon_social_fiscal = "GOBIERNO DE LA CIUDAD DE MÉXICO";
        $contrato->rfc_fiscal = "GDF9712054NA";
        $contrato->domicilio_fiscal = "PLAZA DE LA CONSTITUCIÓN S/N, CENTRO DE LA CIUDAD DE MÉXICO, 06000";
        $contrato->metodo_pago = "PUE (Pago en una sola exhibición)";
        $contrato->forma_pago = "TRANSFERENCIA INTERBANCARIA";
        $contrato->uso_cfdi = "GASTOS EN GENERAL";
        $contrato->update();
    }

    public function partidas($clave_partida){
        $aux = json_decode($clave_partida);
        $partidas = "";
        foreach($aux->clave_partida as $key => $partida){
            $partidas .= $partida->partida.",";
        }

        return $partidas;
    }

    public function firmanteModal($id){
        return view('urgs.orden-compra.modals.agregar_firmante_modal')->with(['id' => $id]);
    }

    public function findUsuario($rfc){
        $usuario = User::usuarioRfc($rfc);

        if($usuario){
            $response = ['success' => true, 'data' => $usuario];
        }
        else{
            $response = ['success' => false, 'data' => ''];   
        }

        return $response;
    }

    public function firmanteSave(Request $request){
        try {
            $firmante = new OrdenCompraFirma();
            $firmante->rfc = $request->input('rfc');
            $firmante->nombre = $request->input('nombre');
            $firmante->primer_apellido = $request->input('primer_apellido');
            $firmante->segundo_apellido = $request->input('segundo_apellido');
            $firmante->puesto = $request->input('puesto');
            $firmante->telefono = $request->input('telefono');
            $firmante->extension = $request->input('extension');
            $firmante->correo = $request->input('correo');
            $firmante->identificador = $request->input('identificador');
            $firmante->contrato_id = $this->hashDecode(session()->get('contratoId'));
            $firmante->save();
            $this->hashEncode($firmante);
            if($request->input('identificador') == 1){
                $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
                $contrato->director = $request->input('nombre')." ".$request->input('primer_apellido')." ".$request->input('segundo_apellido');
                $contrato->update();
            }

            $response = ['success' => true, 'message' => "Firmante agregado corectamente.", 'data' => $firmante];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al agregar firmante."];
        }
        return $response;
    }

    public function firmanteModalEdit($id){
        $firmante = $this->hashEncode(OrdenCompraFirma::find($this->hashDecode($id)));
        
        return view('urgs.orden-compra.modals.edit_firmante_modal')->with(['firmante' => $firmante]);
    }


    public function firmanteEdit(Request $request){
        try {
            $firmante = OrdenCompraFirma::find($this->hashDecode($request->input('id')));
            $firmante->rfc = $request->input('rfc');
            $firmante->nombre = $request->input('nombre');
            $firmante->primer_apellido = $request->input('primer_apellido');
            $firmante->segundo_apellido = $request->input('segundo_apellido');
            $firmante->puesto = $request->input('puesto');
            $firmante->telefono = $request->input('telefono');
            $firmante->extension = $request->input('extension');
            $firmante->correo = $request->input('correo');
            $firmante->update();
            
            if($request->input('identificador') == 1){
                $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
                $contrato->director = $request->input('nombre')." ".$request->input('primer_apellido')." ".$request->input('segundo_apellido');
                $contrato->update();
            }

            $response = ['success' => true, 'message' => "Firmante editado corectamente.", 'data' => $firmante];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al agregar firmante."];
        }
        return $response;
    }

    public function altaContrato2(Request $request){
        $firmante = OrdenCompraFirma::where('contrato_id',$this->hashDecode(session()->get('contratoId')))->get();
        
        $tituloEtapa = "Alta del contrato";
        $contrato = Contrato::find($this->hashDecode($request->input('contrato_id')));
        $contrato->fecha_inicio = Carbon::createFromFormat('d/m/Y',$request->input('fecha_inicio')); 
        $contrato->fecha_fin = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fin'));
        $contrato->update();
        if($request->input('firmante_id') != null){
            $this->firmanteEdit($request);
        }
        else{
            $this->firmanteSave($request);
        }

        return  view('urgs.orden-compra.seguimiento.alta_contrato2')->with(['tituloEtapa' => $tituloEtapa,'contrato' => $contrato]);
    }

     public function altaContrato3(){
        $tituloEtapa = "Alta del contrato";        
        $fecha = OrdenCompraProveedor::where('urg_id', auth()->user()->urg_id)->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->get();
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));

        return  view('urgs.orden-compra.seguimiento.alta_contrato3')->with(['tituloEtapa' => $tituloEtapa, 'fecha' => $fecha[0], 'contrato' => $contrato]);
    }

    public function almacenModal(){
        return view('urgs.orden-compra.modals.agregar_almacen_modal');
    }

    public function responsableAlmacen($ccg){
        $almacen = $this->responsablesAlmacen($ccg);
        
        if($almacen['almacenes'] != []){
            $response = ['success' => true, 'data' => $almacen];
        }
        else{
            $response = ['success' => false, 'message' => 'No se encontraron almacenes relacionados con la clave del centro gestor.'];   
        }

        return $response;
    }

    public function almacenSave(Request $request){
        try{
            $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
            $contrato->ccg = $request->input('ccg');
            $contrato->responsable_almacen = $request->input('responsable');
            $contrato->direccion_almacen = $request->input('direccion');
            $contrato->telefono_almacen = $request->input('telefono');
            $contrato->update();
            $response = ['success' => true, 'message' => "Responsable de almacen agregado corectamente.", 'data' => $contrato];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al agregar al responsable de almacen."];
        }
        return $response;
    }

    public function almacenModalEdit(){
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        return view('urgs.orden-compra.modals.editar_almacen_modal')->with(['contrato' => $contrato]);
    }

    public function altaContrato4(){
        $tituloEtapa = "Alta del contrato";        
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));

        return  view('urgs.orden-compra.seguimiento.alta_contrato4')->with(['tituloEtapa' => $tituloEtapa, 'contrato' => $contrato]);
    }

    public function facturacionModal(){
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        return view('urgs.orden-compra.modals.editar_facturacion_modal')->with(['contrato' => $contrato]);
    }

    public function facturacionEdit(Request $request){
        try {
            $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
            $contrato->razon_social_fiscal = $request->input('razon_social');
            $contrato->rfc_fiscal = $request->input('rfc_fiscal');
            $contrato->uso_cfdi = $request->input('uso_cfdi');
            $contrato->domicilio_fiscal = $request->input('domicilio_fiscal');
            $contrato->update();

            $response = ['success' => true, 'message' => "Datos de facturación editados corectamente.", 'data' => $contrato];

        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al actualizar datos de facturación."];
        }
        
        return $response;
    }

    public function altaContrato5(){
        $tituloEtapa = "Alta del contrato";        
        $archivos = ContratoMarcoUrg::select('numero_archivo_adhesion','contrato_marco_id')->where('urg_id',auth()->user()->urg_id)->where('estatus', true)->get();
        $archivos = $this->hashEncodeIdClave($archivos,'contrato_marco_id','contrato_m_id');
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));

        return view('urgs.orden-compra.seguimiento.alta_contrato5')->with(['tituloEtapa' => $tituloEtapa,'archivos'=>$archivos,'contrato' => $contrato]);
    }

    public function revisarContrato(Request $request){
        $tituloEtapa = "Alta del contrato"; 
        $fechaFallo = HabilitarProveedore::fechaFallo(session()->get('proveedorId'),$this->hashDecode($request->input('contrato_m_id')));
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        $contrato->telefono_urg = $request->input('telefono_urg');
        $contrato->oficio_adhesion = $request->input('oficio_adhesion');
        $contrato->antecedentes = $request->input('antecedente');
        $contrato->numero_contrato_marco = $request->input('numero_contrato');
        $contrato->contrato_marco_id = $this->hashDecode($request->input('contrato_m_id'));
        $contrato->fecha_contrato_marco = $fechaFallo[0]->created_at;
        $contrato->garantias_anexas = $request->input('garantias_anexas');
        $contrato->articulo = $request->input('articulo');
        $contrato->fecha_fallo = $fechaFallo[0]->fecha_adhesion;
        $contrato->update();

        $productos = OrdenCompraBien::contratoPedido($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId'));
        
        $subtotal = 0;
        foreach($productos as $producto){
            $subtotal += $producto->subtotal;
        }
        
        $total = ($subtotal*.16) + $subtotal;
        $entero = intval(floor($total));
        $decimal = intval(($total - floor($total)) * 100);
        $format = new \NumberFormatter('es-Es',\NumberFormatter::SPELLOUT);
        $totalLetra = $format->format($entero);

        $firmantes = $this->firmantes($contrato->id); 
        
        $pdf = \PDF::loadView('pdf.contrato_pedido',['contrato' => $contrato,'productos' => $productos,'totalLetra' => $totalLetra, 'decimal' => $decimal, 'firmantes' => $firmantes])->download()->getOriginalContent();
        Storage::disk('contrato_pedido')->put('contrato_pedido_'.$contrato->contrato_pedido.'.pdf', $pdf);
        // $pdf = \PDF::loadView('pdf.contrato_pedido',['contrato' => $contrato,'productos' => $productos,'totalLetra' => $totalLetra, 'decimal' => $decimal, 'firmantes' => $firmantes ]);
        // return $pdf->stream('contrato_pedido_'.$contrato->contrato_pedido.'.pdf');
        
        return  view('urgs.orden-compra.seguimiento.revisar_contrato')->with(['tituloEtapa' => $tituloEtapa, 'contrato' => $contrato]);   
    }

    public function firmantes($contrato_id){
        $firmantesAll = OrdenCompraFirma::firmantes($contrato_id);
        $tipoFirmante = ['titular','adquisiciones','proveedor','financiera','requiriente'];
        $firmantes = [];
        foreach($firmantesAll as $firmante){
            $firmantes[$tipoFirmante[$firmante->identificador-1]] =  ['nombre' => $firmante->nombre." ". $firmante->primer_apellido." ".$firmante->segundo_apellido, 'cargo' => $firmante->puesto, 'folio' => $firmante->folio_consulta,'sello' => $firmante->sello];
        }

        return $firmantes;
    }

    public function firmarContrato(){
        $tituloEtapa = "Alta del contrato"; 
        return view('urgs.orden-compra.seguimiento.firma')->with(['tituloEtapa' => $tituloEtapa]);
    }

    public function efirmaSave(Request $request){
        $firma = OrdenCompraFirma::select('id','rfc')->where('rfc',auth()->user()->rfc)->where('contrato_id',$this->hashDecode(session()->get('contratoId')))->get();

        $cer = base64_encode($request->file('archivo_cer')->get());
        $key = base64_encode($request->file('archivo_key')->get());
        $pass = base64_encode($request->input('contrasena'));
        
        $efirma = $this->efirma($cer,$key,$pass);
        
        if($efirma->error->code != 0){
            return redirect()->back()->with(['error' => $efirma->error->msg]);
        }
        
        if($efirma->data->RFC == auth()->user()->rfc){
            $firmante = OrdenCompraFirma::find($firma[0]->id);
            $firmante->folio_consulta = $efirma->data->folioConsulta;
            $firmante->sello = $efirma->data->sello;
            $firmante->fecha_firma = $efirma->data->fechaFirma;;
            $firmante->update();

            $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
            $contrato->estatus = 1;
            $contrato->update(); 

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            $ordenCompraEstatus->contrato_estatus_urg = json_encode(['mensaje' => "Enviado a firma", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->contrato_estatus_proveedor = json_encode(['mensaje' => "Has recibido el contrato", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->contrato_boton_urg = json_encode(['mensaje' => "Contrato", 'css' => 'boton-verde']);
            $ordenCompraEstatus->contrato_boton_proveedor = json_encode(['mensaje' => "Firmar contrato", 'css' => 'boton-verde']);
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "El contrato se creó correctamente. Se enviará para firma.", 'css' => 'alert-secondary']);
            $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Firma el contrato antes del ".$firmante->updated_at->addDay(2)->format('d/m/Y'), 'css' => 'alert-secondary']);
            $ordenCompraEstatus->update();

            $this->updateContrato();
        }
        else{
            return redirect()->back()->with(['error' => 'El RFC no coincide con el usuario.']);
        }

        return redirect()->route('orden_compra_urg.index',['id' => session()->get('ordenCompraEstatus')]);        
    }

    public function updateContrato(){
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        $productos = OrdenCompraBien::contratoPedido($contrato->orden_compra_id,$contrato->proveedor_id);
        
        $subtotal = 0;
        foreach($productos as $producto){
            $subtotal += $producto->subtotal;
        }
        
        $total = ($subtotal*.16) + $subtotal;
        $entero = intval(floor($total));
        $decimal = intval(($total - floor($total)) * 100);
        $format = new \NumberFormatter('es-Es',\NumberFormatter::SPELLOUT);
        $totalLetra = $format->format($entero);

        $firmantes = $this->firmantes($contrato->id); 
        
        $pdf = \PDF::loadView('pdf.contrato_pedido',['contrato' => $contrato,'productos' => $productos,'totalLetra' => $totalLetra, 'decimal' => $decimal, 'firmantes' => $firmantes])->download()->getOriginalContent();
        Storage::disk('contrato_pedido')->put('contrato_pedido_'.$contrato->contrato_pedido.'.pdf', $pdf);
    }

    public function envio(){
        $tituloEtapa = "Seguimiento del envío"; 
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        $fechaEntrega  = OrdenCompraProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
        $envio = $this->hashEncode(OrdenCompraEnvio::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', auth()->user()->urg_id)->get());
        $this->crearSession(['envioId' => $envio[0]->id,'ordeProveedor' => $fechaEntrega[0]->id]);
        $prorroga = OrdenCompraProrroga::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', auth()->user()->urg_id)->get();
        $cancelacion = CancelarCompra::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('seccion','envio')->get();
        
        
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

        $reportes = Reporte::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->where('etapa', 'envio')->get();

        $incidencias = Incidencia::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->where('etapa', 'envio')->get();

        return view('urgs.orden-compra.seguimiento.envio')->with(['tituloEtapa' => $tituloEtapa, 'contrato' => $contrato,'envio' => $envio[0], 'fechaEntrega' => $fechaEntrega[0], 'prorroga' => $prorroga,'penalizacion' => $penalizacion, 'diasDiferencia' => $diasDiferencia, 'cancelacion' => $cancelacion, 'reportes' => $reportes, 'incidencias' => $incidencias]);
    }


    public function penalizacion($diasDiferencia,$etapa){

        $productos = $etapa == 'envio'? OrdenCompraBien::productosPenalizacionEnvio($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId'),auth()->user()->urg_id) : OrdenCompraBien::productosPenalizacionSustitucion($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId'),auth()->user()->urg_id);

        if($diasDiferencia < -16){
            $diasDiferencia = -15;
        }
        $total = 0;
        foreach($productos as $producto){
            $total += $producto->cantidad * $producto->precio;
        }
        
        return ($total * .01) * ($diasDiferencia * -1);

    }


    public function reporteModal($etapa){
        $combos = ['envio' => ['Estado de mi pedido'],'facturacion' => ['Retraso en la factura', 'Errores constantes en los datos', 'Comunicación'] ];

        return view('urgs.orden-compra.modals.reporte_modal')->with(['combos' => $combos[$etapa]]);
    }

    public function reporteSave(Request $request){
        $reporte = new Reporte();
        $reporte->id_reporte = str_replace('-','',session()->get('ordenCompraReqId'))."R".date('dmY'); 
        $reporte->motivo = $request->input('motivo');
        $reporte->descripcion = $request->input('descripcion');
        $reporte->etapa = $request->input('seccion');
        $reporte->reporta = 2;
        $reporte->urg_id = auth()->user()->urg_id;
        $reporte->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
        $reporte->proveedor_id = session()->get('proveedorId');
        $reporte->save();

        $reportes = Reporte::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->get();
        
        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
        if($request->input('seccion') == 'envio'){
            $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "Se generó un reporte", 'css' => 'text-rojo-estatus']);
            $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "Se generó un reporte", 'css' => 'text-rojo-estatus']);
        }
        if($request->input('seccion') == 'facturacion'){
            $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Se generó un reporte", 'css' => 'text-rojo-estatus']);
            $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Se generó un reporte", 'css' => 'text-rojo-estatus']);
        }
        $ordenCompraEstatus->update();
        return ['success' => true,'data' => $reporte];
    }

    public function incidenciaModal($etapa){
        $combos = ['envio' => ['Comunicación', 'Retraso en la entrega'], 'facturacion' => ['Retraso en la factura', 'Errores constantes en los datos', 'Comunicación'] ];

        return view('urgs.orden-compra.modals.incidencia_modal')->with(['combos' => $combos[$etapa]]);
    }

    public function incidenciaSave(Request $request){
        $incidencia = new Incidencia();
        $incidencia->id_incidencia = str_replace('-','',session()->get('ordenCompraReqId'))."I".date('dmY'); 
        $incidencia->motivo = $request->input('motivo');
        $incidencia->descripcion = $request->input('descripcion');
        $incidencia->etapa = $request->input('seccion');
        $incidencia->reporta = 2;
        $incidencia->user_creo = auth()->user()->id;
        $incidencia->urg_id = auth()->user()->urg_id;
        $incidencia->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
        $incidencia->proveedor_id = session()->get('proveedorId');
        $incidencia->save();

        $incidencias = Incidencia::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->get();
        
        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
         if($request->input('seccion') == 'envio'){    
            $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "Se abrió una incidencia", 'css' => 'text-rojo-estatus']);
            $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "Se abrió una incidencia", 'css' => 'text-rojo-estatus']);
        }
         if($request->input('seccion') == 'facturacion'){
            $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Se abrió una incidencia", 'css' => 'text-rojo-estatus']);
            $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Se abrió una incidencia", 'css' => 'text-rojo-estatus']);
         }
        $ordenCompraEstatus->update();
        return ['success' => true,'data' => $incidencia];
    }

    public function prorrogaModal(){
        return view('urgs.orden-compra.modals.prorroga_modal');
    }

    public function prorrogaUpdate(Request $request){
        try {
            $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
            $prorroga = OrdenCompraProrroga::find($this->hashDecode($request->input('prorroga')));
            $prorroga->estatus = $request->input('aceptada')? 1 : 2;
            $prorroga->motivo_urg = $request->input('motivo');
            $prorroga->descripcion_urg = $request->input('descripcion');
            $prorroga->unidad_administrativa = $contrato->area_requiriente;
            $prorroga->nombre_firma = $request->input('nombre_firmante');
            $prorroga->cargo_firma = $request->input('cargo_firmante');
            $prorroga->correo_firma = $request->input('correo_firmante');
            $prorroga->fecha_aceptacion = date(now());
            $prorroga->num_contrato_pedido = $contrato->contrato_pedido;
            $prorroga->update();

            $ordenProveedor = OrdenCompraProveedor::find(session()->get('ordeProveedor'));
            
            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            if($prorroga->estatus == 1){
                $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "Prórroga aceptada", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "Prórroga aceptada", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Prórroga aceptada. Nueva fecha de entrega: ".$prorroga->fecha_entrega_compromiso->format('d/m/Y'), 'css' => 'alert-secondary']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Nueva fecha de entrega ".$prorroga->fecha_entrega_compromiso->format('d/m/Y'), 'css' => 'alert-secondary']);
            }
            else{
                $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "Prórroga rechazada", 'css' => 'text-rojo-estatus']);
                $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "Prórroga rechazada", 'css' => 'text-rojo-estatus']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Prórroga rechazada. Fecha de entrega ".$ordenProveedor->fecha_entrega->format('d/m/Y'), 'css' => 'alert-danger']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Prórroga rechazada. Fecha de entrega ".$ordenProveedor->fecha_entrega->format('d/m/Y'), 'css' => 'alert-danger']); 
            }
            $ordenCompraEstatus->update();


            $pdf = \PDF::loadView('pdf.acuse_prorroga',['prorroga' => $prorroga])->download()->getOriginalContent();
            Storage::disk('acuse_prorroga')->put('acuse_prorroga_'.$prorroga->id.'.pdf', $pdf);

            return $response = ['success' => true, 'message' => "Prorroga confirmada correctamente.", 'data' => $prorroga];
            
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al confirmar prorroga.".$e];
        }

        return $response;
       
    }

    public function acuseModal(){
        return view('urgs.orden-compra.modals.acuse_modal');
    }

    public function acuseUpdate(Request $request){
        try {
            $prorroga = OrdenCompraProrroga::find($this->hashDecode($request->input('prorroga')));

            if($request->file('acuse')){
                $nombre = 'acuse_prorroga_firma_'.$prorroga->id.'.pdf';
               Storage::disk('acuse_prorroga')->put($nombre, File::get($request->file('acuse')));
               $prorroga->acuse = $nombre; 
            }
            $prorroga->update();

            return $response = ['success' => true, 'message' => "Acuse de prorroga subido corectamente.", 'data' => $prorroga];
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al subir acuse de prorroga."];
        }

        return $response;
    }

    public function sustitucion(){
        $tituloEtapa = "Aceptar pedido";        
        $contrato = $this->hashEncode(Contrato::where('urg_id', auth()->user()->urg_id)->where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->get());
        $envio = $this->hashEncode(OrdenCompraEnvio::find(session()->get('envioId')));
        $fechaEntrega  = OrdenCompraProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
        $prorroga = OrdenCompraProrroga::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', auth()->user()->urg_id)->get();
        $sustitucion = OrdenCompraSustitucion::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', auth()->user()->urg_id)->get();
        
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
        
        return view('urgs.orden-compra.seguimiento.sustitucion')->with(['tituloEtapa' => $tituloEtapa, 'contrato' => $contrato, 'envio' => $envio,'fechaEntrega' => $fechaEntrega[0], 'diasDiferencia' => $diasDiferencia, 'penalizacion' => $penalizacion, 'sustitucion' => $sustitucion, 'diasSustitucion' => $diasSustitucion]);
    }

    public function aceptarEnvio(Request $request){
        $envio = OrdenCompraEnvio::find(session()->get('envioId'));
        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
        try {
            if($request->estatus == 'aceptar'){
                $envio->fecha_entrega_aceptada = date(now());
                $envio->estatus = true;

                $ordenCompraEstatus->entrega_estatus_urg = json_encode(['mensaje' => "Pedido aceptado", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->entrega_boton_urg = json_encode(['mensaje' => "Entrega", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->entrega_estatus_proveedor = json_encode(['mensaje' => "Sin Sustitución", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->entrega_boton_proveedor = json_encode(['mensaje' => "Sustitución de bienes", 'css' => 'boton-gris']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Confirmación exitosa.", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Carga tu prefactura antes del " .$envio->fecha_entrega_aceptada->addDay(6)->format('d/m/Y'), 'css' => 'alert-secondary']);
                $ordenCompraEstatus->envio = 2;
                $ordenCompraEstatus->facturacion = 1;
                $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'texto-gris-estatus']);
                $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'texto-gris-estatus']);
                $ordenCompraEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Aceptar prefactura", 'css' => 'boton-verde']);
                $ordenCompraEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Enviar prefactura", 'css' => 'boton-verde']);

                $sustitucion = "";
            }
            if($request->estatus == 'rechazar') {
                $envio->fecha_entrega_aceptada = date(now());
                $envio->estatus = false;
                $ordenCompraEstatus->entrega_estatus_urg = json_encode(['mensaje' => "Sustitución registrada", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->entrega_estatus_proveedor = json_encode(['mensaje' => "Sustitución registrada", 'css' => 'text-gtis-estatus']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Sustitución registrada. Contacta al comprador", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Sustitución registrada. Contacta al proveedor", 'css' => 'alert-secondary']);

                $sustitucion = new OrdenCompraSustitucion();
                $sustitucion->sustitucion = str_replace('-','',session()->get('ordenCompraReqId'))."S".date('dmY');
                $sustitucion->urg_id = auth()->user()->urg_id;
                $sustitucion->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
                $sustitucion->usuario_id = auth()->user()->id;
                $sustitucion->proveedor_id = session()->get('proveedorId');
                $sustitucion->save();
                $this->crearSession(['sustitucionId' => $sustitucion->id]);
            }
            $envio->update();
            $ordenCompraEstatus->update();

            $response = ['success' => true, 'message' => "Pedido actualizado.", 'data' => $envio, 'data2' => $sustitucion];
                        
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al actualizar pedido"];
        }

        return $response;
    }

    public function datosFacturacion(){
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        return view('urgs.orden-compra.modals.datos_facturacion_modal')->with(['contrato' => $contrato]);
    }

    public function productosSustituirModal(){
        $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
        $bienes = $this->hashEncode(OrdenCompraBien::aceptados($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId')));
        $combos = ['Plazo demasiado largo', 'Falta de comunicación', 'Justificación no válida'];

        return view('urgs.orden-compra.modals.productos_sustituir_modal')->with(['contrato' => $contrato, 'bienes' => $bienes, 'combos' => $combos]);
    }    

    public function acuseSustitucion(Request $request){
        try{
            foreach($request->input('producto') as $key => $value){
                $bien = OrdenCompraBien::find($this->hashDecode($key));
                $bien->estatus = 3;
                $bien->update();
            }

            $sustitucion = OrdenCompraSustitucion::find(session()->get('sustitucionId'));
            $sustitucion->motivo = $request->input('motivo');
            $sustitucion->descripcion = $request->input('descripcion');
            $contrato = Contrato::find($this->hashDecode(session()->get('contratoId')));
            $envio = $this->hashEncode(OrdenCompraEnvio::find(session()->get('envioId')));
            $bienes = OrdenCompraBien::sustitucion($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId'));

            $subtotal = 0;
            foreach($bienes as $bien){
                $subtotal += $bien->subtotal;
            }
            
            $total = ($subtotal*.16) + $subtotal;
            $entero = intval(floor($total));
            $decimal = intval(($total - floor($total)) * 100);
            $format = new \NumberFormatter('es-Es',\NumberFormatter::SPELLOUT);
            $totalLetra = $format->format($entero);

            $pdf = \PDF::loadView('pdf.acuse_sustitucion',['contrato' => $contrato,'bienes' => $bienes,'sustitucion' => $sustitucion, 'envio' => $envio, 'subtotal' => $subtotal, 'total' => $total, 'totalLetra' => $totalLetra, 'decimal' => $decimal])->download()->getOriginalContent();
            Storage::disk('acuse_sustitucion')->put('acuse_sistitucion_'.$contrato->contrato_pedido.'.pdf', $pdf);
            
            $sustitucion->archivo_acuse_sustitucion = 'acuse_sistitucion_'.$contrato->contrato_pedido.'.pdf';
            $sustitucion->update();


            $response = ['success' => true, 'message' => "Acuse de sustitución creado correctamente.", 'data' => $sustitucion];
        } catch(\Exception $e){
            $response = ['success' => false, 'message' => "Error al generar el acuse"];
        }
        
        return $response;
    }

    public function aceptarSustitucion(){
        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
        $sustitucion = OrdenCompraSustitucion::find(session()->get('sustitucionId'));
        try {
            $sustitucion->aceptado = 1;
            $sustitucion->fecha_aceptada = date(now());
            $sustitucion->update();

            $ordenCompraEstatus->entrega_estatus_urg = json_encode(['mensaje' => "Sustitución aceptada", 'css' => 'text-verde-estatus']);
            $ordenCompraEstatus->entrega_boton_urg = json_encode(['mensaje' => "Sustitución de bienes", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->entrega_estatus_proveedor = json_encode(['mensaje' => "Sustitución aceptada", 'css' => 'text-verde-estatus']);
            $ordenCompraEstatus->entrega_boton_proveedor = json_encode(['mensaje' => "Sustitución de bienes", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Confirmación exitosa.", 'css' => 'alert-secondary']);
            $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Carga tu prefactura antes del " .$sustitucion->fecha_aceptada->addDay(5)->format('d/m/Y'), 'css' => 'alert-secondary']);
            $ordenCompraEstatus->facturacion = 1;
            $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'texto-gris-estatus']);
            $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'texto-gris-estatus']);
            $ordenCompraEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Aceptar prefactura", 'css' => 'boton-verde']);
            $ordenCompraEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Enviar prefactura", 'css' => 'boton-verde']);
            $ordenCompraEstatus->update();

            $response = ['success' => true, 'message' => "Sustitución aceptada correctamente."];
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Error al aceptar la sustitución"];   
        }

        return $response;
    }

    public function facturacion(){
        $tituloEtapa = "Facturación";        
        
        $sustitucion = OrdenCompraSustitucion::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', auth()->user()->urg_id)->get();

        $envio = OrdenCompraEnvio::find(session()->get('envioId'));

        $facturacion = OrdenCompraFactura::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', auth()->user()->urg_id)->get();

        
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

        $reportes = Reporte::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->where('etapa', 'facturacion')->get();

        $incidencias = Incidencia::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->where('etapa', 'facturacion')->get();

        $facturacionCorrecciones = [];
        if($facturacion != '[]'){
            $facturacionCorrecciones = FacturasCorreccion::where('orden_compra_facturas_id', $facturacion[0]->id)->orderByDesc('id')->limit(1)->get();
            $facturacion = $this->hashEncode($facturacion);
            $this->crearSession(['facturacionId' => $facturacion[0]->id]);
            if($sustitucion != '[]'){
                $diasRestan = Carbon::parse($sustitucion[0]->fecha_aceptada->addDay(7))->diffInDays($facturacion[0]->fecha_factura_envio, false) * -1;
            }
            else{
                $diasRestan = Carbon::parse($envio->fecha_entrega_aceptada->addDay(7))->diffInDays($facturacion[0]->fecha_factura_envio, false) * -1;
            }
        }

        return view('urgs.orden-compra.seguimiento.facturacion')->with(['tituloEtapa' => $tituloEtapa, 'diasRestan' => $diasRestan,'facturacion' => $facturacion,'penalizacionSustitucion' => $penalizacionSustitucion, 'penalizacionEnvio' => $penalizacionEnvio, 'diasPenalizacionEnvio' => $diasPenalizacionEnvio, 'diasPenalizacionSustitucion' => $diasPenalizacionSustitucion, 'reportes' => $reportes, 'incidencias' => $incidencias, 'facturacionCorrecciones' => $facturacionCorrecciones]);
    }

    public function solicitarCambiosModal(){
        $combos = ['Razón social/RFC', 'Forma de pago', 'Metodo de pago', 'Monto', 'Uso del CFDI', 'Domicilio fiscal'];

        return view('urgs.orden-compra.modals.solicitar_cambios_modal')->with(['combos' => $combos]);
    }

    public function solicitarCambioSave(Request $request){
        try {
            $facturacionCorreccion = new FacturasCorreccion();
            $facturacionCorreccion->tipo_correccion = $request->input('dato_corregir');
            $facturacionCorreccion->descripcion = $request->input('descripcion');
            $facturacionCorreccion->tipo_factura = $request->input('tipo_factura');
            $facturacionCorreccion->orden_compra_facturas_id = session()->get('facturacionId');
            $facturacionCorreccion->save();  

            $facturacion = OrdenCompraFactura::find(session()->get('facturacionId'));
            $facturacion->contador_rechazos_prefactura +=1;
            $facturacion->update(); 

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Prefactura rechazada", 'css' => 'text-rojo-estatus']);
            $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Prefactura rechazada", 'css' => 'text-rojo-estatus']);
            $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Se rechazó el archivo. Corrige y adjunta.", 'css' => 'alert-warning']);
            $ordenCompraEstatus->update();
            
            $response = ['success' => true, 'message' => "Solicitud de cambio registrada.", 'data' => $facturacionCorreccion];

        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Solicitud de cambio no registrada.".$e];
        }
        return $response;
    }

    public function aceptarFactura(){
        try {
            $facturacion = OrdenCompraFactura::find(session()->get('facturacionId'));
            $facturacion->estatus_prefactura = 1;
            $facturacion->fecha_prefactura_aceptada = date(now());
            $facturacion->update(); 

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Prefactura aceptada", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Prefactura aceptada", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Factura en SAP GRP", 'css' => 'boton-verde']);
            $ordenCompraEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Enviar factura", 'css' => 'boton-verde']);
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Confirmación exitosa.", 'css' => 'alert-secondary']);
            $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Adjuntar la factura timbrada.", 'css' => 'alert-secondary']);
            $ordenCompraEstatus->update();

            $response = ['success' => true, 'message' => "Prefactura aceptada corectamente."];
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Prefactura no pudo ser aceptada corectamente."];
        }

        return $response;

    }

    public function aceptarSapModal(){
        return view('urgs.orden-compra.modals.aceptar_sap_modal');
    }

    public function facturaEnSap(Request $request){
         try {
            $facturacion = OrdenCompraFactura::find(session()->get('facturacionId'));
            $facturacion->estatus_factura = 1;
            $facturacion->fecha_sap = Carbon::createFromFormat('d/m/Y',$request->input('fecha_sap'));
            $facturacion->update(); 

            $pago = new OrdenCompraPago();
            $pago->urg_id = auth()->user()->urg_id;
            $pago->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
            $pago->proveedor_id = session()->get('proveedorId');
            $pago->save();

            $this->crearSession(['pagoId' => $pago->id]);

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            $ordenCompraEstatus->facturacion = 2;
            $ordenCompraEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "Factura en SAP GRP", 'css' => 'text-verde-estatus']);
            $ordenCompraEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "Factura en SAP GRP", 'css' => 'text-verde-estatus']);
            $ordenCompraEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Factura", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Factura", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Tienen hasta el ".Carbon::now()->addDay(21)->format('d/m/Y')." para realizar el pago.", 'css' => 'alert-secondary']);
            $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            $ordenCompraEstatus->pago = 1;
            $ordenCompraEstatus->pago_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->pago_boton_urg = json_encode(['mensaje' => "Adjuntar CLC", 'css' => 'boton-verde']);
            $ordenCompraEstatus->pago_boton_proveedor = json_encode(['mensaje' => "Validar Pago", 'css' => 'boton-verde']);
            $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Pago','estatus' => "En espera", 'css' => 'gris']);
            $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Pago','estatus' => "En espera", 'css' => 'gris']);
            $ordenCompraEstatus->update();
            
            $response = ['success' => true, 'message' => "Factura en SAP GRP.<br> Recuerda que el pago debe realizarse antes de 20 días naturales.", 'data' => $facturacion];
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "La factura no pudo actualizarse."];
        }

        return $response; 
    }

    public function pago(){
        $tituloEtapa = "Confirmación de pago";
        $pago = OrdenCompraPago::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->get();
        $retraso = Retraso::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->get();

        if($pago != '[]'){
            $this->crearSession(['pagoId' => $pago[0]->id]);
        }

        return view('urgs.orden-compra.seguimiento.pago')->with(['tituloEtapa' => $tituloEtapa,'pago' => $pago, 'retraso' => $retraso]);
    }

    public function comprobanteClcModal(){
        return view('urgs.orden-compra.modals.comprobante_clc_modal');
    }

    public function comprobanteClcSave(Request $request){
        try {
            $pago = OrdenCompraPago::find(session()->get('pagoId'));
            $pago->fecha_ingreso = Carbon::createFromFormat('d/m/Y',$request->input('fecha_clc'));

            if($request->file('archivo_clc')){
                $archivo_nombre = $request->file('archivo_clc')->getClientOriginalName();
                Storage::disk('comprobante_clc')->put($archivo_nombre, File::get($request->file('archivo_clc')));
                $pago->archivo_clc = $archivo_nombre;
            }
            $pago->update();

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            $ordenCompraEstatus->pago_estatus_urg = json_encode(['mensaje' => "En proceso", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "En proceso", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->pago_boton_urg = json_encode(['mensaje' => "CLC", 'css' => 'boton-verde']);
            $ordenCompraEstatus->update();

            $response = ['success' => true, 'message' => "Pago registrado.", 'data' => $pago];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "Pago no registrado."];
        }

        return $response;
    }

    public function retrasoModal(){
        $combos = ['Autorización', 'Técnico'];
        return view('urgs.orden-compra.modals.retraso_modal')->with(['combos' => $combos]);
    }

    public function retrasoSave(Request $request){
        try {
            $retraso = new Retraso();
            $retraso->id_retraso = str_replace('-','',session()->get('ordenCompraReqId'))."RP".date('dmY'); 
            $retraso->motivo = $request->input('motivo');
            $retraso->descripcion = $request->input('descripcion');
            $retraso->urg_id = auth()->user()->urg_id;
            $retraso->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
            $retraso->proveedor_id = session()->get('proveedorId');
            $retraso->save();

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            $ordenCompraEstatus->pago_estatus_urg = json_encode(['mensaje' => "Reporte de retraso", 'css' => 'text-rojo-estatus']);
            $ordenCompraEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "Reporte de retraso", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->update();

            $response = ['success' => true, 'message' => "Retraso registrado.", 'data' => $retraso];
        } catch (\Exception $e) {
          $response = ['success' => false, 'message' => "Retraso no registrado."];
        }

        return $response;
    }


    public function evaluacion(){
        $tituloEtapa = "Evaluación";

        $productos = $this->hashEncode(OrdenCompraBien::evaluacion($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId')));

        $evaluacionProveedor = $this->hashEncode(OrdenCompraEvaluacionProveedor::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id',session()->get('proveedorId'))->where('urg_id',auth()->user()->urg_id)->get());

        if($evaluacionProveedor != '[]'){
            return redirect()->route('orden_compra_urg.evaluacion_edit',['id' => $evaluacionProveedor[0]->id_e]);
        }

        return view('urgs.orden-compra.seguimiento.evaluacion')->with(['tituloEtapa' => $tituloEtapa, 'productos' => $productos]);
    }

    public function evaluacionSave(Request $request){
        try {
            $evaluacionProveedor = new OrdenCompraEvaluacionProveedor();
            $evaluacionProveedor->general = $request->input('calificacion_general');
            $evaluacionProveedor->comunicacion = $request->input('calificacion_comunicacion');
            $evaluacionProveedor->calidad = $request->input('calificacion_calidad');
            $evaluacionProveedor->tiempo = $request->input('calificacion_tiempo');
            $evaluacionProveedor->mercancia = $request->input('calificacion_mercancia');
            $evaluacionProveedor->facturas = $request->input('calificacion_factura');
            $evaluacionProveedor->proceso = $request->input('calificacion_proceso');
            $evaluacionProveedor->opinion = $request->input('opinion');
            $evaluacionProveedor->comentario = $request->input('comentario_proveedor');
            $evaluacionProveedor->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
            $evaluacionProveedor->urg_id = auth()->user()->urg_id;
            $evaluacionProveedor->proveedor_id = session()->get('proveedorId');
            $evaluacionProveedor->save();

            $evaluacionProveedor = $this->hashEncode($evaluacionProveedor);

            foreach($request->input('producto') as $key => $bien){
                if($bien){
                    $producto = new OrdenCompraEvaluacionProducto();
                    $producto->calificacion = $bien;
                    $producto->comentario = $request->input('comentario')[$key];
                    $producto->urg_id = auth()->user()->urg_id;
                    $producto->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
                    $producto->producto_id = $this->hashDecode($key);
                    $producto->save();
                }
            }

            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatus')));
            $ordenCompraEstatus->evaluacion_estatus_urg = json_encode(['mensaje' => "Evaluada", 'css' => 'text-verde-estatus']);
            $ordenCompraEstatus->evaluacion_estatus_proveedor = json_encode(['mensaje' => "Evaluada", 'css' => 'text-gris-estatus']);
            $ordenCompraEstatus->evaluacion_boton_urg = json_encode(['mensaje' => "Evaluación", 'css' => 'boton-dorado']);
            $ordenCompraEstatus->evaluacion_boton_proveedor =json_encode(['mensaje' => "Ver evaluación", 'css' => 'boton-verde']);
            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Gracias por tu evaluación. Ha concluido el proceso.", 'css' => 'alert-secondary']);
            $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Encuesta','estatus' => "Evaluada", 'css' => 'verde']);
            $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Encuesta','estatus' => "Evaluada", 'css' => 'verde']);
            $ordenCompraEstatus->finalizada = 1;
            $ordenCompraEstatus->update();

            return redirect()->route('orden_compra_urg.evaluacion_edit',['id' => $evaluacionProveedor->id_e])->with('error', 'success');

        } catch (\Exception $e) {
           return redirect()->back()->with('error', 'error');
        }
    }

    public function evaluacionEdit($id){
        $tituloEtapa = "Evaluación";

        $productos = $this->hashEncode(OrdenCompraBien::evaluacion($this->hashDecode(session()->get('ordenCompraId')),session()->get('proveedorId')));

        $productosEvaluados = $this->hashEncode(OrdenCompraEvaluacionProducto::where('orden_compra_id',$this->hashDecode(session()->get('ordenCompraId')))->where('urg_id',auth()->user()->urg_id)->get());

        $evaluacionProveedor = OrdenCompraEvaluacionProveedor::find($this->hashDecode($id));

        return view('urgs.orden-compra.seguimiento.evaluacion_edit')->with(['tituloEtapa' => $tituloEtapa, 'evaluacionProveedor' => $evaluacionProveedor, 'productos' => $productos, 'productosEvaluados' => $productosEvaluados]);
    }
}