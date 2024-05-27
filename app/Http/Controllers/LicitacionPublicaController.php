<?php

namespace App\Http\Controllers;

use App\Models\ExpedienteContratoMarco;
use App\Models\LicitacionPublica;
use App\Models\Proveedor;
use App\Traits\ExpedienteTrait;
use App\Traits\HashIdTrait;
use App\Traits\ProveedoresTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LicitacionPublicaController extends Controller
{
    use HashIdTrait, ProveedoresTrait, ExpedienteTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $licitaciones = LicitacionPublica::all();
         $licitaciones = $this->hashEncode($licitaciones);

         return view('admin.licitacion-publica.index')->with(['licitaciones' => $licitaciones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::rfcProveedor();

        return view('admin.licitacion-publica.create')->with(['proveedores' => $proveedores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $expediente_id = $this->hashDecode($request->input('expediente_id'));
        try {
            $licitacion = new LicitacionPublica;
            $licitacion->tiangis = $request->input('tianguis');
            $licitacion->tipo_licitacion = $request->input('tipo_licitacion');
            $licitacion->tipo_contratacion = $request->input('tipo_contratacion');
            $licitacion->fecha_convocatoria = Carbon::createFromFormat('d/m/Y',$request->input('fecha_convocatoria'));
            $licitacion->expediente_id = $expediente_id;

            $licitacion->save();
            
            $this->porcentaje(17,$expediente_id); 
                        

            $id_hast = $this->hashEncode($licitacion);

            $response = array('success' => true, 'message' => 'Licitación pública guardado correctamente.', 'id' => $id_hast);
            
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al guardar la licitación pública.'];
        }
        
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LicitacionPublica  $licitacionPublica
     * @return \Illuminate\Http\Response
     */
    public function show(LicitacionPublica $licitacionPublica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LicitacionPublica  $licitacionPublica
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $licitacion = LicitacionPublica::find($id);
        $licitacion = $this->hashEncode($licitacion);
        $carpeta = "licitacion-publica-".$licitacion->id;
        $proveedores = Proveedor::rfcProveedor();

        $proveedoresBase = $licitacion->proveedores_base != null ? json_decode($licitacion->proveedores_base)->proveedores : $this->proveedoresEdit($proveedores);
        $proveedoresPropuesta = $licitacion->proveedores_propuesta != null ? json_decode($licitacion->proveedores_propuesta)->proveedores : ($licitacion->proveedores_base != null ? $this->proveedoresSeleccionadosObjeto(json_decode($licitacion->proveedores_base)->proveedores) : []);
        $proveedoresDescalificado = $licitacion->proveedores_descalificados != null ? json_decode($licitacion->proveedores_descalificados)->proveedores : []; 
        $proveedoresAprobados = $licitacion->proveedores_aprobados != null ? json_decode($licitacion->proveedores_aprobados)->proveedores : ($licitacion->proveedores_descalificados != null ? $this->proveedoresCalificadosObjeto(json_decode($licitacion->proveedores_descalificados)->proveedores) : []);
        $proveedoresAdjudicados = $licitacion->proveedores_adjudicados != null ? json_decode($licitacion->proveedores_adjudicados)->proveedores : [];


        return view('admin.licitacion-publica.edit')->with(['licitacion' => $licitacion, 'carpeta' => $carpeta, 'proveedoresBase' => $proveedoresBase, 'proveedoresPropuesta' => $proveedoresPropuesta, 'proveedoresDescalificado' => $proveedoresDescalificado, 'proveedoresAprobados' => $proveedoresAprobados, 'proveedoresAdjudicados' => $proveedoresAdjudicados ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LicitacionPublica  $licitacionPublica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->hashDecode($request->input('id_licitacion'));
        $licitacion = LicitacionPublica::find($id);
        $carpeta = 'licitacion-publica-'.$id;            
        switch ($request->input('update')) {
            case 1:
                try {
                    $licitacion->tiangis = $request->input('tianguis');
                    $licitacion->tipo_licitacion = $request->input('tipo_licitacion');
                    $licitacion->tipo_contratacion = $request->input('tipo_contratacion');
                    $licitacion->fecha_convocatoria = Carbon::createFromFormat('d/m/Y',$request->input('fecha_convocatoria'));

                    $licitacion->update();

                    $response = array('success' => true, 'message' => 'Licitación pública actualizada correctamente.');

                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al actualizar la licitación pública.'];
                }
            break;
            case 2:
                try {
                    $aux = $licitacion->proveedores_base;

                    $proveedores = $this->proveedoresJson($request);
                    $licitacion->numero_proveedores_base = $request->input('numero_proveedores_base');
                    $licitacion->proveedores_base = $proveedores;
                    Storage::disk('public')->makeDirectory($carpeta,0755,true);

                    if($request->file('base_licitacion')){
                        $archivo_nombre = $request->file('base_licitacion')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('base_licitacion')));
                        $licitacion->archivo_base_licitacion = $archivo_nombre;
                    }
                    $licitacion->update();

                    if($aux == null and $licitacion->wasChanged()){
                        $this->porcentaje(17,$licitacion->expediente_id); 
                    }

                    $proveedoresSeleccionados = $this->proveedoresSeleccionados($proveedores);
                    
                    $response = array('success' => true, 'message' => 'Licitación pública actualizada correctamente.','proveedores' => $proveedoresSeleccionados);
                    
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al actualizar la licitación pública.'];
                }
            break;
            case 3:
                try {
                    $aux = $licitacion->fecha_aclaracion;

                    $licitacion->fecha_aclaracion = Carbon::createFromFormat('d/m/Y',$request->input('fecha_aclaracion'));

                    if($request->file('acta_declaracion_original')){
                        $archivo_nombre = $request->file('acta_declaracion_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('acta_declaracion_original')));
                        $licitacion->archivo_acta_declaracion_original = $archivo_nombre;
                    }

                    if($request->file('acta_declaracion_publica')){
                        $archivo_nombre = $request->file('acta_declaracion_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('acta_declaracion_publica')));
                        $licitacion->archivo_acta_declaracion_publico = $archivo_nombre;
                    }

                    $licitacion->update();

                    if($aux == null and $licitacion->wasChanged()){
                       $this->porcentaje(17,$licitacion->expediente_id); 
                    }

                    $response = array('success' => true, 'message' => 'Licitación pública actualizada correctamente.');
                    
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al actualizar la licitación pública.'];
                }
            break;
            case 4:
                try {
                    $aux = $licitacion->proveedores_propuesta;

                    $proveedores = $this->proveedoresJson($request);
                    $proveedores_ = $request->input('_rfc') ?  $this->proveedoresJson_($request) : null;

                    $licitacion->fecha_propuesta = Carbon::createFromFormat('d/m/Y',$request->input('fecha_propuesta'));
                    $licitacion->numero_proveedores_propuesta = $request->input('numero_proveedores_propuesta');
                    $licitacion->proveedores_propuesta = $proveedores;
                    $licitacion->numero_proveedores_descalificados = $request->input('numero_proveedores_descalificados');
                    $licitacion->proveedores_descalificados = $proveedores_;

                    if($request->file('acta_presentacion_original')){
                        $archivo_nombre = $request->file('acta_presentacion_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('acta_presentacion_original')));
                        $licitacion->archivo_acta_presentacion_original = $archivo_nombre;
                    }

                    if($request->file('acta_presentacion_publica')){
                        $archivo_nombre = $request->file('acta_presentacion_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('acta_presentacion_publica')));
                        $licitacion->archivo_acta_presentacion_publico = $archivo_nombre;
                    }
                    $licitacion->update();

                    if($aux == null and $licitacion->wasChanged()){
                        $this->porcentaje(17,$licitacion->expediente_id); 
                    }

                    $proveedoresCalificados = $proveedores_ != [] ? $this->proveedoresCalificados($proveedores_) : [];
                    $response = array('success' => true, 'message' => 'Licitación pública actualizado correctamente.','proveedores' => $proveedoresCalificados);
                    
                } catch (\Exception $e) {
                     $response = ['success' => false, 'message' => 'Error al actualizar la licitación pública.'];
                }
            break;
            case 5:
                try{
                    $aux = $licitacion->proveedores_aprobados;

                    $proveedores = $this->proveedoresJson($request);
                    $proveedores_ =  $request->input('_rfc') ?  $this->proveedoresJson_($request) : null;
                    $licitacion->fecha_fallo = Carbon::createFromFormat('d/m/Y',$request->input('fecha_fallo'));
                    $licitacion->numero_proveedores_aprobados = $request->input('numero_proveedores_aprobados');
                    $licitacion->proveedores_aprobados = $proveedores;
                    $licitacion->numero_proveedores_adjudicados = $request->input('numero_proveedores_adjudicados');
                    $licitacion->proveedores_adjudicados = $proveedores_;
                    $this->habilitarProveedor($proveedores_,$licitacion->expediente_id);

                    if($request->file('acta_fallo_original')){
                        $archivo_nombre = $request->file('acta_fallo_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('acta_fallo_original')));
                        $licitacion->archivo_acta_fallo_original = $archivo_nombre;
                    }

                    if($request->file('acta_fallo_publica')){
                        $archivo_nombre = $request->file('acta_fallo_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('acta_fallo_publica')));
                        $licitacion->archivo_acta_fallo_publica = $archivo_nombre;
                    }

                    if($request->file('oficio_adjudicacion_original')){
                        $archivo_nombre = $request->file('oficio_adjudicacion_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('oficio_adjudicacion_original')));
                        $licitacion->archivo_oficio_adjudicacion_original = $archivo_nombre;
                    }

                    if($request->file('oficio_adjudicacion_publica')){
                        $archivo_nombre = $request->file('oficio_adjudicacion_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('oficio_adjudicacion_publica')));
                        $licitacion->archivo_oficio_adjudicacion_publico = $archivo_nombre;
                    }

                    $licitacion->update();

                    if($aux == null and $licitacion->wasChanged()){
                        $this->porcentaje(17,$licitacion->expediente_id); 
                    }

                    $response = array('success' => true, 'message' => 'Licitación pública actualizado correctamente.');

                } catch(\Exception $e){
                    $response = ['success' => false, 'message' => 'Error al actualizar la licitación pública.'];
                }
            break;
        }
        return $response;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LicitacionPublica  $licitacionPublica
     * @return \Illuminate\Http\Response
     */
    public function destroy(LicitacionPublica $licitacionPublica)
    {
       //
    }

}
