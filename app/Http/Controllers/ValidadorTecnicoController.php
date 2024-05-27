<?php

namespace App\Http\Controllers;

use App\Models\ProveedorFichaProducto;
use App\Models\ValidadorTecnico;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class ValidadorTecnicoController extends Controller
{
    use HashIdTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('validador.validacion-tecnica.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('validador.validacion-tecnica.modals.create_modal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productoId = $this->hashDecode($request->input('producto_id'));
        try {
            $validador = new ValidadorTecnico;
            $validador->aceptada = $request->input('aceptada');
            $validador->fecha_revision = Carbon::createFromFormat('d/m/Y',$request->input('fecha_revision'));
            $validador->comentario = $request->input('comentario');
            $validador->producto_id = $productoId;
            $validador->save();

            $fichaProducto = ProveedorFichaProducto::find($productoId);
            $fichaProducto->validacion_tecnica = $request->input('aceptada');
            $fichaProducto->update();

            $response = array('success' => true, 'message' => 'Validación técnica registrada correctamente.');
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al registar la validación técnica.'];
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ValidadorTecnico  $validadorTecnico
     * @return \Illuminate\Http\Response
     */
    public function show(ValidadorTecnico $validadorTecnico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ValidadorTecnico  $validadorTecnico
     * @return \Illuminate\Http\Response
     */
    public function edit(ValidadorTecnico $validadorTecnico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ValidadorTecnico  $validadorTecnico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ValidadorTecnico $validadorTecnico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ValidadorTecnico  $validadorTecnico
     * @return \Illuminate\Http\Response
     */
    public function destroy(ValidadorTecnico $validadorTecnico)
    {
        //
    }

    public function data(){

        $producto = $this->hashEncode(ProveedorFichaProducto::validacionTecnica(auth()->user()->urg_id));

        return Datatables::of($producto)->toJson();
    }

    public function showProducto($producto_id)
    {
        $id = $this->hashDecode($producto_id);
        $producto = $this->hashEncode(ProveedorFichaProducto::fichaProducto($id));
        $producto[0]->color = json_decode($producto[0]->color);
        $producto[0]->dimensiones = json_decode($producto[0]->dimensiones);
        $producto[0]->documentacion_incluida = json_decode($producto[0]->documentacion_incluida);

        return view('validador.validacion-tecnica.producto_show_validador')->with(['producto' => $producto[0]]);  
    }
}
