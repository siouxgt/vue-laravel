<?php

namespace App\Http\Controllers;

use App\Models\CatProducto;
use App\Models\ContratoMarco;
use App\Models\ProveedorFichaProducto;
use App\Models\ValidacionAdministrativa;
use App\Models\ValidadorTecnico;
use App\Services\ValidacionEconomicaService;
use App\Traits\HashIdTrait;
use App\Traits\ProveedoresTrait;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;


class ProveedorFichaProductoController extends Controller {
    use HashIdTrait, ProveedoresTrait;

    public function __construct() {
        $this->middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia', 'perfilActivo']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('proveedores.ficha_producto.index');
    }

    public function abrirIndex($productoId, $filtro = '') { // Index productos
        return view('proveedores.ficha_producto.producto_index')->with([
            'filtro' => $productoId == 0 ? '' : $productoId,
            'cm' => $productoId == 0 ? '' : $this->getNombreContratoMarco($productoId),
            'pp' => $this->hashEncode(ProveedorFichaProducto::allProductosProveedor(Auth::guard('proveedor')->user()->id, $this->hashDecode($productoId), $filtro))
        ]);
    }

    public function modalValAdmin($idProducto) {
        return view('proveedores.ficha_producto.modals.comentarios_val_administrativa')->with(['validacion' => ValidacionAdministrativa::getComentario($this->hashDecode($idProducto))]);
    }

    public function modalValTec($idProducto) {
        $nombre = ProveedorFichaProducto::find($this->hashDecode($idProducto))->nombre_producto;
        $tecnicas = ValidadorTecnico::tecnicoAll($this->hashDecode($idProducto));
        return view('proveedores.ficha_producto.modals.comentarios_val_tecnica')->with(['tecnicas' => $tecnicas, 'nombre' => $nombre]);
    }

    public function getNombreContratoMarco($catProductoId) {
        if (session()->exists('cat_producto_id')) session()->forget('cat_producto_id');

        session(['cat_producto_id' => $catProductoId]);
        return ProveedorFichaProducto::obtenerNombreContratoMarco($this->hashDecode($catProductoId));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
    }

    public function abrirProductoInicio($idProducto) {
        return view('proveedores.ficha_producto.producto_inicio')->with(['producto' => $this->datosCatProductos($idProducto)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'producto_id' => 'required',
            'id_producto' => 'required|max:100',
            'inicio_version' => 'required|numeric',
            'inicio_caracteristicas' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $pfp  = new ProveedorFichaProducto();
            $pfp->producto_id = $this->hashDecode($request->input('producto_id'));
            $pfp->proveedor_id = Auth::guard('proveedor')->user()->id;
            $pfp->id_producto = $request->input('id_producto');
            $pfp->version = $request->input('inicio_version');
            $pfp->caracteristicas = $request->input('inicio_caracteristicas');
            $pfp->estatus_inicio = true;
            $pfp->estatus = false;
            $pfp->save();
            $pfp = $this->hashEncode($pfp);

            return response()->json(['status' => 200, 'message' => 'Todo está listo para iniciar el registro de su producto.', 'permiso' => $pfp->id_e,]);
        }
    }

    public function mensaje($mensaje, $pfp, $extra = "nada", $extraInfo = "") {
        $pfp->update();
        return response()->json(['status' => 200, 'message' => $mensaje, $extra => $extraInfo]);
    }

    public function guardado($validator, $request, $id) {
        if (($request->input('accion') == '' || $request->input('accion') == null) && $validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $pfp  = ProveedorFichaProducto::find($this->hashDecode($id));

            switch ($request->input('emisor')) {
                case 'foto':
                    if ($request->input('accion') == '' || $request->input('accion') == null) {
                        $nombreCampo = $request->input("campo");
                        if ($request->hasFile($nombreCampo)) {
                            if (Storage::disk('public')->exists("img-producto-pfp/" . $pfp->$nombreCampo)) { // aquí compruebo que existan los archivos anteriores
                                Storage::disk('public')->delete("img-producto-pfp/" . $pfp->$nombreCampo); // Borrando archivo existente
                            }
                            $pfp->$nombreCampo = $this->guardarFoto($request->file($nombreCampo));
                            $pfp->validacion_administracion = null;
                            $pfp->validacion_tecnica = null;
                            $pfp->publicado = false;
                        }
                        return $this->mensaje('Foto guardada correctamente.', $pfp, 'permiso', $request->input("ipfp"));
                    } else {
                        $elActualizado = $request->input('la_foto');
                        $pfp->$elActualizado = null;
                        $pfp->estatus_producto = false;
                        return $this->mensaje('Foto eliminada correctamente.', $pfp);
                    }
                    break;
                case "producto":
                    $pfp->nombre_producto = $request->input('p_nombre_producto');
                    $pfp->descripcion_producto = $request->input('p_descripcion_producto');
                    $pfp->estatus_producto = true;
                    $this->verificarEstatus($pfp);
                    $pfp->validacion_administracion = null;
                    $pfp->validacion_tecnica = null;
                    $pfp->publicado = false;
                    //dd($pfp);
                    return $this->mensaje('Datos del producto registrados correctamente.', $pfp);
                    break;
                case "ficha_tec":
                    if ($request->input('accion') == '' || $request->input('accion') == null) { //Si accion esta en vacio significa que se hará una actualizacón de guardado.
                        return $this->actualizarFichaTec($pfp, $request->file('doc_ficha_tecnica'));
                    } else {
                        return $this->actualizarFichaTec($pfp);
                    }
                    break;
                case "doc_adicional":
                    if ($request->input('accion') == '' || $request->input('accion') == null) { //Si accion esta en vacio significa que se hará una actualizacón de guardado.
                        $tipoDocAdicional = $request->input('tipo_doc_adicional');
                        $pfp->$tipoDocAdicional = $this->checarArchivos("otros-doc-pfp/", $pfp->$tipoDocAdicional, $request->file('el_doc_adicional'));
                        $pfp->validacion_administracion = null;
                        $pfp->validacion_tecnica = null;
                        $pfp->publicado = false;
                        return $this->mensaje('Documento adicional guardado.', $pfp, 'doc_adicional', $pfp->$tipoDocAdicional);
                    } else {
                        $tipoDocAdicional = $request->input('el_eliminado');
                        $pfp->$tipoDocAdicional = $this->checarArchivos("otros-doc-pfp/", $pfp->$tipoDocAdicional, "");
                        return $this->mensaje('Documento adicional eliminado.', $pfp);
                    }
                    break;
                case "colores":
                    $cuantos = 0;
                    foreach ($request->input('color_') as $key => $color) {
                        if ($color != "" || $color != null) {
                            $colores[$key]['el_color'] = $color;
                            $cuantos++;
                        }
                    }
                    if ($cuantos >= 1) {
                        $pfp->color = json_encode($colores);
                        return $this->mensaje('Colores guardados correctamente.', $pfp, 'los_colores', $pfp->color);
                    } else {
                        return response()->json([
                            'status' => 400,
                            'errors' => ["Inserte nombre de colores por favor, no deje las casillas vacías."]
                        ]);
                    }
                    break;
                case "dimensiones":
                    $arrayDimensiones[0]['largo'] = $request->input('largo');
                    $arrayDimensiones[0]['ancho'] = $request->input('ancho');
                    $arrayDimensiones[0]['alto'] = $request->input('alto');
                    $arrayDimensiones[0]['peso'] = $request->input('peso');
                    $arrayDimensiones[0]['unidad_largo'] = $request->input('unidad_largo');
                    $arrayDimensiones[0]['unidad_ancho'] = $request->input('unidad_ancho');
                    $arrayDimensiones[0]['unidad_alto'] = $request->input('unidad_alto');
                    $arrayDimensiones[0]['unidad_peso'] = $request->input('unidad_peso');
                    $pfp->dimensiones = json_encode($arrayDimensiones);
                    return $this->mensaje('Dimensiones guardadas correctamente.', $pfp);
                    break;
                case "caracteristicas":
                    $pfp->marca = $request->input('marca');
                    $pfp->modelo = $request->input('modelo');
                    $pfp->material = $request->input('material');
                    $pfp->composicion = $request->input('composicion');
                    $pfp->tamanio = $request->input('tamanio');
                    $pfp->estatus_caracteristicas = true;
                    $pfp->sku = $request->input('sku');
                    $pfp->fabricante = $request->input('fabricante');
                    $pfp->pais_origen = $request->input('pais_origen');
                    $pfp->grado_integracion_nacional = $request->input('grado_integracion_nacional');
                    $pfp->presentacion = $request->input('presentacion');
                    $pfp->disenio = $request->input('disenio');
                    $pfp->acabado = $request->input('acabado');
                    $pfp->forma = $request->input('forma');
                    $pfp->aspecto = $request->input('aspecto');
                    $pfp->etiqueta = $request->input('etiqueta');
                    $pfp->envase = $request->input('envase');
                    $pfp->empaque = $request->input('empaque');
                    $pfp->validacion_administracion = null;
                    $pfp->validacion_tecnica = null;
                    $pfp->publicado = false;
                    return $this->mensaje('Características guardadas correctamente.', $pfp);
                    break;
                case "entrega":
                    $pfp->tiempo_entrega = $request->input('tiempo_de_entrega');
                    $pfp->temporalidad = $request->input('dias_entrega');

                    $arrayDocumentacion = [];
                    $arrayDocumentacion[0]['catalogo'] = $request->input('catalogo') ? true : false;
                    $arrayDocumentacion[0]['folletos'] = $request->input('folletos') ? true : false;
                    $arrayDocumentacion[0]['garantia'] = $request->input('garantia') ? true : false;
                    $arrayDocumentacion[0]['manuales'] = $request->input('manuales') ? true : false;
                    $arrayDocumentacion[0]['otro'] = $request->input('otro') ? true : false;
                    $pfp->documentacion_incluida = json_encode($arrayDocumentacion);
                    $pfp->estatus_entrega = true;
                    $pfp->validacion_administracion = null;
                    $pfp->validacion_tecnica = null;
                    $pfp->publicado = false;
                    return $this->mensaje('Tiempo de entrega registrada correctamente.', $pfp);
                    break;
                case "precio":
                    $pfp->precio_unitario = $request->input('precio_unitario');
                    $pfp->unidad_minima_venta = $request->input('unidad_minima_venta');
                    $pfp->stock = $request->input('stock_disponible');
                    $pfp->vigencia = $request->input('dias_naturales');
                    $pfp->estatus_precio = true;
                    $pfp->validacion_precio = null;
                    return $this->mensaje('Precios guardados correctamente.', $pfp);
                    break;
                case "validacion_tec":
                    if ($request->input('accion') == '' || $request->input('accion') == null) { //Si accion esta en vacio significa que se hará una actualizacón de guardado.
                        $pfp->validacion_tecnica_prueba = $this->checarArchivos("validacion-tec-pfp/", $pfp->validacion_tecnica_prueba, $request->file('prueba'));
                        $pfp->estatus_validacion_tec = true;
                        $pfp->validacion_administracion = null;
                        $pfp->validacion_tecnica = null;
                        $pfp->publicado = false;
                        return $this->mensaje('El documento de validacion técnica ha sido guardado correctamente.', $pfp, 'doc_validacion_tec', $pfp->validacion_tecnica_prueba);
                    } else {
                        $pfp->validacion_tecnica_prueba = $this->checarArchivos("validacion-tec-pfp/", $pfp->validacion_tecnica_prueba, "");
                        $pfp->estatus_validacion_tec = false;
                        return $this->mensaje('Validacion técnica eliminada.', $pfp);
                    }
                    break;
                case 'cambiar':
                    $pfp->estatus = $request->input('estatus');
                    return $this->mensaje('Estatus cambiado.', $pfp);
                    break;
            }
        }
    }

    public function guardarFoto($photo) {
        $nombreArchivo      = time() . Str::random(8) . '.' . $photo->getClientOriginalExtension();

        $destinationPath = public_path('/storage/img-producto-pfp/');
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        $thumbImg = Image::make($photo->getRealPath())->resize(1200, 1200);
        $thumbImg->save($destinationPath . '/' . $nombreArchivo, 100);
        return $nombreArchivo;
    }

    public function actualizarFichaTec($pfp, $laFichaTec = null) {
        try {
            $pfp->doc_ficha_tecnica = $this->checarArchivos("ficha-tec-pfp/", $pfp->doc_ficha_tecnica, $laFichaTec);
            $pfp->validacion_administracion = null;
            $pfp->validacion_tecnica = null;
            $pfp->publicado = false;
            if ($laFichaTec != null) {
                $pfp->estatus_ficha_tec = true;
                $this->verificarEstatus($pfp);
            } else {
                $pfp->estatus_ficha_tec = false;
            }
            return $this->mensaje(($laFichaTec == "" ? "Ficha técnica eliminada." : "Ficha técnica guardada correctamente."), $pfp, 'doc_ficha_tecnica', $pfp->doc_ficha_tecnica);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => "No se pudo alcanzar el objetivo: " . $e]);
        }
    }

    public function verificarEstatus($pfp) {
        if ($pfp->estatus_inicio && $pfp->estatus_producto && $pfp->estatus_ficha_tec && $pfp->estatus_caracteristicas && $pfp->estatus_entrega && $pfp->estatus_precio) {
            $pfp->estatus = true;
        } else {
            $pfp->estatus = false;
        }
    }

    public function checarArchivos($carpeta, $archivoActual, $archivoNuevo) {
        if (Storage::disk('public')->exists($carpeta . $archivoActual)) { // aquí compruebo que existan los archivos anteriores
            Storage::disk('public')->delete($carpeta . $archivoActual); // Borrando archivo existente
        }
        if ($archivoNuevo != "") { //Comprobando si en verdad existen archivos nuevos del usuario para proceder a actualizarlos
            return $this->guardarArchivos($carpeta, $archivoNuevo); //Guardando el archivo nuevo
        } else {
            return null;
        }
    }
    public function guardarArchivos($carpeta, $archivo) //Función que permite generar nuevo nombre y guardar archivos en storage
    {
        $a_nombre_unico = time() . Str::random(8) . $archivo->getClientOriginalName();
        Storage::disk('public')->put($carpeta . $a_nombre_unico, File::get($archivo)); //Guardando en disco el archivo con el nuevo nombre asignado
        return $a_nombre_unico;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $lastChar = substr($id, -1); //Capturando el ultimo caracter del ID para hacer comparaciones mas adelante
        $edicion = false;
        if (strpos($lastChar, '_') !== false) {
            $edicion = true;
            $cadena = substr($id, 0, -1); //Quitando el espacio vacio
            $id = $cadena;
        }

        return view('proveedores.ficha_producto.producto_show')->with(['producto' => $this->datosPFP($id, true), 'edicion' => $edicion, 'catProductoId' => session('cat_producto_id')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        return view('proveedores.ficha_producto.producto_inicio_edit')->with(['producto' => $this->datosPFP($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = null;
        $regexTexto = 'regex:/^[A-Z,a-z, ,-,_,/,Á,É,Í,Ó,Ú,á,é,í,ó,ú,ü,ñ,Ñ,0-9]*$/';
        switch ($request->input('emisor')) {
            case 'foto':
                if ($request->input('accion') == '' || $request->input('accion') == null) {
                    $nombreCampo = $request->input("campo");
                    $validator = Validator::make($request->all(), [
                        $nombreCampo => 'required|mimes:jpg,png',
                    ]);
                }
                break;
            case 'producto':
                $validator = Validator::make(
                    $request->all(),
                    [
                        'p_nombre_producto' => "required|max:200",
                        'p_descripcion_producto' => "required",
                    ],
                    [
                        'p_nombre_producto.required' => 'El nombre de tu producto es necesario!',
                        'p_descripcion_producto.required' => 'La descripción de tu producto es necesaria!',
                    ],

                );
                break;
            case 'ficha_tec':
                if ($request->input('accion') == '' || $request->input('accion') == null) { //Si accion esta en vacio significa que se hará una actualizacón de guardado.
                    $validator = Validator::make($request->all(), [
                        'doc_ficha_tecnica' => 'required|mimes:pdf|max:31000',
                    ]);
                }
                break;
            case 'doc_adicional':
                if ($request->input('accion') == '' || $request->input('accion') == null) {
                    $validator = Validator::make($request->all(), [
                        "el_doc_adicional" => 'required|mimes:pdf|max:31000'
                    ]);
                }
                break;
            case 'colores':
                $validator = Validator::make($request->all(), ["color_" => "required|array|min:1"]);
                break;
            case 'dimensiones':
                $validator = Validator::make($request->all(), [
                    "largo" => 'required|numeric',
                    "ancho" => 'required|numeric',
                    "alto" => 'required|numeric',
                    "peso" => 'required|numeric',
                    'unidad_largo' => 'required|integer|in:0,1,2', //Es un combobox: Me esta enviando un numero
                    'unidad_ancho' => 'required|integer|in:0,1,2', //Es un combobox: Me esta enviando un numero
                    'unidad_alto' => 'required|integer|in:0,1,2', //Es un combobox: Me esta enviando un numero
                    'unidad_peso' => 'required|integer|in:0,1,2', //Es un combobox: Me esta enviando un numero
                ]);
                break;
            case 'caracteristicas':
                $validator = Validator::make(
                    $request->all(),
                    [
                        "marca" => "required|max:100",
                        "modelo" => "nullable|max:100",
                        "material" => "required|max:100",
                        "composicion" => "nullable|max:100",
                        "tamanio" => "required|max:50",
                        "sku" => "nullable|max:15",
                        "fabricante" => "nullable|max:150",
                        "pais_origen" => "nullable|max:150",
                        "grado_integracion_nacional" => "nullable|max:150",
                        "presentacion" => "nullable|max:150",
                        "disenio" => "nullable|max:150",
                        "acabado" => "nullable|max:150",
                        "forma" => "nullable|max:150",
                        "aspecto" => "nullable|max:150",
                        "etiqueta" => "nullable|max:150",
                        "envase" => "nullable|max:150",
                        "empaque" => "nullable|max:150"
                    ],
                    [
                        'tamanio.required' => 'Es necesario que definas el tamaño de tu producto!',
                    ]
                );
                break;
            case "entrega":
                $validator = Validator::make(
                    $request->all(),
                    [
                        "tiempo_de_entrega" => 'required|numeric|min:1',
                        "dias_entrega" => 'required|integer|in:0,1,2',
                    ],
                    [
                        'tiempo_de_entrega.min' => 'El tiempo de entrega tiene que ser mínimo de 1 día!',
                    ],
                );
                break;
            case "precio":
                $validator = Validator::make(
                    $request->all(),
                    [
                        "precio_unitario" => 'required|numeric|min:1',
                        "unidad_minima_venta" => 'required|integer|min:1',
                        "stock_disponible" => 'required|integer|min:1',
                        "dias_naturales" => 'required|integer|in:30,60,90',
                    ],
                    [
                        'precio_unitario.min' => 'El precio unitario mínimo aceptable es de $1 (1 peso mexicano)!',
                        'unidad_minima_venta.min' => 'La unidad mínima de venta aceptable es de mínimo 1 unidad!',
                        'stock_disponible.min' => 'Tu stock disponible tiene que ser mayor a cero!',
                    ],
                );
                break;
            case 'validacion_tec':
                if ($request->input('accion') == '' || $request->input('accion') == null) {
                    $validator = Validator::make($request->all(), [
                        "prueba" => 'required|mimes:pdf|max:31000',
                    ]);
                }
                break;
            case 'cambiar':
                $validator = Validator::make($request->all(), ["estatus" => 'required',]);
                break;
        }
        return $this->guardado($validator, $request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //dd("Si elimina " ,$id);
        try {
            $pfp = ProveedorFichaProducto::find($this->hashDecode($id));
            $pfp->delete();
            return response()->json(['status' => 200, 'message' => "Registro eliminado correctamente"]);
        } catch (\Exception $e) {
            return response()->json(['status' => 400, 'message' => "No se pudo eliminar, contacte al administrador."]);
        }
    }

    public function duplicar(Request $request) { //ficha-tec-pfp     img-producto-pfp    otros-doc-pfp
        $pfp = ProveedorFichaProducto::find($this->hashDecode($request->el_id[0]));
        $pfp->id_producto = $this->generarNuevoIdProducto($pfp->id_producto);        // $pfp->doc_ficha_tecnica = $this->duplicarArchivos($pfp->doc_ficha_tecnica, 'ficha-tec-pfp/');//Manera de duplicar archivos
        $pfp->nombre_producto = '(esto_es_una_copia) ' . $pfp->nombre_producto;
        $pfp->descripcion_producto = '(esto_es_una_copia) ' . $pfp->descripcion_producto;
        $pfp->foto_uno = null;
        $pfp->foto_dos = null;
        $pfp->foto_tres = null;
        $pfp->foto_cuatro = null;
        $pfp->foto_cinco = null;
        $pfp->foto_seis = null;
        $pfp->estatus_producto = false;
        $pfp->doc_ficha_tecnica = null;
        $pfp->doc_adicional_uno = null;
        $pfp->doc_adicional_dos = null;
        $pfp->doc_adicional_tres = null;
        $pfp->estatus_ficha_tec = false;
        $pfp->estatus = false;

        //Estableciendo a vacio la validacion tecnica exista o no
        $pfp->validacion_tecnica_prueba = "";
        $pfp->estatus_validacion_tec = false;

        //Quitando todas las validaciones a la copia
        $pfp->validacion_precio = null;
        $pfp->validacion_administracion = null;
        $pfp->validacion_tecnica = null;
        $pfp->publicado = false;
        $pfp->validacion_cuenta = 0;

        $newData = $pfp->replicate();
        $newData->save();
        $newData = $this->hashEncode($newData);

        return redirect()->route("proveedor_fp.edit", ['proveedor_fp' => $newData->id_e]);
    }

    function duplicarArchivos($archivoCopiado, $carpeta) {
        if ($archivoCopiado != null || $archivoCopiado != '') {
            $archivoExplode = explode(".", $archivoCopiado); //Separando el texto tomando en cuenta el punto ".", (si existen más de un punto se tomara en cuenta el ultimo punto encontrado)
            $archivoNuevo = $archivoExplode[0] . '_copia(' . Str::random(5) . ').' . $archivoExplode[count($archivoExplode) - 1];
            Storage::disk('public')->copy($carpeta . $archivoCopiado, $carpeta . $archivoNuevo);
            return $archivoNuevo;
        } else {
            return null;
        }
    }

    function generarNuevoIdProducto($idProductoAntiguo) {
        $idExplode = explode("-", $idProductoAntiguo);
        return $idExplode[0] .=  '-' . $this->siguienteId();
    }

    public function abrirModalColor($id) {
        $pfp = $this->hashEncode(ProveedorFichaProducto::cargarColores($this->hashDecode($id)));        
        $pfp[0]->color = json_decode($pfp[0]->color);
        return view('proveedores.ficha_producto.modals.create_color')->with(['los_colores' => $pfp]);
    }

    public function abrirModalDimensiones($id) {
        $pfp = $this->hashEncode(ProveedorFichaProducto::cargarDimensiones($this->hashDecode($id)));
        $pfp[0]->dimensiones = json_decode($pfp[0]->dimensiones);
        return view('proveedores.ficha_producto.modals.create_dimensiones')->with(['las_dimensiones' => $pfp]);
    }

    public function verDoc($nombreArchivo, $quien = 1) {
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
                Session::flash("mensaje", 'Ustede quiere acceder a una zona no permitida, por lo tanto fue sacado');
                return redirect()->route("proveedor.acceso");
                break;
        }

        $file = Storage::disk($disco)->get($carpeta  . $nombreArchivo); //Instrucciones que permiten visualizar archivo
        return Response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"' //Para que el archivo se abra en otra pagina es necesario incluir  target="_blank"
        ]);
    }

    public function fetchPFP() {
        $catProductos = $this->hashEncode(catProducto::allCatProductosFull(Auth::guard('proveedor')->user()->id));
        for ($i = 0; $i < count($catProductos); $i++) {
            $catProductos[$i]->cuenta_producto = $this->countProveedorFP($catProductos[$i]->id, Auth::guard('proveedor')->user()->id); //contando cuantos productos se han registrado del producto
        }
        return Datatables::of($catProductos)->toJson();
    }

    public function datosPFP($id, $deshow = false) {
        $pfp = $this->hashEncode(ProveedorFichaProducto::allProveedorFichaProducto($this->hashDecode($id)));

        if ($deshow) {
            $pfp[0]->doc_ficha_tecnica = ($pfp[0]->doc_ficha_tecnica != null) ? $pfp[0]->doc_ficha_tecnica : null;
            $pfp[0]->doc_adicional_uno = ($pfp[0]->doc_adicional_uno != null) ? $pfp[0]->doc_adicional_uno : null;
            $pfp[0]->doc_adicional_dos = ($pfp[0]->doc_adicional_dos != null) ? $pfp[0]->doc_adicional_dos : null;
            $pfp[0]->doc_adicional_tres = ($pfp[0]->doc_adicional_tres != null) ? $pfp[0]->doc_adicional_tres : null;
            $pfp[0]->documentacion_incluida = $pfp[0]->documentacion_incluida == null ? null : $this->revisarDocumentacionIncluida(json_decode($pfp[0]->documentacion_incluida));
        } else {
            $pfp[0]->doc_ficha_tecnica != null ? $pfp[0]->doc_ficha_tecnica = substr($pfp[0]->doc_ficha_tecnica, 18, strlen($pfp[0]->doc_ficha_tecnica)) : null; //Formateando el nombre del archivo para que solo aparezca el nombre original con el que lo subio el proveedor
            $pfp[0]->doc_adicional_uno != null ? $pfp[0]->doc_adicional_uno = substr($pfp[0]->doc_adicional_uno, 18, strlen($pfp[0]->doc_adicional_uno)) : null;
            $pfp[0]->doc_adicional_dos != null ? $pfp[0]->doc_adicional_dos = substr($pfp[0]->doc_adicional_dos, 18, strlen($pfp[0]->doc_adicional_dos)) : null;
            $pfp[0]->doc_adicional_tres != null ? $pfp[0]->doc_adicional_tres = substr($pfp[0]->doc_adicional_tres, 18, strlen($pfp[0]->doc_adicional_tres)) : null;
            $pfp[0]->documentacion_incluida = json_decode($pfp[0]->documentacion_incluida);
        }
        $pfp[0]->color = json_decode($pfp[0]->color);
        $pfp[0]->dimensiones = json_decode($pfp[0]->dimensiones);
        return $pfp;
    }

    public function revisarDocumentacionIncluida($documentos) {
        $arr_documentacion = [];
        $documentos[0]->catalogo ? $arr_documentacion[0] = 'Catálogo' : '';
        $documentos[0]->folletos ? $arr_documentacion[1] = 'Folletos' : '';
        $documentos[0]->garantia ? $arr_documentacion[2] = 'Garantia' : '';
        $documentos[0]->manuales ? $arr_documentacion[3] = 'Manuales' : '';
        $documentos[0]->otro ? $arr_documentacion[4] = 'Otro' : '';

        return implode(", ", $arr_documentacion);
    }

    public function datosCatProductos($idCP) {
        $catProductos = $this->hashEncode(catProducto::catFichaProducto($this->hashDecode($idCP)));
        $catProductos[0]->elidproducto .=  '-' . $this->siguienteId();
        return $catProductos;
    }

    public function datosProductosProveedor($proveedorId, $productoId, $filtro) {
        if (isset($filtro->producto_id)) $filtro->producto_id = is_numeric($filtro->producto_id) ? '' : $this->hashDecode($filtro->producto_id);
        return $this->hashEncode(ProveedorFichaProducto::allProductosProveedor($proveedorId, $filtro));
    }

    public function siguienteId() {
        $numero = ProveedorFichaProducto::siguienteId();
        $numero = str_pad($numero, 2, "0", STR_PAD_LEFT); //Poniendo Cero a los números menores o igual a 9, Ejemplo: 01, 02, 03
        return $numero;
    }

    public function countProveedorFP($id, $proveedor_id) { //Función que cuenta la cantidad de productos que a registrado el proveedor
        $total = ProveedorFichaProducto::countProveedorFP($id, $proveedor_id);
        return $total[0]->count;
    }

    public function validacionEconomica($id) {
        app(ValidacionEconomicaService::class)->validar($id);
    }
}
