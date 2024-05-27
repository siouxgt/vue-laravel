<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\OrdenCompraBien;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraFirma;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class FirmantesController extends Controller
{
    use HashIdTrait, ServicesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $totalContratos = count(Contrato::allFirmante(auth()->user()->rfc));
        $firmados = count(Contrato::firmados(auth()->user()->rfc));

        return view('firmantes.index')->with(['totalContratos' => $totalContratos, 'firmados' => $firmados]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $firma = OrdenCompraFirma::where('rfc',auth()->user()->rfc)->where('contrato_id', $this->hashDecode($request->input('contrato')))->get();
        
        $cer = base64_encode($request->file('archivo_cer')->get());
        $key = base64_encode($request->file('archivo_key')->get());
        $pass = base64_encode($request->input('contrasena'));
        
        $efirma = $this->efirma($cer,$key,$pass);
        
        if($efirma->error->code != 0){
            return $response = ['success'=> false, 'message' => $efirma->error->msg];
        }

        if($efirma->data->RFC == auth()->user()->rfc){
            $firmante = OrdenCompraFirma::find($firma[0]->id);
            $firmante->folio_consulta = $efirma->data->folioConsulta;
            $firmante->sello = $efirma->data->sello;
            $firmante->fecha_firma = $efirma->data->fechaFirma;;
            $firmante->update();
            
            $contrato = Contrato::find($this->hashDecode($request->input('contrato')));

            $this->updateContrato($contrato);
            
            $firmasTotales = OrdenCompraFirma::where('contrato_id', $this->hashDecode($request->input('contrato')))->count();
            $firmasCompletas = OrdenCompraFirma::where('contrato_id', $this->hashDecode($request->input('contrato')))->whereNotNull('sello')->count();

            if($firmasTotales == $firmasCompletas){

                $contrato->estatus = 2;
                $contrato->update(); 

                $idEstatus = OrdenCompraEstatus::select('id')->where('orden_compra_id', $contrato->orden_compra_id)->where('proveedor_id',$contrato->proveedor_id)->get();

                $ordenCompraEstatus = OrdenCompraEstatus::find($idEstatus[0]->id);
                $ordenCompraEstatus->contrato = 2;
                $ordenCompraEstatus->contrato_estatus_urg = json_encode(['mensaje' => "Completo", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->contrato_estatus_proveedor = json_encode(['mensaje' => "Completo", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->contrato_boton_urg = json_encode(['mensaje' => "Contrato", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->contrato_boton_proveedor = json_encode(['mensaje' => "Contrato", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Contrato','estatus' => "Completo", 'css' => 'verde']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Contrato','estatus' => "Completo", 'css' => 'verde']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "El contrato cuenta con todas las firmas.", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "El contrato cuenta con todas las firmas.", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->envio = 1;
                $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->envio_boton_urg = json_encode(['mensaje' => "Seguimiento", 'css' => 'boton-verde']);
                $ordenCompraEstatus->envio_boton_proveedor = json_encode(['mensaje' => "Confirmar envío", 'css' => 'boton-verde']);
                $ordenCompraEstatus->update();
            }

            $response = ['success' => true, 'message' => 'Firma de contrato correcta'];
        }
        else{
            $response = ['success' => false, 'message' => 'El RFC no coincide con el usuario.'];
        }

            return $response;
    }

    public function updateContrato($contrato){
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

    public function firmantes($contratoId){
        $firmantesAll = OrdenCompraFirma::firmantes($contratoId);
        $tipoFirmante = ['titular','adquisiciones','proveedor','financiera','requiriente'];
        $firmantes = [];
        foreach($firmantesAll as $firmante){
            $firmantes[$tipoFirmante[$firmante->identificador-1]] =  ['nombre' => $firmante->nombre." ". $firmante->primer_apellido." ".$firmante->segundo_apellido, 'cargo' => $firmante->puesto, 'folio' => $firmante->folio_consulta,'sello' => $firmante->sello];
        }

        return $firmantes;
    }

    public function data()
    {
        $contratos = $this->hashEncode(Contrato::allFirmante(auth()->user()->rfc));
        $firmante = ['titular','adquisiciones','proveedor','financiera','requiriente'];
        foreach($contratos as $key => $contrato){
            if($contrato->sello == ""){
                $contratos[$key]->fecha = Carbon::parse($contratos[$key]->created_at)->addDay(3)->diffInDays(now(), false);
            }else{
                $contratos[$key]->fecha = Carbon::parse($contratos[$key]->created_at)->addDay(3)->diffInDays($contrato->updated_at, false);
            }
            $firmas = OrdenCompraFirma::firmas($contrato->id);
            foreach($firmas as $firma){
                $aux = $firmante[$firma->identificador-1];
                $contratos[$key]->$aux = true;
            }
        }
        return Datatables::of($contratos)->toJson();
    }

    public function firmarModal(){
        return view('firmantes.firmar_modal');
    }
}
