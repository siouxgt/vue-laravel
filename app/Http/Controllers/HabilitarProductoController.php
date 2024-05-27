<?php

namespace App\Http\Controllers;

use App\Models\CatProducto;
use App\Models\ContratoMarco;
use App\Models\GrupoRevisor;
use App\Models\HabilitarProducto;
use App\Models\ProveedorFichaProducto;
use App\Models\ValidacionEconomica;
use App\Models\ValidadorTecnico;
use App\Traits\ContratoTrait;
use App\Traits\HashIdTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class HabilitarProductoController extends Controller
{
    use HashIdTrait, ContratoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $contratoId = $this->hashDecode(session('contrato'));

        $formularios = CatProducto::where('contrato_marco_id',$contratoId)->count();
        $countFormulariosLleno = count(ProveedorFichaProducto::countFormulariosLlenos($contratoId));

        $countEconomica = ProveedorFichaProducto::contadorEconomica($contratoId); 
        $countAdministrativa = ProveedorFichaProducto::contadorAdministrativa($contratoId);
        $countTecnica = ProveedorFichaProducto::contadorTecnica($contratoId); 
        $todos = ProveedorFichaProducto::todos($contratoId);
        $countAdminTec = ProveedorFichaProducto::contadorAdminTecnica($contratoId);
        $countSinTecnica = ProveedorFichaProducto::contadorSinTecnica($contratoId);

        $countPublicados = ProveedorFichaProducto::contadorPublicados($contratoId);
        $countNoPublicados = ProveedorFichaProducto::contadorNoPublicados($contratoId);
        
        $cabms = CatProducto::select('id','cabms','descripcion')->where('contrato_marco_id',$contratoId)->get();
        $cabms = $this->hashEncode($cabms);

        $fechas = $this->fechasContrato($contratoId);

        return view('admin.habilitar-producto.index')->with(['formularios' => $formularios, 'countFormulariosLleno' => $countFormulariosLleno, 'fechas' => $fechas, 'todos' => $todos[0], 'countEconomica' => $countEconomica[0], 'countAdministrativa' => $countAdministrativa[0], 'countTecnica' => $countTecnica[0], 'countPublicados' => $countPublicados[0], 'countNoPublicados' => $countNoPublicados[0], 'cabms' => $cabms, 'countAdminTec' => $countAdminTec[0], 'countSinTecnica' => $countSinTecnica[0]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HabilitarProducto  $habilitarProducto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $grupoRevisor = $this->hashEncode(GrupoRevisor::where('contrato_id',$this->hashDecode(session('contrato')))->get());
        $habilitarProducto = $this->hashEncode(HabilitarProducto::find($id));
        if($habilitarProducto->grupo_revisor_id){
            $habilitarProducto = $this->hashEncodeId($habilitarProducto,'grupo_revisor_id');
        }
        
        return view('admin.habilitar-producto.modal_edit')->with(['habilitarProducto' => $habilitarProducto, 'grupoRevisor' => $grupoRevisor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HabilitarProducto  $habilitarProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $this->hashDecode($id);
        try {
            $habilitarProducto = HabilitarProducto::find($id);
            $precio = $habilitarProducto->precio_maximo;
            $habilitarProducto->precio_maximo = $request->input('precio_maximo');
            $habilitarProducto->fecha_estudio = Carbon::createFromFormat('d/m/Y',$request->input('fecha_estudio'));
            $habilitarProducto->fecha_formulario = Carbon::createFromFormat('d/m/Y',$request->input('fecha_formulario'));
            $habilitarProducto->fecha_carga = Carbon::createFromFormat('d/m/Y',$request->input('fecha_carga'));
            $habilitarProducto->fecha_administrativa = Carbon::createFromFormat('d/m/Y',$request->input('fecha_administrativa'));
            $habilitarProducto->fecha_tecnica = Carbon::createFromFormat('d/m/Y',$request->input('fecha_tecnica'));
            $habilitarProducto->fecha_publicacion = Carbon::createFromFormat('d/m/Y',$request->input('fecha_publicacion'));
            $habilitarProducto->grupo_revisor_id = $this->hashDecode($request->input('grupo_revisor'));

            if($request->file('archivo_estudio_original')){
                if(Storage::disk('precio_maximo')->exists($habilitarProducto->archivo_estudio_original)){
                    Storage::disk('precio_maximo')->delete($habilitarProducto->archivo_estudio_original);
                }
                $archivo_nombre = time() .$request->file('archivo_estudio_original')->getClientOriginalName();
                Storage::disk('precio_maximo')->put($archivo_nombre, File::get($request->file('archivo_estudio_original')));
                $habilitarProducto->archivo_estudio_original = $archivo_nombre;
            }

            if($request->file('archivo_estudio_publico')){
                if(Storage::disk('precio_maximo')->exists($habilitarProducto->archivo_estudio_publico)){
                    Storage::disk('precio_maximo')->delete($habilitarProducto->archivo_estudio_publico);
                }
                $archivo_nombre = time() .$request->file('archivo_estudio_publico')->getClientOriginalName();
                Storage::disk('precio_maximo')->put($archivo_nombre, File::get($request->file('archivo_estudio_publico')));
                $habilitarProducto->archivo_estudio_publico = $archivo_nombre;
            }
            $habilitarProducto->update();



            $contratoId = $this->hashDecode(session('contrato'));
            $countProducto = HabilitarProducto::countProducto($contratoId);
            
            if(count($countProducto) == 1 && $precio == NULL){
               $this->porcentajeContrato(17,$contratoId);
               $this->seccionTerminada('producto',$contratoId);
            }

            $catProducto = CatProducto::find($habilitarProducto->cat_producto_id);
            $catProducto->habilitado = true;
            $catProducto->update();

            $response = array('success' => true, 'message' => 'Producto habilitado correctamente.');
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al habilitar el producto.'];
        }
        return $response;
    }

    public function data()
    {
        $habilitarProductos = $this->hashEncode(HabilitarProducto::todos($this->hashDecode(session('contrato'))));
        $habilitarProductos = $this->hashEncodeId($habilitarProductos,'cat_producto_id');

        return Datatables::of($habilitarProductos)->toJson();
    }

    public function catalogo($id)
    {
        $id = $this->hashDecode($id);
        $catProducto = $this->hashEncode(CatProducto::find($id));

        return array('success' => true, 'data' => $catProducto);        
    }

    public function producto($id)
    {
        $id = $this->hashDecode($id);
        $productos = $this->hashEncode(ProveedorFichaProducto::producto($id));
        
        return Datatables::of($productos)->toJson();
    }

    public function showProducto($id)
    {
        $producto = $this->hashEncode(ProveedorFichaProducto::fichaProducto($this->hashDecode($id)));
        $producto[0]->color = json_decode($producto[0]->color);
        $producto[0]->dimensiones = json_decode($producto[0]->dimensiones);
        $producto[0]->documentacion_incluida = json_decode($producto[0]->documentacion_incluida);

        return view('admin.habilitar-producto.producto_show')->with(['producto' => $producto[0]]);        
    }

    public function modalEconomica($producto){
        $id = $this->hashDecode($producto);

        $economicas = ValidacionEconomica::economicaAll($id);
        $nombre = $economicas[0]->nombre_producto;
        return view('admin.habilitar-producto.modals.modal_economica')->with(['economicas' => $economicas, 'nombre' => $nombre]);
    }

    public function modalPublicar($producto){
        $id =  $this->hashDecode($producto);
        $nombre = ProveedorFichaProducto::select('nombre_producto')->where('id',$id)->first();

        return view('admin.habilitar-producto.modals.modal_publicar')->with(['nombre' => $nombre]);
    }

    public function publicarProducto(Request $request){
        $id  = $this->hashDecode($request->input('producto_id'));
        $producto = ProveedorFichaProducto::find($id);
        $catProducto = CatProducto::find($producto->producto_id);
        
        if(($producto->validacion_precio == true and $producto->validacion_administracion == true and $producto->validacion_tecnica == true) or ($producto->validacion_precio == true and $producto->validacion_administracion == true and $catProducto->validacion_tecnica == false))
        {
            $producto->publicado = true;
            $producto->update();
            $response = array('success' => true, 'message' => 'Producto publicado correctamente.');
        }
        else{
            $response = ['success' => false, 'message' => 'El producto no se a podido publicar faltan validaciones.'];
        }

        return $response;
        
    }

    public function modalShowTecnica($producto){
        $id = $this->hashDecode($producto);
        $nombre = ProveedorFichaProducto::find($id)->pluck('nombre_producto');
        $tecnicas = ValidadorTecnico::tecnicoAll($id);
        
        return view('admin.habilitar-producto.modals.modal_show_tecnica')->with(['tecnicas' => $tecnicas, 'nombre' => $nombre[0]]);
    }
}
