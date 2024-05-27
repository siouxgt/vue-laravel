<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompra;
use App\Models\OrdenCompraBien;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraProveedor;
use App\Traits\HashIdTrait;
use App\Traits\SessionTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class OrdenCompraController extends Controller
{
    use HashIdTrait, SessionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->eliminarSession(['ordenCompraId']);
        $todasCabms = OrdenCompraBien::todasCabmsUrg(auth()->user()->urg_id)[0];
        $cabmsConfirmadas = OrdenCompraBien::cabmsAceptadasUrg(auth()->user()->urg_id)[0];
        $cabmsRechazadas = OrdenCompraBien::cabmsRechazadasUrg(auth()->user()->urg_id)[0];

        $totalOC = OrdenCompra::where('urg_id',auth()->user()->urg_id)->count();
        
        return view('urgs.orden-compra.index')->with(['todasCabms' => $todasCabms, 'cabmsConfirmadas' => $cabmsConfirmadas, 'cabmsRechazadas' => $cabmsRechazadas, 'totalOC' => $totalOC]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrdenCompra  $ordenCompra
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->eliminarSession(['nombreProveedor','ordenCompraEstatus','ordenCompraReqId','proveedorId','contratoId', 'envioId','ordeProveedor', 'sustitucionId','facturacionId','pagoId']);
        $ordenCompra = $this->hashEncode(OrdenCompra::find($this->hashDecode($id)));

        $this->crearSession(['ordenCompraId' => $ordenCompra->id_e]);

        return view('urgs.orden-compra.show')->with(['ordenCompra' => $ordenCompra]);
    }

    public function data(){
        $ordenes = $this->hashEncode(OrdenCompra::allOrdenUrg(auth()->user()->urg_id));
        $ordenes = $this->hashEncodeId($ordenes,'solicitud_id');
        
        return Datatables::of($ordenes)->toJson();
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
        $this->crearSession(['proveedorId' => $this->hashDecode($proveedor)]);

        return view('urgs.orden-compra.seguimiento.acuse_confirmada')->with(['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados]);
    }

    public function exportOrdenConfirmada(){
        $datosOrdenCompra =  OrdenCompra::datosOrdenCompraConfirmada($this->hashDecode(session()->get('ordenCompraId')));
        $datosFechaEntrega =  OrdenCompraProveedor::obtenerFechaEntrega($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
        $productosConfirmados =  OrdenCompraProveedor::todosProductosConfirmados($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
        $pdf = \PDF::loadView('pdf.acuse_compra_confirmada', ['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados])->setPaper('A4', 'landscape');
        return $pdf->download('acuse_orden_compra_confirmada' . $datosOrdenCompra[0]->orden_compra . '.pdf');
    }

   
}
