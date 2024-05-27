<?php

namespace App\Http\Controllers;

use App\Models\ProveedorFichaProducto;
use App\Models\ValidacionAdministrativa;
use App\Models\ValidacionEconomica;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ValidacionAdministrativaController extends Controller
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
        try {
            $producto_id  = $this->hashDecode($request->input('producto_id'));
            $valAdmin = new ValidacionAdministrativa;
            $valAdmin->aceptada = $request->input('aceptada');
            $valAdmin->fecha_revision = Carbon::createFromFormat('d/m/Y',$request->input('fecha_revision'));
            $valAdmin->comentario = $request->input('comentario');
            $valAdmin->producto_id = $producto_id;
            $valAdmin->save();

            $fichaProducto = ProveedorFichaProducto::find($producto_id);
            $fichaProducto->validacion_administracion = $request->input('aceptada');
            $fichaProducto->update();
            
            $response = array('success' => true, 'message' => 'Validación administrativa registrada correctamente.', 'data' => $valAdmin->aceptada);

        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al registar la validación administrativa.'];
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ValidacionAdministrativa  $validacionAdministrativa
     * @return \Illuminate\Http\Response
     */
    public function show(ValidacionAdministrativa $validacionAdministrativa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ValidacionAdministrativa  $validacionAdministrativa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $nombre = ProveedorFichaProducto::select('nombre_producto')->where('id',$id)->first();
        $administrativas = ValidacionAdministrativa::adminAll($id);
        
        return view('admin.habilitar-producto.modals.modal_administrativa')->with(['administrativas' => $administrativas, 'nombre' => $nombre]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ValidacionAdministrativa  $validacionAdministrativa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ValidacionAdministrativa $validacionAdministrativa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ValidacionAdministrativa  $validacionAdministrativa
     * @return \Illuminate\Http\Response
     */
    public function destroy(ValidacionAdministrativa $validacionAdministrativa)
    {
        //
    }
}
