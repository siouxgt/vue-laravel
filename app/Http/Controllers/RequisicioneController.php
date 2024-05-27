<?php

namespace App\Http\Controllers;

use App\Exports\RequisicionExport;
use App\Models\BienServicio;
use App\Models\Requisicione;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class RequisicioneController extends Controller
{
    use HashIdTrait, ServicesTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contador = Requisicione::contador(auth()->user()->urg_id);
        return view('urgs.requisiciones.index')->with(['contador' => $contador[0]]);

    }
    
    public function obtenerRequisicion(){
        $requisiciones = Requisicione::registradas(auth()->user()->urg_id);
        $requisicionesServer = $this->requisicion(auth()->user()->urg->ccg);
        $aux = [];
        $contadorReq = 0;
        foreach($requisiciones as $key => $value){
            $aux[$key] = $value->requisicion;
        }
        foreach($requisicionesServer->data as $key => $value){
            if (array_search($value->no_requisicion, $aux) === false){
                $clave_partida = $this->clavePartida($value);
                $requisicion = new Requisicione();
                $requisicion->requisicion = $value->no_requisicion;
                $requisicion->area_requirente = $value->area_requirente;
                $requisicion->objeto_requisicion = $value->objeto_req;
                $requisicion->fecha_autorizacion = $value->fecha_registro;
                $requisicion->monto_autorizado = $value->valor_estimado_paaaps;
                $requisicion->clave_partida = $clave_partida;
                $requisicion->urg_id = auth()->user()->urg_id;
                $requisicion->save();
                $contadorReq++;
                $this->bienServicio($requisicion->id,$value);
            }  
        }

        return ['success' => true, 'message' => $contadorReq." requisiciones agregadas."];
    }

    public function clavePartida($value){
        $clave = explode(",",$value->clave_presupuestaria);
        $partida = explode(",", $value->partidas_paaaps);
        $valor = explode(",",$value->valorpresupuestales);
        
        foreach($clave as $key => $value){
            if(!isset($valor[$key])){
                $valor[$key] = 0;
            }
            $clave_partida['clave_partida'][$key] = ['clave_presupuestaria' => $value,'partida' => $partida[$key],'valor_estimado' => $valor[$key] ];
        }

        return json_encode($clave_partida);
    }

    public function bienServicio($requisicion_id,$value){
        if($value->cabms != null){
            $cabms = str_replace(["{","}"],"",$value->cabms);
            $bienes = str_replace(["{","}","\""],"",$value->bienes);
            $unidad = str_replace(["{","}"],"",$value->unidad);
            $cantidad = str_replace(["{","}"],"",$value->cantidad);
            $cabms = explode(",",$cabms);
            $bienes = explode(",",$bienes);    
            $unidad = explode(",",$unidad);
            $cantidad = explode(",",$cantidad);

            foreach($cabms as $key => $value){
                BienServicio::create([
                    'cabms' => $value,
                    'especificacion' => $bienes[$key],
                    'unidad_medida' => $unidad[$key],
                    'cantidad' => $cantidad[$key],
                    'requisicion_id' => $requisicion_id
                ]);
            }
        }
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
     * @param  \App\Models\Requisicione  $requisicione
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $this->hashDecode($id);
        $requisicion = $this->hashEncode(Requisicione::find($id));
        $requisicion->clave_partida = json_decode($requisicion->clave_partida);
        $requisicion->monto_disponible = $requisicion->monto_autorizado - ($requisicion->monto_por_confirmar + $requisicion->monto_adjudicado + $requisicion->monto_pagado);
        $requisicion->cotizado = Requisicione::cotizado($id)[0];

        return view('urgs.requisiciones.show')->with(['requisicion' => $requisicion]);
    }

   
    public function modalSeleccionarRequisicion($cabms)
    {
        $req = $this->hashEncode(Requisicione::obtenerRequisicionObjeto(auth()->user()->urg_id,$cabms));
        
        if (count($req) > 0) {
            return view("urgs.modals.seleccionar_requisicion")->with([
                "datos" => $req
            ]);
        }
    }

    public function data()
    {
        $requisiciones = $this->hashEncode(Requisicione::allRequisicion(auth()->user()->urg_id));

        return Datatables::of($requisiciones)->toJson();
    }

    public function export(Request $request){
        $id = $this->hashDecode($request->input('requisicion'));
        $requisicion = Requisicione::find($id);
        switch ($request->input('formato')){
            case "PDF":
                $requisicion = $this->hashEncode(Requisicione::find($id));
                $requisicion->clave_partida = json_decode($requisicion->clave_partida);
                $requisicion->monto_disponible = $requisicion->monto_autorizado - ($requisicion->monto_por_confirmar + $requisicion->monto_adjudicado + $requisicion->monto_pagado);
                $bienes = $this->hashEncode(BienServicio::where('requisicion_id',$id)->get());
                foreach($bienes as $key => $value){ 
                    $partida = substr($value->cabms,0,4);
                    $bienes[$key]->descripcion = $this->cabmsDescripcion($partida,$value->cabms);
                    $bienes[$key]->precio_maximo = $value->precio_maximo;
                    $bienes[$key]->subtotal = $value->precio_maximo * $value->cantidad;
                    $bienes[$key]->iva = ($value->precio_maximo * $value->cantidad) *.16;
                    $bienes[$key]->total = (($value->precio_maximo * $value->cantidad) *.16) + ($value->precio_maximo * $value->cantidad);
                }
                $pdf = \PDF::loadView('pdf.requisiciones',['requisicion' => $requisicion, 'bienes' => $bienes])->setPaper('a4', 'landscape');
                return $pdf->download('requisicion'.$requisicion->requisicion.'.pdf');
            break;
            case "XLS":
                $export = new RequisicionExport($id);
                return Excel::download($export, 'requisicion'.$requisicion->requisicion.'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
            break;
        }        
    }

}
