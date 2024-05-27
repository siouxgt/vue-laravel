<?php

namespace App\Http\Controllers;

use App\Models\Submenu;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubmenuController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function show(Submenu $submenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $id = $this->hashDecode($id);
        $submenu = $this->hashEncode(Submenu::find($id));

        return view('admin.modals.edit_submenu_modal')->with(['submenu' => $submenu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seccion = $request->input('seccion');
        $id = $this->hashDecode($id);
        $submenu = Submenu::find($id);
        switch ($seccion) {
            case 'alta':
                try {
                    $submenu->fecha_inicio_alta = Carbon::createFromFormat('d/m/Y',$request->input('fecha_inicio_'.$seccion));
                    $submenu->fecha_fin_alta = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fin_'.$seccion));
                    $submenu->update();

                    $response = array('success' => true, 'message' => 'Fecha '.$seccion.' agregada correctamente.','fecha_inicio'=> $submenu->fecha_inicio_alta, 'fecha_fin' => $submenu->fecha_fin_alta );
                            
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al agregar la fecha de '.$seccion.'.'];
                }
            break;
            case 'expediente':
                try {
                    $submenu->fecha_inicio_expediente = Carbon::createFromFormat('d/m/Y',$request->input('fecha_inicio_'.$seccion));
                    $submenu->fecha_fin_expediente = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fin_'.$seccion));
                    $submenu->update();

                    $response = array('success' => true, 'message' => 'Fecha '.$seccion.' agregada correctamente.','fecha_inicio'=> $submenu->fecha_inicio_expediente,'fecha_fin' => $submenu->fecha_fin_expediente );
                            
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al agregar la fecha de '.$seccion.'.'];
                }
            break;
            case 'revisor':
                try {
                    $submenu->fecha_inicio_revisor = Carbon::createFromFormat('d/m/Y',$request->input('fecha_inicio_'.$seccion));
                    $submenu->fecha_fin_revisor = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fin_'.$seccion));
                    $submenu->update();

                    $response = array('success' => true, 'message' => 'Fecha '.$seccion.' agregada correctamente.','fecha_inicio'=> $submenu->fecha_inicio_revisor, 'fecha_fin' => $submenu->fecha_fin_revisor );
                            
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al agregar la fecha de '.$seccion.'.'];
                }
            break;
            case 'proveedor':
                try {
                    $submenu->fecha_inicio_proveedor = Carbon::createFromFormat('d/m/Y',$request->input('fecha_inicio_'.$seccion));
                    $submenu->fecha_fin_proveedor = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fin_'.$seccion));
                    $submenu->update();

                    $response = array('success' => true, 'message' => 'Fecha '.$seccion.' agregada correctamente.','fecha_inicio'=> $submenu->fecha_inicio_proveedor, 'fecha_fin' => $submenu->fecha_fin_proveedor );
                            
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al agregar la fecha de '.$seccion.'.'];
                }
            break;
            case 'producto':
                try {
                    $submenu->fecha_inicio_producto = Carbon::createFromFormat('d/m/Y',$request->input('fecha_inicio_'.$seccion));
                    $submenu->fecha_fin_producto = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fin_'.$seccion));
                    $submenu->update();

                    $response = array('success' => true, 'message' => 'Fecha '.$seccion.' agregada correctamente.','fecha_inicio'=> $submenu->fecha_inicio_producto, 'fecha_fin' => $submenu->fecha_fin_producto );
                            
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al agregar la fecha de '.$seccion.'.'];
                }
            break;
            case 'urg':
                try {
                    $submenu->fecha_inicio_urg = Carbon::createFromFormat('d/m/Y',$request->input('fecha_inicio_'.$seccion));
                    $submenu->fecha_fin_urg = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fin_'.$seccion));
                    $submenu->update();

                    $response = array('success' => true, 'message' => 'Fecha '.$seccion.' agregada correctamente.','fecha_inicio'=> $submenu->fecha_inicio_urg, 'fecha_fin' => $submenu->fecha_fin_urg );
                            
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al agregar la fecha de '.$seccion.'.'];
                }
            break;
        }
        
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Submenu  $submenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submenu $submenu)
    {
        //
    }
}
