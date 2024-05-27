<?php

namespace App\Http\Controllers;

use App\Models\ExpedienteContratoMarco;
use App\Models\InvitacionRestringida;
use App\Models\Proveedor;
use App\Traits\ExpedienteTrait;
use App\Traits\HashIdTrait;
use App\Traits\ProveedoresTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvitacionRestringidaController extends Controller
{
    use HashIdTrait, ProveedoresTrait, ExpedienteTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitaciones = InvitacionRestringida::all();
        $invitaciones = $this->hashEncode($invitaciones);

        return view('admin.invitacion-restringida.index')->with(['invitaciones' => $invitaciones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = Proveedor::rfcProveedor();
        
        return view('admin.invitacion-restringida.create')->with(['proveedores' => $proveedores]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ultimoId = InvitacionRestringida::ultimo();
        $ultimo = 1;
        if(isset($ultimoId[0]->id)){
            $ultimo = $ultimoId[0]->id + 1;
        }
        $proveedores = $this->proveedoresJson($request);
        $expediente_id = $this->hashDecode($request->input('expediente_id'));
        try {

            $invitacion = new InvitacionRestringida;
            $invitacion->articulo = $request->input('articulo');
            $invitacion->fraccion = $request->input('fraccion');
            $invitacion->fecha_sesion = $request->input('fecha_sesion') != null ? Carbon::createFromFormat('d/m/Y',$request->input('fecha_sesion')) : null;
            $invitacion->numero_sesion = $request->input('numero_sesion');
            $invitacion->numero_cotizacion = $request->input('numero_cotizacion');
            $invitacion->numero_proveedores_invitados = $request->input('numero_proveedores_invitados');
            $invitacion->proveedores_invitados = json_encode($proveedores);
            $invitacion->expediente_id = $expediente_id;

            $carpeta = 'invitacion-restringida-'.$ultimo;            
            Storage::disk('public')->makeDirectory($carpeta,0755,true);

            if($request->file('aprobacion_original')){
                $archivo_nombre = $request->file('aprobacion_original')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_original')));
                $invitacion->archivo_aprobacion_original = $archivo_nombre;
            }

            if($request->file('aprobacion_publica')){
                $archivo_nombre = $request->file('aprobacion_publica')->getClientOriginalName();
                Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_publica')));
                $invitacion->archivo_aprobacion_publica = $archivo_nombre;
            }
            
            $invitacion->save();

            $this->porcentaje(20,$expediente_id); 
                       
            $proveedoresInvitados = $this->proveedoresSeleccionados($proveedores);

            
            $id_hast = $this->hashEncode($invitacion);

            $response = array('success' => true, 'message' => 'Invitación restringida guardado correctamente.', 'id' => $id_hast->id_e, 'proveedores' => $proveedoresInvitados);

       } catch (\Exception $e) {
        $response = ['success' => false, 'message' => 'Error al guardar la invitación restringida.'];
           
       }

       return $response;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvitacionRestringida  $invitacionRestringida
     * @return \Illuminate\Http\Response
     */
    public function show(InvitacionRestringida $invitacionRestringida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvitacionRestringida  $invitacionRestringida
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $invitacion = InvitacionRestringida::find($id);
        $invitacion = $this->hashEncode($invitacion);
        $carpeta = "invitacion-restringida-".$invitacion->id;

        $proveedoresInvitados = json_decode($invitacion->proveedores_invitados)->proveedores;
        $proveedoresParticiparon = $invitacion->proveedores_participaron != null ? json_decode($invitacion->proveedores_participaron)->proveedores : $this->proveedoresSeleccionadosObjeto(json_decode($invitacion->proveedores_invitados)->proveedores);
        $proveedoresPropuesta = $invitacion->proveedores_propuesta != null ? json_decode($invitacion->proveedores_propuesta)->proveedores : ($invitacion->numero_proveedores_participaron > 0 ? $this->proveedoresSeleccionadosObjeto(json_decode($invitacion->proveedores_participaron)->proveedores) : []);
        $proveedoresDescalificados = $invitacion->proveedores_descalificados != null ? json_decode($invitacion->proveedores_descalificados)->proveedores : [];
        $proveedoresAprobados = $invitacion->proveedores_aprobados != null ? json_decode($invitacion->proveedores_aprobados)->proveedores : [];
        $proveedoresAdjudicados = $invitacion->proveedores_adjudicados != null ? json_decode($invitacion->proveedores_adjudicados)->proveedores : [];
        
        return view('admin.invitacion-restringida.edit')->with(['invitacion' => $invitacion, 'proveedoresInvitados' => $proveedoresInvitados, 'proveedoresParticiparon' => $proveedoresParticiparon, 'proveedoresPropuesta' => $proveedoresPropuesta, 'proveedoresDescalificados' => $proveedoresDescalificados, 'proveedoresAprobados' => $proveedoresAprobados, 'proveedoresAdjudicados' => $proveedoresAdjudicados, 'carpeta' => $carpeta]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvitacionRestringida  $invitacionRestringida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->hashDecode($request->input('id_invitacion'));
        $invitacion = InvitacionRestringida::find($id);
        $carpeta = 'invitacion-restringida-'.$id;     
        if(!Storage::disk('public')->has($carpeta)){
            Storage::disk('public')->makeDirectory($carpeta,0755,true);
        }
        switch ($request->input('update')) {
            case 1:
                try {
                    $proveedores = $this->proveedoresJson($request);
                    $invitacion->articulo = $request->input('articulo');
                    $invitacion->fraccion = $request->input('fraccion');
                    $invitacion->fecha_sesion = $request->input('fecha_sesion') != null ? Carbon::createFromFormat('d/m/Y',$request->input('fecha_sesion')) : null;
                    $invitacion->numero_sesion = $request->input('numero_sesion');
                    $invitacion->numero_cotizacion = $request->input('numero_cotizacion');
                    $invitacion->numero_proveedores_invitados = $request->input('numero_proveedores_invitados');
                    $invitacion->proveedores_invitados = json_encode($proveedores);                  

                    if($request->file('aprobacion_original')){
                        if(Storage::disk('public')->exists($carpeta."/".$invitacion->archivo_aprobacion_original)){
                            Storage::disk('public')->delete($carpeta."/".$invitacion->archivo_aprobacion_original);
                        }
                        $archivo_nombre = $request->file('aprobacion_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_original')));
                        $invitacion->archivo_aprobacion_original = $archivo_nombre;
                    }

                    if($request->file('aprobacion_publica')){
                        if(Storage::disk('public')->exists($carpeta."/".$invitacion->archivo_aprobacion_publica)){
                            Storage::disk('public')->delete($carpeta."/".$invitacion->archivo_aprobacion_publica);
                        }
                        $archivo_nombre = $request->file('aprobacion_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aprobacion_publica')));
                        $invitacion->archivo_aprobacion_publica = $archivo_nombre;
                    }

                    $invitacion->update();

                    if($invitacion->proveedores_participaron){
                        $proveedoresParticiparon = $this->proveedoresComparacion(json_decode($invitacion->proveedores_invitados)->proveedores,json_decode($invitacion->proveedores_participaron)->proveedores);                   
                    }
                    else{
                        $proveedoresParticiparon = $this->proveedoresSeleccionados($proveedores);
                    }

                    $response = array('success' => true, 'message' => 'Invitación restringida guardado correctamente.', 'proveedores' => $proveedoresParticiparon);
                    
                } catch (\Exception $e) {
                     $response = ['success' => false, 'message' => 'Error al guardar invitación restringida.'.$e];
                }
            break;
            case 2:
                try {
                    $aux = $invitacion->proveedores_participaron;
                        
                    $proveedores = $this->proveedoresJson($request);
                    $invitacion->numero_proveedores_participaron = $request->input('numero_proveedores_junta');
                    $invitacion->proveedores_participaron = json_encode($proveedores);

                    if($request->file('aclaracion_original')){
                        $archivo_nombre = $request->file('aclaracion_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aclaracion_original')));
                        $invitacion->archivo_aclaracion_original = $archivo_nombre;
                    }

                    if($request->file('aclaracion_publica')){
                        $archivo_nombre = $request->file('aclaracion_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('aclaracion_publica')));
                        $invitacion->archivo_aclaracion_publica = $archivo_nombre;
                    }
                    
                    $invitacion->update();

                    if($aux == null and $invitacion->wasChanged()){
                        $this->porcentaje(20,$invitacion->expediente_id); 
                    }

                    if($invitacion->proveedores_propuesta){
                        $proveedoresPropuesta = $this->proveedoresComparacion(json_decode($invitacion->proveedores_participaron)->proveedores,json_decode($invitacion->proveedores_propuesta)->proveedores);
                    }
                    else{
                        $proveedoresPropuesta = $this->proveedoresSeleccionados($proveedores);
                    }

                    $response = array('success' => true, 'message' => 'Invitación restringida guardado correctamente.', 'proveedores' => $proveedoresPropuesta);
                    
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al guardar invitación restringida.'];
                }
            break;
            case 3:
                try {
                    $aux = $invitacion->proveedores_propuesta;
                    
                    $proveedores = $this->proveedoresJson($request);
                    $proveedores_ = $request->input('_rfc') ? $this->proveedoresJson_($request) : null;

                    $invitacion->numero_proveedores_propuesta = $request->input('numero_proveedores_propuesta');
                    $invitacion->proveedores_propuesta = json_encode($proveedores);
                    $invitacion->numero_proveedores_descalificados = $request->input('numero_proveedores_descalificados');
                    $invitacion->proveedores_descalificados = json_encode($proveedores_);

                    if($request->file('presentacion_original')){
                        $archivo_nombre = $request->file('presentacion_original')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('presentacion_original')));
                        $invitacion->archivo_presentacion_original = $archivo_nombre;
                    }

                    if($request->file('presentacion_publica')){
                        $archivo_nombre = $request->file('presentacion_publica')->getClientOriginalName();
                        Storage::disk('public')->put($carpeta."/".$archivo_nombre, File::get($request->file('presentacion_publica')));
                        $invitacion->archivo_presentacion_publico = $archivo_nombre;
                    }

                    $invitacion->update();

                    if($aux == null and $invitacion->wasChanged()){
                        $this->porcentaje(20,$invitacion->expediente_id); 
                    }
                    
                    if($proveedores_ != []){
                        $proveedoresCalificados = $this->proveedoresCalificados($proveedores_);
                    }
                    else{
                        $proveedoresCalificados = [];
                    }
                    

                    $response = array('success' => true, 'message' => 'Invitación restringida guardado correctamente.', 'proveedores' => $proveedoresCalificados);
                    
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al guardar invitación restringida'.$e];
                }
            break;
            case 4:
                try {
                    $aux = $invitacion->proveedores_adjudicados;
                    
                    $proveedores = $this->proveedoresJson($request);
                    $proveedores_ = $request->input('_rfc') ? $this->proveedoresJson_($request) : null;

                    $invitacion->numero_proveedores_aprobados = $request->input('numero_proveedores_aprobados');
                    $invitacion->proveedores_aprobados = json_encode($proveedores);
                    $invitacion->numero_proveedores_adjudicados = $request->input('numero_proveedores_adjudicados');
                    $invitacion->proveedores_adjudicados = json_encode($proveedores_);
                    $invitacion->update();

                    if($aux == null and $invitacion->wasChanged()){
                        $this->porcentaje(20,$invitacion->expediente_id); 
                    }

                    $this->habilitarProveedor($proveedores_,$invitacion->expediente_id);
                    $response = array('success' => true, 'message' => 'Invitación restringida guardado correctamente.');
                    
                } catch (\Exception $e) {
                    $response = ['success' => false, 'message' => 'Error al guardar invitación restringida.'];
                }
            break;
        }
       
       return $response;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvitacionRestringida  $invitacionRestringida
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvitacionRestringida $invitacionRestringida)
    {
        //
    }
}
