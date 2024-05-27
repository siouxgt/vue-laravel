<?php

namespace App\Http\Controllers;

use App\Models\CatProducto;
use App\Models\ContratoMarco;
use App\Models\Mensaje;
use App\Models\OrdenCompraEvaluacionProducto;
use App\Models\OrdenCompraEvaluacionProveedor;
use App\Models\Proveedor;
use App\Models\ProveedorFichaProducto;
use App\Models\Urg;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AdminController extends Controller
{
    use HashIdTrait;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalContratos = ContratoMarco::all()->count();
        $contratos = $this->hashEncode(ContratoMarco::all());
        $proveedores = Proveedor::where('estatus',1)->count();
        $urgs = Urg::where('estatus',1)->count();
        $porLiberar = ContratoMarco::where('liberado',0)->count();
        $porVencer = count(ContratoMarco::porVencer());
        $vencidos = count(ContratoMarco::vencidos());
        $formularios = CatProducto::all()->count();
        $countPublicados = ProveedorFichaProducto::allPrublicados();
        $allProductos = ProveedorFichaProducto::allProductos();
        $allValidacionTec = ProveedorFichaProducto::allValidacionTec();

        return view('admin.admin_home')->with(['totalContratos'=>$totalContratos,'contratos'=>$contratos,'proveedores'=>$proveedores,'urgs'=>$urgs,'porLiberar'=>$porLiberar,'porVencer'=>$porVencer,'vencidos'=>$vencidos,'formularios'=>$formularios, 'countPublicados' => $countPublicados[0], 'allProductos' => $allProductos[0], 'allValidacionTec' => $allValidacionTec[0]]);
    }

    public function mensajes(){
        $sinLeer = Mensaje::countAdminSinLeer();
        return view('admin.mensaje')->with(['sinLeer' => $sinLeer]);
    }

    public function dataMensajes($id){
        switch ($id) {
            case 1: //mensajes
                $mensajes = $this->hashEncode(Mensaje::mensajesAdmin());
                break;
            case 2: //todos 
                $mensajes = $this->hashEncode(Mensaje::mensajesAdminAll());
                break;
            case 3: //enviados
                $mensajes = $this->hashEncode(Mensaje::mensajesEnviados(auth()->user()->id));
                break;
            case 4://archivados
                $mensajes = $this->hashEncode(Mensaje::mensajesAdminArchivado());
                break;
            case 5://eliminados
                $mensajes = $this->hashEncode(Mensaje::mensajesAdminEliminado());
                break;
            case 6://destacados
                $mensajes = $this->hashEncode(Mensaje::mensajesAdminDestacados());
                break;
            case 7://no leidos
                $mensajes = $this->hashEncode(Mensaje::mensajesAdminNoLeidos());
                break;
        }
                
        return Datatables::of($mensajes)->toJson();
    }

    public function destacarMensaje(Request $request){
        try {
            foreach($request->ids as $id){
                $mensaje = Mensaje::find($this->hashDecode($id));
                $mensaje->destacado = 1;
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => "Mensaje destacado."];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido destacado."];
        }
        return $response;
    }

    public function archivarMensaje(Request $request){
         try {
            foreach($request->ids as $id){
                $mensaje = Mensaje::find($this->hashDecode($id));
                $mensaje->archivado = 1;
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => "Mensaje archivado."];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido archivar."];
        }
        return $response;
    }

    public function eliminarMensaje(Request $request){
        try {
            foreach($request->ids as $id){
                $mensaje = Mensaje::find($this->hashDecode($id));
                $mensaje->eliminado = 1;
                $mensaje->update();
            }
            $response = ['success' => true, 'message' => "Mensaje eliminado."];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido eliminar."];
        }
        return $response;
    }

    public function leido(Request $request){
        try {
            $mensaje = Mensaje::find($this->hashDecode($request->input('id')));
            $mensaje->leido = 1;
            $mensaje->update();

            $response = ['success' => true];            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => "El mensaje no se a podido actualizar."];
        }

        return $response;
    }

    public function responderModal($id){
        $mensaje =  $this->hashEncode(Mensaje::mensaje($this->hashDecode($id)));
        return view('admin.modals.responder_mensaje_modal')->with(['mensaje' => $mensaje[0]]);
    }

    public function responderSave(Request $request){
        try {
            $mensaje = Mensaje::find($this->hashDecode($request->input('mensaje')));
            $mensaje->respuesta = $request->input('respuesta');
            $mensaje->leido = 1;
            $mensaje->update();

            $response = ['success' => true, 'message' => 'Mensaje respondido.'];            

        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al responder el mensaje.'];
        }
        return $response;
    }

    public function productosIndex(){
        
        return view('admin.productos.index');
    }

    public function cmModal($filtro){
        $contratosMarcos = $this->hashEncode(ContratoMarco::contratosProductos());
        $activa = json_decode($filtro)->cm;

        return view('admin.modals.contratos_marco')->with(['contratosMarcos' => $contratosMarcos, 'activa' => $activa]);
    }

    public function productosAdmin($filtro){
        $filtro = json_decode($filtro);
        if($filtro->cm != ""){
            $filtro->cm = $this->hashDecode($filtro->cm);
        }
        $filtro = json_encode($filtro);
        $productos = $this->hashEncode(ProveedorFichaProducto::allProductosAdmin($filtro));

        return view('admin.productos.producto')->with(['productos' => $productos]);
    }

    public function productoShowAdmin($id){
        $producto = $this->hashEncode(ProveedorFichaProducto::productoTiendaAdminShow($this->hashDecode($id)));
        $producto[0]->color = json_decode($producto[0]->color);
        $producto[0]->dimensiones = json_decode($producto[0]->dimensiones);
        $producto[0]->documentacion_incluida = json_decode($producto[0]->documentacion_incluida);
        $opiniones = OrdenCompraEvaluacionProducto::opinionesProducto($producto[0]->id);
        $opinionesProveedor = OrdenCompraEvaluacionProveedor::where('proveedor_id', $producto[0]->proveedor_id)->count();
        $countProductos = ProveedorFichaProducto::totalProductos($producto[0]->proveedor_id);
        $this->hashEncodeIdClave($producto[0],'proveedor_id','proveedor_id_e');
        
        return view('admin.productos.show')->with(['producto' => $producto[0], 'opiniones' => $opiniones, 'opinionesProveedor' => $opinionesProveedor, 'countProductos' => $countProductos[0]]);
    }

    public function opinionProducto($id){
        $opiniones = OrdenCompraEvaluacionProducto::opinionesProductoShow($this->hashDecode($id));
        $producto = $this->hashEncode(ProveedorFichaProducto::find($this->hashDecode($id)));
        $calificacionTotal = 0;
        foreach ($opiniones as $key => $value) {
            $calificacionTotal += $value->calificacion;
        }
        return view('admin.productos.opinion_producto')->with(['opiniones' => $opiniones, 'producto' => $producto, 'calificacionTotal' => $calificacionTotal]);
    }

   public function opinionProveedor($id){
     $opiniones = OrdenCompraEvaluacionProveedor::opinionesProveedorShow($this->hashDecode($id));
        $proveedor = $this->hashEncode(Proveedor::find($this->hashDecode($id)));        
        $calificacionTotal = 0;
        $comunicacionTotal = 0;
        $calidadTotal = 0;
        $tiempoTotal = 0;
        $mercanciaTotal = 0;
        $facturasTotal = 0;
        $procesoTotal = 0;
        if($opiniones != []){
            foreach($opiniones as $opinion){
                $calificacionTotal += $opinion->general;
                $comunicacionTotal += $opinion->comunicacion;
                $calidadTotal += $opinion->calidad;
                $tiempoTotal += $opinion->tiempo;
                $mercanciaTotal += $opinion->mercancia;
                $facturasTotal += $opinion->facturas;
                $procesoTotal += $opinion->proceso;
            }
        }

        return view('admin.productos.opinion_proveedor')->with(['opiniones' => $opiniones, 'proveedor' => $proveedor, 'calificacionTotal' => $calificacionTotal, 'comunicacionTotal' => $comunicacionTotal, 'calidadTotal' => $calidadTotal, 'tiempoTotal' => $tiempoTotal, 'mercanciaTotal' => $mercanciaTotal, 'facturasTotal' => $facturasTotal, 'procesoTotal' => $procesoTotal]);
   }
}
