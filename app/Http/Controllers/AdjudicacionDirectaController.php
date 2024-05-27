<?php

namespace App\Http\Controllers;

use App\Models\AdjudicacionDirecta;
use App\Models\AnexosAdjudicacion;
use App\Models\ExpedienteContratoMarco;
use App\Models\Proveedor;
use App\Traits\ExpedienteTrait;
use App\Traits\HashIdTrait;
use App\Traits\ProveedoresTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



class AdjudicacionDirectaController extends Controller
{
    use HashIdTrait, ProveedoresTrait, ExpedienteTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adjudicaciones = AdjudicacionDirecta::all();
        $adjudicaciones = $this->hashEncode($adjudicaciones);

        return view('admin.adjudicacion-directa.index')->with(['adjudicaciones' => $adjudicaciones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::rfcProveedor();

        return view('admin.adjudicacion-directa.create')->with(['proveedores' => $proveedores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ultimoId = AdjudicacionDirecta::ultimo();
        $ultimo = 1;
        if(isset($ultimoId[0]->id)){
            $ultimo = $ultimoId[0]->id + 1;
        }
        $expediente_id = $this->hashDecode($request->input('expediente_id'));
        try {
            $adjudicacion = new AdjudicacionDirecta;
            $adjudicacion->articulo = $request->input('articulo');
            $adjudicacion->fraccion = $request->input('fraccion');
            $adjudicacion->fecha_sesion = $request->input('fecha_sesion') != null ? Carbon::createFromFormat('d/m/Y',$request->input('fecha_sesion')) : null;
            $adjudicacion->numero_sesion = $request->input('numero_sesion');
            $adjudicacion->numero_cotizacion = $request->input('numero_cotizacion');
            $adjudicacion->expediente_id = $expediente_id;

            $carpeta = 'adjudicacion-directa-'.$ultimo;            
            Storage::disk('public')->makeDirectory($carpeta,0755,true);

            if($request->file('aprobacion_original')){
                $archivo_nombre = $request->file('aprobacion_original')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_original')));
                $adjudicacion->archivo_aprobacion_original = $archivo_nombre;
            }
            if ($request->file('aprobacion_publica')) {
                $archivo_nombre = $request->file('aprobacion_publica')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_publica')));
                $adjudicacion->archivo_aprobacion_publica = $archivo_nombre;   
            }

            $adjudicacion->save();

            $this->porcentaje(34,$expediente_id); 
            
            $id_hast = $this->hashEncode($adjudicacion);

            $response = array('success' => true, 'message' => 'Adjudicación directa guardado correctamente.', 'id' => $id_hast);    
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al guardar la adjudicación directa.'];
        }
        
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdjudicacionDirecta  $adjudicacionDirecta
     * @return \Illuminate\Http\Response
     */
    public function show(AdjudicacionDirecta $adjudicacionDirecta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdjudicacionDirecta  $adjudicacionDirecta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $adjudicacion = AdjudicacionDirecta::find($id);
        $adjudicacion = $this->hashEncode($adjudicacion);
        $carpeta = "adjudicacion-directa-".$adjudicacion->id;
        if($adjudicacion->proveedores_adjudicado)
        {
            $proveedores = json_decode($adjudicacion->proveedores_adjudicado)->proveedores;
        }
        else{
            $proveedores = Proveedor::rfcProveedor();
            $proveedores = $this->proveedoresEdit($proveedores);
        }
        $countAnexos = AnexosAdjudicacion::where('adjudicacion_directa_id',$id)->count();

        return view('admin.adjudicacion-directa.edit')->with(['adjudicacion' => $adjudicacion, 'proveedores' => $proveedores, 'countAnexos' => $countAnexos, 'carpeta' => $carpeta]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdjudicacionDirecta  $adjudicacionDirecta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->hashDecode($request->input('id_adjudicacion'));
        $adjudicacion = AdjudicacionDirecta::find($id);
        switch ($request->input('update')) {
            case 1:
                try {
                    $carpeta = 'adjudicacion-directa-'.$id;
                    $adjudicacion->articulo = $request->input('articulo');
                    $adjudicacion->fraccion = $request->input('fraccion');
                    $adjudicacion->fecha_sesion = $request->input('fecha_sesion');
                    $adjudicacion->numero_sesion = $request->input('numero_sesion');
                    $adjudicacion->numero_cotizacion = $request->input('numero_cotizacion');
                    if($request->file('aprobacion_original')){
                         if(Storage::disk('public')->exists($carpeta."/".$adjudicacion->archivo_aprobacion_original)){
                            Storage::disk('public')->delete($carpeta."/".$adjudicacion->archivo_aprobacion_original);
                        }
                        $archivo_nombre = $request->file('aprobacion_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_original')));
                        $adjudicacion->archivo_aprobacion_original = $archivo_nombre;
                    }
                    if ($request->file('aprobacion_publica')) {
                        if(Storage::disk('public')->exists($carpeta."/".$adjudicacion->archivo_aprobacion_publica)){
                            Storage::disk('public')->delete($carpeta."/".$adjudicacion->archivo_aprobacion_publica);
                        }
                        $archivo_nombre = $request->file('aprobacion_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_publica')));
                        $adjudicacion->archivo_aprobacion_publica = $archivo_nombre;   
                    }

                    $adjudicacion->update();
                    $response = array('success' => true, 'message' => 'Adjudicacion directa actualizada correctamente.');
                    
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al actualizar la adjudicacion directa.'];
                }
            break;
            case 2:
                $proveedores = $this->proveedoresJson($request);
                try {
                    $aux = $adjudicacion->proveedores_adjudicado;
                        
                    $adjudicacion->proveedores_adjudicado = json_encode($proveedores);
                    $adjudicacion->numero_proveedores_adjudicado = $request->input('numero_proveedores');
                    $adjudicacion->update();

                    if($aux == null and $adjudicacion->wasChanged()){
                        $this->porcentaje(34,$adjudicacion->expediente_id); 
                    }

                    $this->habilitarProveedor($proveedores,$adjudicacion->expediente_id);
                    $response = array('success' => true, 'message' => 'Adjudicacion directa actualizada correctamente.');
                    
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al actualizar la adjudicacion directa.'];
                }
            break;
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdjudicacionDirecta  $adjudicacionDirecta
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdjudicacionDirecta $adjudicacionDirecta)
    {
        //
    }
}
