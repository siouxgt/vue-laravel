<?php

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraBien;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraProveedor;
use App\Models\ProveedorFichaProducto;
use App\Models\SolicitudCompra;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;

class SolicitudCompraController extends Controller
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
        $auxCarrito = json_decode($request->productos);
        foreach($auxCarrito as $key => $value){
            $carrito[$key] = CarritoCompra::find($this->hashDecode($value->id_producto));
            $carrito[$key]->comprado = 1;
            $carrito[$key]->update(); 
            $producto_id[$key] = $carrito[$key]->proveedor_ficha_producto_id;
        }

        
        $ordenCompra = $this->storeOrdenCompra($carrito[0]);

        $productos = $this->producto($producto_id,$carrito, $ordenCompra->id);

        $solicitud = new SolicitudCompra();
        $solicitud->orden_compra = $ordenCompra->orden_compra;
        $solicitud->requisicion = $carrito[0]->requisicion->requisicion;
        $solicitud->urg = $request->input('ccg');
        $solicitud->responsable = $request->input('responsable');
        $solicitud->telefono = $request->input('telefono');
        $solicitud->correo = $request->input('correo');
        $solicitud->extension = $request->input('extension');
        $solicitud->direccion_almacen = $request->input('direccion');
        $solicitud->responsable_almacen = $request->input('responsable_almacen');
        $solicitud->telefono_almacen = $request->input('telefono_almacen');
        $solicitud->correo_almacen = $request->input('correo_almacen');
        $solicitud->extension_almacen = $request->input('extension_almacen');
        $solicitud->condicion_entrega = $request->input('condiciones_entrega');
        $solicitud->producto = json_encode($productos);
        $solicitud->orden_compra_id = $ordenCompra->id;
        $solicitud->urg_id = auth()->user()->urg_id;
        $solicitud->requisicion_id = $carrito[0]->requisicion_id;
        $solicitud->usuario_id = auth()->user()->id;
        $solicitud->save();
        $solicitud = $this->hashEncode($solicitud);

       return redirect()->route('solucitud_compra.show',['solucitud_compra' => $solicitud->id_e]);
       
    }

    public function storeOrdenCompra($carrito){
        
        $consecutivo  = OrdenCompra::where('requisicion_id',$carrito->requisicion_id)->count();
        $consecutivo++;
        
        $orden = new OrdenCompra();
        $orden->orden_compra = $carrito->requisicion->requisicion."-".$consecutivo;
        $orden->urg_id = auth()->user()->urg_id;
        $orden->requisicion_id = $carrito->requisicion_id;
        $orden->usuario_id = auth()->user()->id;
        $orden->save();
    
        return $orden;
    }

    public function producto($productos, $carrito, $ordenCompra_id){

        foreach($productos as $key => $producto){
            $fichaProductos[$key] = ProveedorFichaProducto::find($producto);
            $fichaProductos[$key]->cantidad = $carrito[$key]->cantidad_producto;
            $fichaProductos[$key]->color_seleccionado = $carrito[$key]->color;
        }
        $proveedores = [];
        $productos = [];
        foreach($fichaProductos as $key => $producto)
        {
            $proveedores[$key] = $producto->proveedor_id;
        }

        $proveedores = array_values(array_unique($proveedores));
        $contCarrito = 0;

        foreach($proveedores as $key => $proveedor){
            $cont = 0;
            foreach($fichaProductos as $key2 => $producto){

                if($producto->proveedor_id == $proveedor){
                    $data[$cont] = [
                        'producto' => $producto->nombre_producto,
                        'imagen' => $producto->foto_uno,
                        'nombre' => $producto->nombre_producto,
                        'cabms' => $producto->catProducto->cabms,
                        'unidad_medida' => $producto->catProducto->medida,
                        'cantidad' => $producto->cantidad,
                        'precio' => $producto->precio_unitario,
                        'tamanio' => $producto->tamanio,
                        'color' => $producto->color_seleccionado,
                        'marca' => $producto->marca,
                    ];
                    $nombreProveedor = $producto->proveedor->nombre;
                    $cont++;
                }
            }
            $contCarrito++;
            $productos['producto'][$key] = ['proveedor' => $nombreProveedor, 'data' => $data]; 
            $data = [];
        }

        $compraBienes = $this->storeOrdenCompraBienes($fichaProductos,$ordenCompra_id,$carrito[0]->requisicion_id);
        $ordenEstatus = $this->storeOrdenCompraEstatus($proveedores,$ordenCompra_id);

        return $productos;
    }

    public function storeOrdenCompraBienes($fichaProductos,$ordenCompra_id, $requisicion_id){
        
        foreach($fichaProductos as $producto){
            $bien = new OrdenCompraBien();
            $bien->cabms = $producto->catProducto->cabms;
            $bien->nombre = $producto->nombre_producto;
            $bien->cantidad = $producto->cantidad;
            $bien->precio = $producto->precio_unitario;
            $bien->medida = $producto->catProducto->medida;
            $bien->color = $producto->color_seleccionado; 
            $bien->tamanio = $producto->tamanio;
            $bien->proveedor_ficha_producto_id = $producto->id;
            $bien->proveedor_id = $producto->proveedor_id;
            $bien->urg_id = auth()->user()->urg_id;
            $bien->orden_compra_id = $ordenCompra_id;
            $bien->requisicion_id = $requisicion_id;
            $bien->save();
        }
    }

    public function storeOrdenCompraEstatus($proveedores,$ordenCompra_id){
        foreach($proveedores as $proveedor){
            $ordenEstatus = new OrdenCompraEstatus();
            $ordenEstatus->confirmacion_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
            $ordenEstatus->confirmacion_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
            $ordenEstatus->confirmacion_boton_urg = json_encode(['mensaje' => "Orden de compra", 'css' => 'boton-verde']);
            $ordenEstatus->confirmacion_boton_proveedor = json_encode(['mensaje' => "Orden de compra", 'css' => 'boton-verde']);
            $ordenEstatus->contrato_estatus_urg = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->contrato_estatus_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->contrato_boton_urg = json_encode(['mensaje' => "Alta de contrato", 'css' => 'boton-gris']);
            $ordenEstatus->contrato_boton_proveedor = json_encode(['mensaje' => "Firmar contrato", 'css' => 'boton-gris']);
            $ordenEstatus->envio_estatus_urg = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->envio_boton_urg = json_encode(['mensaje' => "Seguimiento", 'css' => 'boton-gris']);
            $ordenEstatus->envio_boton_proveedor = json_encode(['mensaje' => "Confirmar envío", 'css' => 'boton-gris']);
            $ordenEstatus->entrega_estatus_urg = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->entrega_estatus_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->entrega_boton_urg = json_encode(['mensaje' => "Aceptar pedido", 'css' => 'boton-gris']);
            $ordenEstatus->entrega_boton_proveedor = json_encode(['mensaje' => "Sustitución de bienes", 'css' => 'boton-gris']);
            $ordenEstatus->facturacion_estatus_urg = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->facturacion_estatus_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->facturacion_boton_urg = json_encode(['mensaje' => "Aceptar prefactura", 'css' => 'boton-gris']);
            $ordenEstatus->facturacion_boton_proveedor = json_encode(['mensaje' => "Enviar prefactura", 'css' => 'boton-gris']);
            $ordenEstatus->pago_estatus_urg = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->pago_boton_urg = json_encode(['mensaje' => "Adjuntar CLC", 'css' => 'boton-gris']);
            $ordenEstatus->pago_boton_proveedor = json_encode(['mensaje' => "Validar pago", 'css' => 'boton-gris']);
            $ordenEstatus->evaluacion_estatus_urg = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->evaluacion_estatus_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            $ordenEstatus->evaluacion_boton_urg = json_encode(['mensaje' => "Calificar compra", 'css' => 'boton-gris']);
            $ordenEstatus->evaluacion_boton_proveedor = json_encode(['mensaje' => "Ver evaluación", 'css' => 'boton-gris']);
            $ordenEstatus->indicador_urg = json_encode(['etapa' => 'Confirmación','estatus' => "En espera", 'css' => 'gris']);
            $ordenEstatus->indicador_proveedor = json_encode(['etapa' => 'Confirmación','estatus' => "En espera", 'css' => 'gris']);
            $ordenEstatus->orden_compra_id = $ordenCompra_id;
            $ordenEstatus->urg_id = auth()->user()->urg_id;
            $ordenEstatus->proveedor_id = $proveedor;
            $ordenEstatus->alerta_urg = json_encode(['mensaje' => "Tienes hasta el ".date('d/m/Y', strtotime(' +1 day'))." para cancelar tu compra", 'css' => 'alert-secondary']);
            $ordenEstatus->alerta_proveedor = json_encode(['mensaje' => "Tienes hasta el ".date('d/m/Y', strtotime(' +1 day'))." para confirmar la Orden", 'css' => 'alert-secondary']);
            $ordenEstatus->save();
            

            $ordenProveedor = new OrdenCompraProveedor();
            $ordenProveedor->urg_id = auth()->user()->urg_id;
            $ordenProveedor->orden_compra_id = $ordenCompra_id;
            $ordenProveedor->proveedor_id = $proveedor;
            $ordenProveedor->save(); 
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SolicitudCompra  $solicitudCompra
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $this->hashDecode($id);
        $solicitud = $this->hashEncode(SolicitudCompra::find($id));
        $solicitud->producto = json_decode($solicitud->producto);

        return view('urgs.carrito_compra.solicitud_compra_enviada')->with(['solicitud' => $solicitud]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SolicitudCompra  $solicitudCompra
     * @return \Illuminate\Http\Response
     */
    public function edit(SolicitudCompra $solicitudCompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SolicitudCompra  $solicitudCompra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SolicitudCompra $solicitudCompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SolicitudCompra  $solicitudCompra
     * @return \Illuminate\Http\Response
     */
    public function destroy(SolicitudCompra $solicitudCompra)
    {
        //
    }

    public function export(Request $request){
        $id = $this->hashDecode($request->input('solicitud'));
        $solicitud = SolicitudCompra::find($id);
        $solicitud->producto = json_decode($solicitud->producto);
       
        $pdf = \PDF::loadView('pdf.solicitud_compra_enviada',['solicitud' => $solicitud])->setPaper('A4', 'landscape');
        return $pdf->download('solicitud'.$solicitud->orden_compra.'.pdf');
        
    }
}
