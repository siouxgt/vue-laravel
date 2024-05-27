<?php

namespace App\Http\Controllers;

use App\Models\AnexosRestringida;
use App\Models\ExpedienteContratoMarco;
use App\Models\InvitacionRestringida;
use App\Traits\ExpedienteTrait;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class AnexosRestringidaController extends Controller
{
    use HashIdTrait, ExpedienteTrait;
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
        return view('admin.modals.create_anexos_modal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $this->hashDecode($request->input('id_invitacion'));
         try {

            $anexo = new AnexosRestringida;
            $anexo->nombre = $request->input('nombre');
            $carpeta = 'invitacion-restringida-'.$id;            
            Storage::disk('public')->makeDirectory($carpeta,0755,true);
            if($request->file('archivo_original')){
                $archivo_nombre = $request->file('archivo_original')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_original')));
                $anexo->archivo_original = $archivo_nombre;
            }
             if($request->file('archivo_publica')){
                $archivo_nombre = $request->file('archivo_publica')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_publica')));
                $anexo->archivo_publica = $archivo_nombre;
            }
            $anexo->invitacion_restringida_id = $id;
            $anexo->save();
            $countAnexos = AnexosRestringida::where('invitacion_restringida_id',$id)->count();
            if($countAnexos == 2){
                $invitacion = InvitacionRestringida::find($id);
                $this->porcentaje(20,$invitacion->expediente_id);
            }
            $response = array('success' => true, 'message' => 'Anexo de invitación restringida guardado correctamente.');    

         } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al guardar el anexo de invitación restringida.'];
         }

         return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnexosRestringida  $anexosRestringida
     * @return \Illuminate\Http\Response
     */
    public function show(AnexosRestringida $anexosRestringida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnexosRestringida  $anexosRestringida
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $anexoRestringida = AnexosRestringida::find($id);
        $anexoRestringida = $this->hashEncode($anexoRestringida);
        
        return view('admin.modals.edit_anexos_modal')->with(['anexo' => $anexoRestringida]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnexosRestringida  $anexosRestringida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->hashDecode($request->input('id_anexo'));
        
        $anexoRestringida = AnexosRestringida::find($id);
        $carpeta = "invitacion-restringida-".$anexoRestringida->invitacion_restringida_id;
        try {
            $anexoRestringida->nombre = $request->input('nombre');

            if($request->file('archivo_original')){
                Storage::disk('public')->delete($carpeta."/".$anexoRestringida->archivo_original);
                $archivo_nombre = $request->file('archivo_original')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_original')));
                $anexoRestringida->archivo_original = $archivo_nombre;
            }
            if($request->file('archivo_publica')){
                Storage::disk('public')->delete($carpeta."/".$anexoRestringida->archivo_publica);
                $archivo_nombre = $request->file('archivo_publica')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_publica')));
                $anexoRestringida->archivo_publica = $archivo_nombre;
            }
            $anexoRestringida->update();

            $response = array('success' => true, 'message' => 'Anexo de invitación restringida actualizado correctamente.');    
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al actualizar el anexo de invitación restringida.'];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnexosRestringida  $anexosRestringida
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnexosRestringida $anexosRestringida)
    {
        //
    }

    public function data($id_invitacion){
        
        $id = $this->hashDecode($id_invitacion);
        $anexos = AnexosRestringida::anexos($id);
        
        $anexos = $this->hashEncode($anexos);

        return Datatables::of($anexos)->toJson();
    }
}
