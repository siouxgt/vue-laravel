<?php

namespace App\Http\Controllers;

use App\Models\AnexosPublica;
use App\Models\ExpedienteContratoMarco;
use App\Models\LicitacionPublica;
use App\Traits\ExpedienteTrait;
use App\Traits\HashIdTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;


class AnexosPublicaController extends Controller
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
         $id = $this->hashDecode($request->input('id_licitacion'));
         try {

            $anexo = new AnexosPublica;
            $anexo->nombre = $request->input('nombre');
            $carpeta = 'licitacion-publica-'.$id;            
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
            $anexo->licitacion_publica_id = $id;
            $anexo->save();
            $countAnexos = AnexosPublica::where('licitacion_publica_id',$id)->count();
            if($countAnexos == 2){
                $licitacion = LicitacionPublica::find($id);
                $this->porcentaje(15,$licitacion->expediente_id);
            }
            $response = array('success' => true, 'message' => 'Anexo de licitación pública guardado correctamente.');    

         } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al guardar el anexo de licitación pública.'];
         }

         return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnexosPublica  $anexosPublica
     * @return \Illuminate\Http\Response
     */
    public function show(AnexosPublica $anexosPublica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnexosPublica  $anexosPublica
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $anexoPublica = AnexosPublica::find($id);
        $anexoPublica = $this->hashEncode($anexoPublica);
        
        return view('admin.modals.edit_anexos_modal')->with(['anexo' => $anexoPublica]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnexosPublica  $anexosPublica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->hashDecode($request->input('id_anexo'));
        
        $anexoPublica = AnexosPublica::find($id);
        $carpeta = "licitacion-publica-".$anexoPublica->licitacion_publica_id;
        try {
            $anexoPublica->nombre = $request->input('nombre');

            if($request->file('archivo_original')){
                Storage::disk('public')->delete($carpeta."/".$anexoPublica->archivo_original);
                $archivo_nombre = $request->file('archivo_original')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_original')));
                $anexoPublica->archivo_original = $archivo_nombre;
            }
            if($request->file('archivo_publica')){
                Storage::disk('public')->delete($carpeta."/".$anexoPublica->archivo_publica);
                $archivo_nombre = $request->file('archivo_publica')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('archivo_publica')));
                $anexoPublica->archivo_publica = $archivo_nombre;
            }
            $anexoPublica->update();

            $response = array('success' => true, 'message' => 'Anexo de licitación pública actualizado correctamente.');    
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al actualizar el anexo de licitación pública.'];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnexosPublica  $anexosPublica
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnexosPublica $anexosPublica)
    {
        //
    }

    public function data($id_publica){
        $id = $this->hashDecode($id_publica);
        $anexos = AnexosPublica::anexos($id);
        $anexos = $this->hashEncode($anexos);
        
        return Datatables::of($anexos)->toJson();
    }
}
