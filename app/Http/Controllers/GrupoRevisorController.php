<?php

namespace App\Http\Controllers;

use App\Models\ContratoMarco;
use App\Models\GrupoRevisor;
use App\Models\Urg;
use App\Traits\ContratoTrait;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class GrupoRevisorController extends Controller
{
    use ServicesTrait, HashIdTrait, ContratoTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = $this->hashDecode(session()->get('contrato'));
        $grupos = $this->hashEncode(GrupoRevisor::where('contrato_id',$id)->get()->sortByDesc('id'));
        $contratoId = $this->hashDecode(session()->get('contrato'));
        $fechas= $this->fechasContrato($id);

        return view('admin.grupo-revisor.index')->with(['grupos' => $grupos, 'fechas' => $fechas]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $urgs = Urg::where('estatus', 1)->get();
        $fechas = $this->fechasContrato($this->hashDecode(session()->get('contrato')));
        
        return view('admin.grupo-revisor.create')->with(['urgs' => $urgs, 'fechas' => $fechas]);
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
            $grupo = new GrupoRevisor;
            $grupo->convocatoria = $request->input('convocatoria');
            $grupo->emite = $request->input('emite');
            $grupo->objeto = $request->input('objeto');
            $grupo->motivo = $request->input('motivo');
            $grupo->numero_oficio = $request->input('numero_oficio');
            $grupo->fecha_mesa = $request->input('fecha_mesa');
            $grupo->lugar = $request->input('lugar');
            $grupo->comentarios = $request->input('comentarios');
            $grupo->numero_asistieron = $request->input('numero_urg');
            $grupo->asistieron = json_encode($this->urg($request));
            $grupo->observaciones = $request->input('observaciones');
            $grupo->contrato_id = $this->hashDecode(session()->get('contrato'));
            $grupo->user_id_creo = auth()->user()->id;

            if($request->file('archivo_invitacion')){
                $archivo_nombre = $request->file('archivo_invitacion')->getClientOriginalName();
                Storage::disk('grupo_revisor')->put($archivo_nombre, File::get($request->file('archivo_invitacion')));
                $grupo->archivo_invitacion = $archivo_nombre;
            }

            if($request->file('archivo_ficha_tecnica')){
                $archivo_nombre = $request->file('archivo_ficha_tecnica')->getClientOriginalName();
                Storage::disk('grupo_revisor')->put($archivo_nombre, File::get($request->file('archivo_ficha_tecnica')));
                $grupo->archivo_ficha_tecnica = $archivo_nombre;
            }

            if($request->file('archivo_minuta')){
                $archivo_nombre = $request->file('archivo_minuta')->getClientOriginalName();
                Storage::disk('grupo_revisor')->put($archivo_nombre, File::get($request->file('archivo_minuta')));
                $grupo->archivo_minuta = $archivo_nombre;
            }

            $grupo->save();
            $contratoId = $this->hashDecode(session('contrato'));
            $countGrupo = GrupoRevisor::where('contrato_id',$contratoId)->count();
            if($countGrupo == 1){
                $this->porcentajeContrato(17,$contratoId);
                $this->seccionTerminada('revisor',$contratoId); 
            }

            return redirect()->route('grupo_revisor.index')->with('error','success');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error','error');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GrupoRevisor  $grupoRevisor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->hashDecode($id);
        $grupo = $this->hashEncode(GrupoRevisor::find($id));

        $urgs = json_decode($grupo->asistieron)->urg;

        $contratoId = $this->hashDecode(session()->get('contrato'));
        $fechas = $this->fechasContrato($contratoId);

        return view('admin.grupo-revisor.edit')->with(['grupo' => $grupo, 'urgs' => $urgs, 'fechas' => $fechas]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GrupoRevisor  $grupoRevisor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = $this->hashDecode($id);

         try {
            $grupo = GrupoRevisor::find($id);
            $grupo->convocatoria = $request->input('convocatoria');
            $grupo->emite = $request->input('emite');
            $grupo->objeto = $request->input('objeto');
            $grupo->motivo = $request->input('motivo');
            $grupo->numero_oficio = $request->input('numero_oficio');
            $grupo->fecha_mesa = $request->input('fecha_mesa') != null ? Carbon::createFromFormat('d/m/Y',$request->input('fecha_mesa')) : null;
            $grupo->lugar = $request->input('lugar');
            $grupo->comentarios = $request->input('comentarios');
            $grupo->numero_asistieron = $request->input('numero_urg');
            $grupo->asistieron = json_encode($this->urg($request));
            $grupo->observaciones = $request->input('observaciones');

            if($request->file('archivo_invitacion')){
                if(Storage::disk('grupo_revisor')->exists($grupo->archivo_invitacion)){
                    Storage::disk('grupo_revisor')->delete($grupo->archivo_invitacion);
                }
                $archivo_nombre = $request->file('archivo_invitacion')->getClientOriginalName();
                Storage::disk('grupo_revisor')->put($archivo_nombre, File::get($request->file('archivo_invitacion')));
                $grupo->archivo_invitacion = $archivo_nombre;
            }

            if($request->file('archivo_ficha_tecnica')){
                if(Storage::disk('grupo_revisor')->exists($grupo->archivo_ficha_tecnica)){
                    Storage::disk('grupo_revisor')->delete($grupo->archivo_ficha_tecnica);
                }
                $archivo_nombre = $request->file('archivo_ficha_tecnica')->getClientOriginalName();
                Storage::disk('grupo_revisor')->put($archivo_nombre, File::get($request->file('archivo_ficha_tecnica')));
                $grupo->archivo_ficha_tecnica = $archivo_nombre;
            }

            if($request->file('archivo_minuta')){
                if(Storage::disk('grupo_revisor')->exists($grupo->archivo_minuta)){
                    Storage::disk('grupo_revisor')->delete($grupo->archivo_minuta);
                }
                $archivo_nombre = $request->file('archivo_minuta')->getClientOriginalName();
                Storage::disk('grupo_revisor')->put($archivo_nombre, File::get($request->file('archivo_minuta')));
                $grupo->archivo_minuta = $archivo_nombre;
            }

            $grupo->update();

            return redirect()->route('grupo_revisor.index')->with('error','success');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error','error');
        }
    }

    public function urg($request){

        foreach($request->input('nombre') as $key => $value){
            $urg['urg'][$key]['nombre'] = $value;
            if(isset($request->input('estatus')[$key])){
                $urg['urg'][$key]['seleccionado'] = $request->input('estatus')[$key];
            }
            else{
                $urg['urg'][$key]['seleccionado'] = 0;   
            }
        }

        return $urg;
    }

}
