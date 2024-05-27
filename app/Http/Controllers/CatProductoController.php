<?php

namespace App\Http\Controllers;

use App\Models\CatProducto;
use App\Models\ContratoMarco;
use App\Models\HabilitarProducto;
use App\Models\ValidacionesTecnicas;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;


class CatProductoController extends Controller
{
    use HashIdTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.catalogos.producto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contratos = $this->hashEncode(ContratoMarco::all());
        $validaciones = ValidacionesTecnicas::where('estatus',1)->get();

        $ultimoId = catProducto::ultimo();
        $ultimo = 1;
        if(isset($ultimoId->id)){
            $ultimo = $ultimoId[0]->id +1;
        }
        
        return view('admin.catalogos.producto.create')->with(['contratos' => $contratos, 'validaciones' => $validaciones,'ultimo' => $ultimo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $catProducto = new CatProducto;
            $catProducto->numero_ficha = $request->input('numero_ficha');
            $catProducto->version = $request->input('version');
            $catProducto->capitulo = $request->input('capitulo');
            $catProducto->partida = $request->input('partida');
            $catProducto->cabms = $request->input('cabms');
            $catProducto->descripcion = $request->input('descripcion');
            $catProducto->nombre_corto = $request->input('nombre_corto');
            $catProducto->especificaciones = $request->input('especificaciones');
            $catProducto->medida = $request->input('medida');
            $catProducto->validacion_tecnica = $request->input('validacion_tecnica');
            $catProducto->tipo_prueba = $request->input('tipo_prueba');
            $catProducto->estatus = $request->input('estatus')? 1 : 0;

            if($request->file('archivo_ficha_tecnica')){
                $nombre = $request->file('archivo_ficha_tecnica')->getClientOriginalName();
                Storage::disk('cat_producto')->put($nombre, File::get($request->file('archivo_ficha_tecnica')));
                $catProducto->archivo_ficha_tecnica = $nombre;
            }

            $catProducto->contrato_marco_id = $this->hashDecode($request->input('contrato'));
            $catProducto->validacion_id = $request->input('equipo_validacion');
            $catProducto->save();

            $habilitarProducto = new HabilitarProducto();
            $habilitarProducto->cat_producto_id = $catProducto->id;
            $habilitarProducto->save();

            return redirect()->route('cat_producto.index')->with('error','success');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error','error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CatProducto  $catProducto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $this->hashDecode($id);

        $catProducto = $this->hashEncode(CatProducto::find($id));
        $habilitarProducto = HabilitarProducto::productoHabilitado($id);
        if($habilitarProducto)
        {
            $habilitarProducto = $habilitarProducto[0];
        }
        
        return view('admin.catalogos.producto.show')->with(['catProducto' => $catProducto, 'habilitarProducto' => $habilitarProducto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CatProducto  $catProducto
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $contratos = $this->hashEncode(ContratoMarco::all());
        $validaciones = ValidacionesTecnicas::where('estatus',1)->get();

        $catProducto = $this->hashEncode(CatProducto::find($id));

        $catProducto = $this->hashEncodeIdClave($catProducto,'contrato_marco_id','contrato_m_id');

        $enUso = CatProducto::enUso($id);

        return view('admin.catalogos.producto.edit')->with(['contratos' => $contratos, 'validaciones' => $validaciones, 'catProducto' => $catProducto, 'enUso' => $enUso]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CatProducto  $catProducto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $this->hashDecode($id);
        try {
            $catProducto = CatProducto::find($id);
            $catProducto->numero_ficha = $request->input('numero_ficha');
            if($request->input('nueva_version')){
                $catProducto->version = $catProducto->version + 1;
            }
            $catProducto->capitulo = $request->input('capitulo');
            $catProducto->partida = $request->input('partida');
            $catProducto->cabms = $request->input('cabms');
            $catProducto->descripcion = $request->input('descripcion');
            $catProducto->nombre_corto = $request->input('nombre_corto');
            $catProducto->especificaciones = $request->input('especificaciones');
            $catProducto->medida = $request->input('medida');
            $catProducto->validacion_tecnica = $request->input('validacion_tecnica');
            $catProducto->tipo_prueba = $request->input('tipo_prueba');
            $catProducto->estatus = $request->input('estatus')? 1 : 0;

            if($request->file('archivo_ficha_tecnica')){
                if(Storage::disk('public')->exists($catProducto->archivo_ficha_tecnica)){
                    Storage::disk('public')->delete($catProducto->archivo_ficha_tecnica);
                }
                $nombre = $request->file('archivo_ficha_tecnica')->getClientOriginalName();
                Storage::disk('cat_producto')->put($nombre, File::get($request->file('archivo_ficha_tecnica')));
                $catProducto->archivo_ficha_tecnica = $nombre;
            }

            $catProducto->contrato_marco_id = $this->hashDecode($request->input('contrato'));
            $catProducto->validacion_id = $request->input('equipo_validacion');
            $catProducto->update();

            return redirect()->route('cat_producto.index')->with('error','success');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error','error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CatProducto  $catProducto
     * @return \Illuminate\Http\Response
     */
    public function destroy(CatProducto $catProducto)
    {
        //
    }

    public function data(){
        $catProductos = $this->hashEncode(catProducto::allCatProductos());
        
        return Datatables::of($catProductos)->toJson();
    }
}
