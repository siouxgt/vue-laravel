<?php

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CarritoCompraController extends Controller
{

    use HashIdTrait, ServicesTrait;

    public function idUrg()
    {
        //return session('urg_id');
        return auth()->user()->urg_id;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("urgs.carrito_compra.index")->with($this->allProductosCarrito());
    }

    public function viewConfirmarOrdenCompra(Request $request)
    {
        $direcciones = $this->responsablesAlmacen(auth()->user()->urg->ccg);
        if(!$direcciones['success']){
           return redirect()->back()->with('error', $direcciones['message']);
        }
        $this->actualizarCarrito($request->productos);
        $productos = $this->allProductosCarritoConIva($request->productos);

       
        return view("urgs.carrito_compra.confirmacion_orden_compra")->with([ "datos_carrito" => $productos,'direcciones' => $direcciones]);
       
    }

    public function allProductosCarrito()
    {
        $arrayRequisiciones = [];
        $arrayProveedores = [];

        $cc = CarritoCompra::allProductosCarrito($this->idUrg(), 0);
        $cc = $this->hashEncode($cc);
        for ($i = 0; $i < count($cc); $i++) {
            $arrayRequisiciones[$i] = $cc[$i]->requisicion;
            $arrayProveedores[$i] = $cc[$i]->nombre;
        }
        $arrayRequisiciones = array_values(array_unique($arrayRequisiciones));
        $arrayProveedores = array_values(array_unique($arrayProveedores));

        $jsonReq = [];
        $jsonProv = [];
        $jsonTodos = [];

        for ($i = 0; $i < count($arrayRequisiciones); $i++) {
            $contProv = 0;
            for ($j = 0; $j < count($arrayProveedores); $j++) {
                $contador = 0;
                $contBien = count($cc);
                for ($k = 0; $k < $contBien; $k++) {
                    if ($cc[$k]->requisicion == $arrayRequisiciones[$i] && $cc[$k]->nombre == $arrayProveedores[$j]) {
                        $jsonTodos[$contador] =
                            array(
                                'carrito_compra_id' => $cc[$k]->id_e,
                                'cabms' => $cc[$k]->cabms,
                                'nombre_corto' => $cc[$k]->nombre_corto,
                                'marca' => $cc[$k]->marca,
                                'nombre_producto' => $cc[$k]->nombre_producto,
                                'tamanio' => $cc[$k]->tamanio,
                                'color' => $cc[$k]->color,
                                'cantidad_producto' => $cc[$k]->cantidad_producto,
                                'precio_unitario' => $cc[$k]->precio_unitario,
                                'medida' => $cc[$k]->medida,
                                'foto_uno' => $cc[$k]->foto_uno,
                                'existencia' => $cc[$k]->stock,
                            );

                        unset($cc[$k]);
                        $contador++;
                    }
                }
                $cc = array_values($cc);
                if($jsonTodos){
                    $jsonProv[$contProv] = array('nombre_proveedor' => $arrayProveedores[$j], "datos" => $jsonTodos);
                    $contProv++;
                }
                $jsonTodos = [];
            }
            $jsonReq[$i] = array('numero_requisicion' => $arrayRequisiciones[$i], "proveedores" => $jsonProv);
            $jsonProv = [];
        }
        return [
            "datos_carrito" => $jsonReq
        ];
    }

    public function allProductosCarritoConIva($dataProductos)
    {
        $productos = json_decode($dataProductos);
        $contProducto = count($productos);
        
        $aux = "";
        for ($i = 0; $i < $contProducto; $i++) {
            $aux .= $this->hashDecode($productos[$i]->id_producto).",";
        }
        $aux = substr($aux,0,-1);
        $bienes = '('.$aux.')';

        $arrayRequisiciones = [];
        $arrayProveedores = [];

        $cc = CarritoCompra::productosOrdenCompra($this->idUrg(),$bienes);
        $cc = $this->hashEncode($cc);
        for ($i = 0; $i < count($cc); $i++) {
            $arrayRequisiciones[$i] = $cc[$i]->requisicion;
            $arrayProveedores[$i] = $cc[$i]->nombre;
        }
        $arrayRequisiciones = array_values(array_unique($arrayRequisiciones));
        $arrayProveedores = array_values(array_unique($arrayProveedores));

        $jsonReq = [];
        $jsonProv = [];
        $jsonTodos = [];

        for ($i = 0; $i < count($arrayRequisiciones); $i++) {
            $subtotalGeneral = 0;
            $ivaGeneral = 0;
            $totalGeneral = 0;
            $contProv = 0;
            for ($j = 0; $j < count($arrayProveedores); $j++) {
                $contador = 0;
                $totalProductosProveedor = 0;
                $subtotalProveedor = 0;
                $ivaProveedor = 0;
                $totalProveedor = 0;
                $contBien = count($cc);
                for ($k = 0; $k < $contBien; $k++) {
                    if ($cc[$k]->requisicion == $arrayRequisiciones[$i] && $cc[$k]->nombre == $arrayProveedores[$j]) {
                        $jsonTodos[$contador] =
                            array(
                                'carrito_compra_id' => $cc[$k]->id_e,
                                'cabms' => $cc[$k]->cabms,
                                'nombre_corto' => $cc[$k]->nombre_corto,
                                'marca' => $cc[$k]->marca,
                                'nombre_producto' => $cc[$k]->nombre_producto,
                                'tamanio' => $cc[$k]->tamanio,
                                'color' => $cc[$k]->color,
                                'cantidad_producto' => $cc[$k]->cantidad_producto,
                                'precio_unitario' => $cc[$k]->precio_unitario,
                                'medida' => $cc[$k]->medida,
                                'foto_uno' => $cc[$k]->foto_uno,
                                'existencia' => $cc[$k]->stock,
                                'subtotal' => ($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario),
                                'iva' => (($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario) * (.16)),
                                'total' => ($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario) + (($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario) * (.16)),
                            );

                        $contador++;
                        $totalProductosProveedor += $cc[$k]->cantidad_producto;
                        $subtotalProveedor += ($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario);
                        $ivaProveedor += (($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario) * (.16));
                        $totalProveedor += ($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario) + (($cc[$k]->cantidad_producto * $cc[$k]->precio_unitario) * (.16));
                        unset($cc[$k]);
                    }
                }
                $cc = array_values($cc);
                if($jsonTodos){
                    $jsonProv[$contProv] = array(
                        'nombre_proveedor' => $arrayProveedores[$j],
                        'total_productos_proveedor' => $totalProductosProveedor,
                        'subtotal_proveedor' => $subtotalProveedor,
                        'iva_proveedor' => $ivaProveedor,
                        'total_proveedor' => $totalProveedor,
                        'datos' => $jsonTodos
                    );
                    $contProv++;
                }
                $jsonTodos = [];
                $subtotalGeneral += $subtotalProveedor;
                $ivaGeneral += $ivaProveedor;
                $totalGeneral += $totalProveedor;
            }
            $jsonReq[$i] = array(
                'nombre_requisicion' => $arrayRequisiciones[$i],
                'subtotal_general' => $subtotalGeneral,
                'iva_general' => $ivaGeneral,
                'total_general' => $totalGeneral,
                "proveedores" => $jsonProv
            );
        $jsonProv = [];
        }

        return $jsonReq;
    }

    public function mostrarProductosCarritoConIva()
    {
        $cc = CarritoCompra::allProductosCarrito($this->idUrg(), 0);
        $cc = $this->hashEncode($cc);

        return ["datos_carrito" => $cc,];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $validator = Validator::make($request->all(), [
            'id_requisicion' => 'required',
            'id_pfp' => 'required',
            'cantidad_producto' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->getMessageBag()
            ]);
        } else {
            $resultado = $this->comprobarProductoAgregado($this->hashDecode($request->input('id_requisicion')), $this->hashDecode($request->input('id_pfp')));

            if ($resultado == 0) {
                $cc = new CarritoCompra();
                $cc->requisicion_id = $this->hashDecode($request->input('id_requisicion'));
                $cc->proveedor_ficha_producto_id = $this->hashDecode($request->input('id_pfp'));
                $cc->cantidad_producto = $request->input('cantidad_producto');
                $cc->color = $request->input('color');
                $cc->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Producto agregado al carrito correctamente.'
                ]);
            } else {
                return $this->update($request, $resultado);
            }
        }
    }

    public function comprobarProductoAgregado($nomRequisicion, $idPfp)
    { //Función que permite comprobar si el producto ya ha sido agregado de antemano. Si ya se ha agregado entonces se procede a incrementar la cantidad del producto
        $cc = CarritoCompra::comprobarProductoAgregado($nomRequisicion, $idPfp);
        if (count($cc) > 0) { //Ya existe producto registrado y solo se va a incrementar por lo tanto se retornara un ID
            return $cc[0]->id;
        } else { //Aún no hay productos dados de alta para esa requisición. Se procederá a dar de alta inicial.
            return 0;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($permiso)
    {
        return view("urgs.carrito_compra.solicitud_compra_enviada")->with($this->allProductosCarritoConIva(2));
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
        $carrito = CarritoCompra::find($id);
        $sumarCantidadCarrito = $carrito->cantidad_producto + $request->input('cantidad_producto');
        $carrito->cantidad_producto = $sumarCantidadCarrito;
        $carrito->update();

        return response()->json([
            'status' => 200,
            'message' => 'Producto agregado al carrito correctamente.'
        ]);
    }

    public function actualizarCarrito($productos)
    {
        $arrayDatos = json_decode($productos, true);
        $this->actualizarCompra($arrayDatos);       
        return true;
    }

    public function actualizarCompra($arrayDatos)
    {
        for ($i = 0; $i < count($arrayDatos); $i++) {
            if (is_numeric($arrayDatos[$i]["cantidad_producto_seleccionado"])) {
                $carrito = CarritoCompra::find($this->hashDecode($arrayDatos[$i]["id_producto"]));
                $carrito->cantidad_producto = $arrayDatos[$i]["cantidad_producto_seleccionado"];
                $carrito->update();
            } else {
                return response()->json([
                    'status' => 400,
                    'errors' => "Valor no numérico"
                ]);
            }
        }
    }

    public function confirmarCompra($arrayDatos)
    {
        for ($i = 0; $i < count($arrayDatos); $i++) {
            $carrito = CarritoCompra::find($this->hashDecode($arrayDatos[$i]["id_producto"]));
            $carrito->comprado = 1; // 1 = Producto comprado
            $carrito->update();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cc = CarritoCompra::find($this->hashDecode($id));
            $cc->delete();
            return response()->json([
                'status' => 200,
                'message' => "Producto eliminado de tu carrito de compras."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 400,
                'message' => "No se pudo alcanzar el objetivo: "
            ]);
        }
    }

    public function cantidadProductosCarrito()
    {
        $cc = CarritoCompra::cantidadProductosCarrito($this->idUrg());
        return response()->json([
            'status' => 200,
            'cantidad' => $cc[0]->count
        ]);
    }

}
