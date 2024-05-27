<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ValidacionesTecnicas;
use App\Traits\HashIdTrait;
use App\Traits\PersonalTrait;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ValidacionTecnicaController extends Controller
{
    use HashIdTrait, PersonalTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.catalogos.validacion-tecnica.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.catalogos.modals.validacion-tecnica.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validacion = new ValidacionesTecnicas;
            $validacion->estatus = $request->input('estatus_urg')? 1 : 0;
            $validacion->direccion= $request->input('direccion');
            $validacion->siglas = $request->input('siglas');
            $validacion->save();

            $response = array('success' => true, 'message' => 'Validación guardado correctamente.');    
        }
        catch(\Exception $e){
            $response = ['success' => false, 'message' => 'Error al guardar la validación.'.$e];
        }
        return $response;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function show($id_hast)
    {
        $id = $this->hashDecode($id_hast);

        $validacion = ValidacionesTecnicas::find($id);
        $responsables = User::userResponsablesTecnico($validacion->urg_id);
        
        return view('admin.catalogos.validacion-tecnica.show')->with(['validacion' => $validacion, 'responsables' => $responsables]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id_hast)
    {
        $id = $this->hashDecode($id_hast);
        $validacion = $this->hashEncode(ValidacionesTecnicas::find($id));        

        return view('admin.catalogos.modals.validacion-tecnica.edit')->with(['validacion' => $validacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id = $this->hashDecode($request->input('id'));
        $validacion = ValidacionesTecnicas::find($id);
        try{
            $validacion->direccion= $request->input('direccion');
            $validacion->siglas = $request->input('siglas');
            $validacion->estatus = $request->input('estatus_urg')? 1 : 0;
            $validacion->update();
            $response = array('success' => true, 'message' => 'Validación actualizado correctamente.');
         }
        catch(\Exception $e){
            $response = ['success' => false, 'message' => 'Error al actualizar la validación.'];
        }
        return $response;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function data()
    {
        $validacion = ValidacionesTecnicas::allValidacion();

        $validacion = $this->hashEncode($validacion);

        return Datatables::of($validacion)->toJson();
    }
}
