<?php

namespace App\Http\Controllers;

use App\Models\AdjudicacionDirecta;
use App\Models\AnexosAdjudicacion;
use App\Models\ExpedienteContratoMarco;
use App\Traits\ExpedienteTrait;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;

class AnexosAdjudicacionController extends Controller
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
         $id = $this->hashDecode($request->input('id_adjudicacion'));
         try {

            $anexo = new AnexosAdjudicacion;
            $anexo->nombre = $request->input('nombre');
            $carpeta = 'adjudicacion-directa-'.$id;            
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
            $anexo->adjudicacion_directa_id = $id;
            $anexo->save();
            $countAnexos = AnexosAdjudicacion::where('adjudicacion_directa_id',$id)->count();
            if($countAnexos == 2){
                $adjudicacion = AdjudicacionDirecta::find($id);
                $this->porcentaje(32,$adjudicacion->expediente_id);
            }
            $response = array('success' => true, 'message' => 'Anexo de adjudicacion guardado correctamente.');    

         } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al guardar el anexo de adjudicacion.'];
         }

         return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnexosAdjudicacion  $anexosAdjudicacion
     * @return \Illuminate\Http\Response
     */
    public function show(AnexosAdjudicacion $anexosAdjudicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnexosAdjudicacion  $anexosAdjudicacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $anexoAdjudicacion = AnexosAdjudicacion::find($id);
        $anexoAdjudicacion = $this->hashEncode($anexoAdjudicacion);

        return view('admin.modals.edit_anexos_modal')->with(['anexo' => $anexoAdjudicacion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnexosAdjudicacion  $anexosAdjudicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $id = $this->hashDecode($request->input('id_anexo'));
        
        $anexoAdjudicacion = AnexosAdjudicacion::find($id);
        $carpeta = "adjudicacion-directa-".$anexoAdjudicacion->adjudicacion_directa_id;
        try {
            $anexoAdjudicacion->nombre = $request->input('nombre');

            if($request->file('archivo_original')){
                if(Storage::disk('public')->exists($carpeta."/".$anexoAdjudicacion->archivo_original)){
                    Storage::disk('public')->delete($carpeta."/".$anexoAdjudicacion->archivo_original);
                }
                $archivo_nombre = $request->file('archivo_original')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_original')));
                $anexoAdjudicacion->archivo_original = $archivo_nombre;
            }
            if($request->file('archivo_publica')){
                if(Storage::disk('public')->exists($carpeta."/".$anexoAdjudicacion->archivo_publica)){
                    Storage::disk('public')->delete($carpeta."/".$anexoAdjudicacion->archivo_publica);
                }
                $archivo_nombre = $request->file('archivo_publica')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_publica')));
                $anexoAdjudicacion->archivo_publica = $archivo_nombre;
            }
            $anexoAdjudicacion->update();

            $response = array('success' => true, 'message' => 'Anexo de adjudicación directa actualizado correctamente.');    
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al actualizar el anexo de adjudicación directa.'];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnexosAdjudicacion  $anexosAdjudicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnexosAdjudicacion $anexosAdjudicacion)
    {
        //
    }

    public function data($id_adjudicacion){
        
        $id = $this->hashDecode($id_adjudicacion);
        $anexos = AnexosAdjudicacion::anexos($id);
        $anexos = $this->hashEncode($anexos);
        
        return Datatables::of($anexos)->toJson();
    }
}
