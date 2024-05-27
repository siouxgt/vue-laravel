<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Traits\HashIdTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class IncidenciaUrgController extends Controller
{

    use HashIdTrait;

    public function index(){
        $contadoresUrg = Incidencia::urgCount(auth()->user()->urg_id);
        $contadoresAdmin = Incidencia::urgAdminCount(auth()->user()->id);
        
        $proveedores = $this->hashEncode(Incidencia::proveedoresUrg(auth()->user()->urg_id));
        $origenes = Incidencia::urgOrigen(auth()->user()->id);
        $motivos = Incidencia::urgMotivo(auth()->user()->id);

        return view('urgs.incidencias.index')->with(['contadoresUrg' => $contadoresUrg[0], 'contadoresAdmin' => $contadoresAdmin[0] ,'proveedores' => $proveedores, 'origenes' => $origenes, 'motivos' => $motivos]);
      
    }

    public function data(){
        $incidencia = $this->hashEncode(Incidencia::incidenciasAllUrg(auth()->user()->urg_id));
        foreach($incidencia as $key => $value){
            $incidencia[$key]->tiempo_respuesta = null;
            if($value->fecha_respuesta != null){
                $diferencia = Carbon::parse($value->created_at)->diffInDays($value->fecha_respuesta,false);
                $incidencia[$key]->tiempo_respuesta = $diferencia; 
            }
        }

        return Datatables::of($incidencia)->toJson();
    }

    public function modalConformidad(){
        return view('urgs.incidencias.modal.conformidad_incidencia');
    }

    public function saveConformidad(Request $request){
        try {
            $incidencia = Incidencia::find($this->hashDecode($request->input('incidencia')));
            $incidencia->conformidad = $request->input('conformidad') == 'Si' ? 1 : 0; 
            $incidencia->comentario = $request->input('comentario');
            $incidencia->estatus = false;
            $incidencia->fecha_cierre = date(now());
            $incidencia->update();
            $response = ['success' => true, 'message' => 'Incidencia cerrada corectamente.'];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error el cerrar la incidencia.'.$e];
        }
        return $response;
    }

    public function dataAdmin(){
        $incidencia = Incidencia::incidenciasUrgAdmin(auth()->user()->id);

        return Datatables::of($incidencia)->toJson();
    }

    public function dataUrgFiltro($filtro){
        $filtro = explode('-',$filtro);
        switch ($filtro[0]) {
            case 'urg_proveedor':
                if($filtro[1] == "todos"){
                    return $this->data();
                }
                $incidencia = $this->hashEncode(Incidencia::urgIncidenciaFiltroProveedor(auth()->user()->urg_id, $this->hashDecode($filtro[1])));
            break;

            case 'urg_estatus':
                if($filtro[1] == "todos"){
                    return $this->data();
                }
                $incidencia = $this->hashEncode(Incidencia::urgIncidenciaFiltroEstatus(auth()->user()->urg_id,$filtro[1]));
            break;
            case 'fecha':
                $de = str_replace("_", "/", $filtro[1]);
                $hasta = str_replace("_", "/", $filtro[2]);

                $incidencia = $this->hashEncode(Incidencia::urgIncidenciaFiltroFecha(auth()->user()->urg_id,$de,$hasta));
            break;
        }

        if($incidencia != '[]'){
            foreach($incidencia as $key => $value){
                $incidencia[$key]->tiempo_respuesta = null;
                if($value->fecha_respuesta != null){
                    $diferencia = Carbon::parse($value->created_at)->diffInDays($value->fecha_respuesta,false);
                    $incidencia[$key]->tiempo_respuesta = $diferencia; 
                }
            }
        }

         return Datatables::of($incidencia)->toJson();
    }

   public function dataAdminFiltro($filtro){
        $filtro = explode('-',$filtro);
        switch ($filtro[0]) {
            case 'admin_origen':
                if($filtro[1] == 'todos'){
                    return $this->dataAdmin();
                }
                $incidencia = Incidencia::urgIncidenciaAdminFiltroOrigen(auth()->user()->id,$filtro[1]);
                break;
            case 'admin_motivo':
                if($filtro[1] == 'todos'){
                    return $this->dataAdmin();
                }
                $incidencia = Incidencia::urgIncidenciaAdminFiltroMotivo(auth()->user()->id,$filtro[1]);
                break;
            case 'admin_escala':
                if($filtro[1] == 'todos'){
                    return $this->dataAdmin();
                }
                $incidencia = Incidencia::urgIncidenciaAdminFiltroEscala(auth()->user()->id,$filtro[1]);
                break;
            case 'fecha':
                $de = str_replace("_", "/", $filtro[1]);
                $hasta = str_replace("_", "/", $filtro[2]);

                $incidencia = $this->hashEncode(Incidencia::urgIncidenciaFiltroFecha(auth()->user()->urg_id,$de,$hasta));
                break;
        }
        
        return Datatables::of($incidencia)->toJson();
   }

}