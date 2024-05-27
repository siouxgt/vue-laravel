<?php

namespace App\Http\Controllers;

use App\Models\BienServicio;
use App\Models\CatProducto;
use App\Models\ContratoMarco;
use App\Models\ContratoMarcoUrg;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraBien;
use App\Models\OrdenCompraEvaluacionProducto;
use App\Models\OrdenCompraEvaluacionProveedor;
use App\Models\ProductoFavoritoUrg;
use App\Models\Proveedor;
use App\Models\ProveedorFichaProducto;
use App\Models\Requisicione;
use App\Traits\HashIdTrait;
use App\Traits\MensajeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TiendaUrgController extends Controller
{
    use HashIdTrait, MensajeTrait;

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
        $countContratos = ContratoMarcoUrg::where('urg_id',auth()->user()->urg_id)->where('estatus',true)->count();
        $compras = OrdenCompra::where('urg_id',auth()->user()->urg_id)->count();
        $proveedores = Proveedor::ultimosProveedores();
        $contratos = $this->hashEncode(ContratoMarco::contratosHomeUrg(auth()->user()->urg_id));
        foreach($contratos as $key => $contrato){
            $partida = "";
            $aux = json_decode($contrato->capitulo_partida);
            foreach($aux as $capitulo){
                $partida .= $capitulo->partida.", ";
            }
            $contratos[$key]->capitulo_partida = substr($partida, 0, -2);
        }
        $productosMasComprados = $this->hashEncode(OrdenCompraBien::productosMasComprados(auth()->user()->urg_id)); 
        $productosNuevos = $this->hashEncode(ProveedorFichaProducto::productosNuevos(auth()->user()->urg_id));
        
        return view('urgs.index')->with(['countContratos' => $countContratos, 'compras' => $compras,'proveedores' => $proveedores, 'contratos' => $contratos, 'productosMasComprados' => $productosMasComprados, 'productosNuevos' => $productosNuevos]);
    }

    public function verTienda($requisicion = 0)
    {
        $cabms = $this->porRequisicion($requisicion);

        return view('urgs.tienda.tienda')->with(['cabms' => $cabms]);
    }

    public function porRequisicion($requisicion)
    {
        $cabms = "";
        if ($requisicion != 0) {
            $cabms = [];
            $id = $this->hashDecode($requisicion);
            $bienes = $this->hashEncode(BienServicio::where('requisicion_id', $id)->get());
            foreach ($bienes as $bien) {
                if ($bien->cotizado) {
                    $cabms[] = $bien->cabms;
                }
            }
            if ($cabms != []) {
                $cabms = json_encode($cabms);
                $remplazar = array("\"", "[", "]");
                $por = array("'", "(", ")");
                $cabms = str_replace($remplazar, $por, $cabms);
            }
        }
        return $cabms;
    }

    public function verTiendaCabms($cabms)
    {   
        $cabms = "('".$cabms."')";
        return view('urgs.tienda.tienda')->with(['cabms' => $cabms]);
    }

    public function cargarProductos($filtro = "")
    {
        if ($filtro != "") {
            $filtro = json_decode($filtro);
            if ($filtro->cm != "") {
                $filtro->cm = $this->hashDecode($filtro->cm);
            }
            if ($filtro->precio != "") {
                if (!is_numeric($filtro->precio)) {
                    return back();
                }
            }
            if ($filtro->entrega != "") {
                if (!is_numeric($filtro->entrega)) {
                    return back();
                }
            }

            $filtro = json_encode($filtro);
        }

        return $this->datosProductosProveedor($filtro);
    }

    public function buscarContratosM()
    { //Función que permite buscar los contratos marco en los que esta participando la URG y los guardar en un array
        $pfp = ContratoMarcoUrg::buscarContratosM($this->idUrg());
        $pfp = $this->hashEncode($pfp);

        return ['datos' => $pfp];
    }

    public function abrirModalCabms($filtro)
    { //Función que abre modal el cual permite filtrar los producto de acuerdo al contrato seleccionado        
        $filtro = json_decode($filtro);

        $catp = $this->hashEncode(CatProducto::productosContratoM($filtro->cm != 0 ? $this->hashDecode($filtro->cm) : $filtro->cm, $filtro->requisicion));

        return view('urgs.modals.productos_contratos_marco')->with([
            'catp' => $catp,
            'la_cabms' => $filtro->cabms
        ]);
    }

    public function cargarFiltroTamaniosTiempo($filtro = "")
    {
        if ($filtro != "") {
            $filtro = json_decode($filtro);
            if ($filtro->cm != "") {
                $filtro->cm = $this->hashDecode($filtro->cm);
            }

            $filtro = json_encode($filtro);
        }
        $tamanios = ProveedorFichaProducto::cargarFiltroTamanios($filtro);
        $tiempoEntrega = ProveedorFichaProducto::cargarFiltroTiempoEntrega($filtro);
        $tiempos = [];

        $contenidoTamanio = '';
        for ($i = 0; $i < count($tamanios); $i++) {
            $contenidoTamanio .= "<a class='dropdown-item' href='javascript: void(0)'>
                                        <div>
                                            <input class='form-check-input' type='radio' name='radio_tamanio' id='radio_tamanio" . $i . "' value='" . $tamanios[$i]->tamanio . "'>
                                            <label class='form-check-label' for='radio_tamanio" . $i . "'>
                                            " . ucfirst(strtolower($tamanios[$i]->tamanio)) . "
                                            </label>
                                        </div>
                                    </a>";
        }

        $contenidoTiempoEntrega = '';
        $temporalidades = ['día(s)', 'semana(s)', 'mes(es)'];
        for ($i = 0; $i < count($tiempoEntrega); $i++) {
            $laTemporalidad = $temporalidades[$tiempoEntrega[$i]->temporalidad];
            $contenidoTiempoEntrega .= "<a class='dropdown-item' href='javascript: void(0)'>
                                            <div>
                                                <input class='form-check-input' type='radio' name='radio_tiempo_entrega' id='" . $i . "' value='" . $tiempoEntrega[$i]->tiempo_entrega . "'>
                                                <label class='form-check-label' for='" . $i . "'>
                                                "  . $tiempoEntrega[$i]->tiempo_entrega . " " . $laTemporalidad .  "
                                                </label>
                                            </div>
                                        </a>";
            $tiempos[$i] = $tiempoEntrega[$i]->temporalidad;
        }

        return [
            'contenido_tamanio' => $contenidoTamanio,
            'contenido_tiempo_entrega' => $contenidoTiempoEntrega,
            'temporalidad' => $tiempos
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $datosProducto = $this->datosPFP($id);
        $participacion = $this->comprobarParticipacionRequisicion($datosProducto[0]->cabms);
        $contenido = $this->cargarElementosCarrusel(substr($datosProducto[0]->cabms,0,4));
        $opiniones = OrdenCompraEvaluacionProducto::opinionesProducto($datosProducto[0]->id);
        $opinionesProveedor = OrdenCompraEvaluacionProveedor::where('proveedor_id', $datosProducto[0]->proveedor_id)->count();
        $countProductos = ProveedorFichaProducto::totalProductos($datosProducto[0]->proveedor_id);
        
        return view('urgs.tienda.show')->with([
            'producto' => $datosProducto,
            'participacion' => $participacion,
            'contenido' => $contenido,
            'opiniones' => $opiniones,
            'countProductos' => $countProductos[0],
            'opinionesProveedor' => $opinionesProveedor
        ]);
    }

    public function datosProductosProveedor($filtro = "")
    {
        $pp = $this->hashEncode(ProveedorFichaProducto::allProductosProveedorTiendaU($filtro));

        //Pasando los datos a las fichas que se mostrara a la URG
        $contenido = "" . view('urgs.tienda.productos')->with(['pp' => $pp]);
        $totalFavoritos = ProductoFavoritoUrg::totalFavoritosUrg($this->idUrg());
        
        $la_cabms = [];
        for($i = 0; $i < count($pp); $i++){
            $la_cabms[$i] = $pp[$i]->cabms;
        }

        return [
            'contenido' => $contenido,
            'total_resultados' => count($pp),
            "total_favoritos" => $totalFavoritos[0]->total,
            'la_cabms' => $la_cabms
        ];
    }

    public function datosPFP($id)
    {
        $pfp = $this->hashEncode(ProveedorFichaProducto::productoTiendaUrgShow($this->hashDecode($id), $this->idUrg()));
        $pfp[0]->documentacion_incluida = $this->revisarDocumentacionIncluida(json_decode($pfp[0]->documentacion_incluida));
        $pfp[0]->color = json_decode($pfp[0]->color);
        $pfp[0]->dimensiones = json_decode($pfp[0]->dimensiones);
        $this->hashEncodeIdClave($pfp[0],'proveedor_id','proveedor_id_e');

        return $pfp;
    }

    public function revisarDocumentacionIncluida($documentos)
    {
        $arr_documentacion = [];
        $documentos[0]->catalogo ? $arr_documentacion[0] = 'Catálogo' : '';
        $documentos[0]->folletos ? $arr_documentacion[1] = 'Folletos' : '';
        $documentos[0]->garantia ? $arr_documentacion[2] = 'Garantia' : '';
        $documentos[0]->manuales ? $arr_documentacion[3] = 'Manuales' : '';
        $documentos[0]->otro ? $arr_documentacion[4] = 'Otro' : '';

        return implode(", ", $arr_documentacion);
    }

    public function verDoc($nombreArchivo, $quien = 1)
    {
        $carpeta = '';
        $disco = 'public';
        switch ($quien) {
            case 1:
                $carpeta = 'ficha-tec-pfp/'; //Ficha tecnica guardada en ficha producto, $quien = 0
                break;
            case 2:
                $carpeta = "otros-doc-pfp/";
                break;
            case 3: //$quien = 3 es para descargar la ficha tecnica alojada en cat producto
                return response()->download(storage_path('/app/public/cat-producto/' . $nombreArchivo)); //Descargar archivo
                break;
            case 4: //Discos no publicos                
                $disco = 'docs';
                $carpeta = '';
                break;
            default:
                //Session::flash("mensaje", 'Ustede quiere acceder a una zona no permitida, por lo tanto fue sacado');
                return redirect()->route("proveedor.acceso");
                break;
        }

        $file = Storage::disk($disco)->get($carpeta  . $nombreArchivo); //Instrucciones que permiten visualizar archivo
        return Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }

    public function cargarElementosCarrusel($cabms)
    {
        $pp = $this->hashEncode(ProveedorFichaProducto::carruselTiendaShow($cabms));

        $contenido = "";
        for ($i = 0; $i < count($pp); $i++) {
            $estatusFoto = false;
            $rutaFoto = "";

            if ($estatusFoto == false && $pp[$i]->foto_uno != null) {
                $estatusFoto = true;
                $rutaFoto = $pp[$i]->foto_uno;
            }
            if ($estatusFoto == false && $pp[$i]->foto_dos != null) {
                $estatusFoto = true;
                $rutaFoto = $pp[$i]->foto_dos;
            }
            if ($estatusFoto == false && $pp[$i]->foto_tres != null) {
                $estatusFoto = true;
                $rutaFoto = $pp[$i]->foto_tres;
            }
            if ($estatusFoto == false && $pp[$i]->foto_cuatro != null) {
                $estatusFoto = true;
                $rutaFoto = $pp[$i]->foto_cuatro;
            }
            if ($estatusFoto == false && $pp[$i]->foto_cinco != null) {
                $estatusFoto = true;
                $rutaFoto = $pp[$i]->foto_cinco;
            }
            if ($estatusFoto == false && $pp[$i]->foto_seis != null) {
                $estatusFoto = true;
                $rutaFoto = $pp[$i]->foto_seis;
            }

            if ($i == 0) {
                if (count($pp) == 1) {
                    $contenido .= "<div class='carousel-item active' style='display: flex; justify-content: center !important;'>"; //Si
                } else {
                    $contenido .= "<div class='carousel-item active'>"; //Si
                }
            } else {
                $contenido .= "<div class='carousel-item'>"; //Si
            }

            $contenido .= "<div class='col-lg-3 col-md-6 col-sm-6 col-12' style='display: flex; justify-content: center !important;'>";
            $contenido .= "<div class='card bg-white border' >";

            if ($estatusFoto) {
                $contenido .= "<img class='imag-carrucel' src='" . asset('storage/img-producto-pfp/' . $rutaFoto) . "' alt='Foto...'>";
            } else {
                $contenido .= "<img class='imag-carrucel' src='" . asset('asset/img/bac_imag_fondo.svg') . "' alt='Foto...'>";
            }

            $contenido .= "<hr>";
            $contenido .= "<div class='card-body'>";

            $contenido .= "<div class='card-title'>";
            $contenido .= "<a href='" . route('tienda_urg.show', $pp[$i]->id_e) . "'>";
            $contenido .= "<p class='text-gold-2 text-truncate' title='" . strtoupper($pp[$i]->nombre_producto == null ? " " : $pp[$i]->nombre_producto) . "'>" . strtoupper($pp[$i]->nombre_producto == null ? " " : $pp[$i]->nombre_producto) ."</p>";
            $contenido .= '</a>';
            $contenido .= "</div>";

            $contenido .= "<p class='card-text text-1'>
                                <strong>$" . number_format($pp[$i]->precio_unitario, 2) . "</strong> x 1 
                           </p>";
            $contenido .= "<p class='card-text text-1'>
                                " . $pp[$i]->medida . "
                           </p>";
            $contenido .= "</div>
                           </div>
                           </div>
                           </div>";
        }

        return $contenido;
    }

    public function comprobarParticipacionRequisicion($la_cabms)
    {
        //Función que permite checar si el producto que elija la URG esta integrada en las requisiciones que participa.
        $req = Requisicione::comprobarBienServicio($this->idUrg(), $la_cabms);
        
        return $req[0];
    }

    public function modalMensaje(){
        return view('urgs.modals.mensaje_modal');
    }

    public function storeMensaje(Request $request){
        $data = ['remitente' => auth()->user()->id, 'receptor' => 0, 'tipo_remitente' => 1, 'tipo_receptor' => 1,'origen' => 'HOME'];
        
        return $this->storeManual($request,$data);
    }

    public function opinionProducto($id){
        $opiniones = OrdenCompraEvaluacionProducto::opinionesProductoShow($this->hashDecode($id));
        $producto = $this->hashEncode(ProveedorFichaProducto::find($this->hashDecode($id)));
        $calificacionTotal = 0;
        foreach ($opiniones as $key => $value) {
            $calificacionTotal += $value->calificacion;
        }
        return view('urgs.tienda.opinion_producto')->with(['opiniones' => $opiniones, 'producto' => $producto, 'calificacionTotal' => $calificacionTotal]);
    }

    public function opnionProductoFiltro($id, $estrellas){
        $opiniones = OrdenCompraEvaluacionProducto::opinionesProductoFiltro($this->hashDecode($id),$estrellas);
        return view('urgs.tienda.opinion_producto_filtro')->with(['opiniones' => $opiniones]);
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

        return view('urgs.tienda.opinion_proveedor')->with(['opiniones' => $opiniones, 'proveedor' => $proveedor, 'calificacionTotal' => $calificacionTotal, 'comunicacionTotal' => $comunicacionTotal, 'calidadTotal' => $calidadTotal, 'tiempoTotal' => $tiempoTotal, 'mercanciaTotal' => $mercanciaTotal, 'facturasTotal' => $facturasTotal, 'procesoTotal' => $procesoTotal]);
    }

    public function opinionProveedorFiltro($id, $estrellas){
        $opiniones = OrdenCompraEvaluacionProveedor::opinionesProveedorFiltro($this->hashDecode($id),$estrellas);
        return view('urgs.tienda.opinion_proveedor_filtro')->with(['opiniones' => $opiniones]);
    }


}