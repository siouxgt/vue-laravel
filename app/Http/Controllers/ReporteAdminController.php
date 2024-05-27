<?php

namespace App\Http\Controllers;

use App\Exports\ReporteAdminExport;
use App\Models\ContratoMarco;
use App\Models\Proveedor;
use App\Models\ReporteAdmin;
use App\Models\Urg;
use App\Traits\HashIdTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Maatwebsite\Excel\Facades\Excel;

class ReporteAdminController extends Controller
{
    use HashIdTrait;
    
    public function index(){
        $contratos = $this->hashEncode(ContratoMarco::select('id','nombre_cm','numero_cm')->get());
        $proveedores = $this->hashEncode(Proveedor::select('id','nombre')->get());
        $urgs = $this->hashEncode(Urg::select('id','nombre')->get());
        $anio = date('Y') - 2023; //anio de produccion 

       return view('admin.reportes.index')->with(['contratos' => $contratos, 'proveedores' => $proveedores, 'urgs' => $urgs,'anio' => $anio]);
    }

    public function data(){
        $reportes = $this->hashEncode(ReporteAdmin::reportesAll());
        
        return Datatables::of($reportes)->toJson();
    }

    public function save(Request $request){
        try {
            $trimestre =  $request->input('trimestre')? $request->input('trimestre') : null;
            $de = $request->input('de'); 
            $hasta = $request->input('hasta');
            $anio = $request->input('anio')? $request->input('anio') : null;
            $mismoAnio = $anio == date('Y') ? true : false;
            if( $trimestre != null){
                switch ($trimestre) {
                    case '1':
                        $de = "01/01/".$request->input('anio');
                        $hasta = "01/02/".$request->input('anio');
                        break;
                    case '2':
                        $de = "01/04/".$request->input('anio');
                        $hasta = "01/07/".$request->input('anio');
                        break;
                    case '3':
                        $de = "01/07/".$request->input('anio');
                        $hasta = "01/10/".$request->input('anio');
                        break;
                    case '4':
                        $de = "01/10/".$request->input('anio');
                        $hasta = "01/01/".$request->input('anio')+1;
                        break;
                    
                }
            }
            
            $parametros = ["contrato" => $this->hashDecode($request->input('contrato')), 'urg' => $this->hashDecode($request->input('urg')), 'proveedor' => $this->hashDecode($request->input('proveedor')), 'anio' => $request->input('anio'), 'trimestre' => $request->input('trimestre'), 'de' => $de, 'hasta' => $hasta,'mismo_anio' => $mismoAnio];
            $nombreReportes = [1 => 'ANALÍTICO DE CONTRATO MARCO COMPLETO', 2 => 'DIRECTORIO DE UNIDADES COMPRADORAS', 3 => 'REPORTE DE ADHESIÓN PROVEEDOR', 4 => 'REPORTE DE ADHESIÓN URG', 5 => 'REPORTE DE CATALOGO DE PRODUCTOS', 6 => 'REPORTE DE INCIDENCIAS DE LAS URGS', 7 => 'REPORTE DE INCIDENCIAS POR PROVEEDOR', 8 => 'REPORTE DE ORDEN DE COMPRA COMPLETO', 9 => 'REPORTE DE ORDEN DE COMPRA COMPLETO POR PROVEEDOR', 10 => 'REPORTE DE ORDEN DE COMPRA COMPLETO POR URG', 11 => 'REPORTE DE ORDEN DE COMPRA GENERAL', 12 => 'REPORTE DE PRECIOS CLAVES CABMS POR CONTRATO MARCO', 13 => 'REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO', 14 => 'REPORTE DE SOLICITUD DE PRORROGA PROVEEDOR'];
            
            $reporte = new ReporteAdmin();
            $reporte->nombre_reporte = $nombreReportes[$request->input('reporte')];
            $reporte->reporte = $request->input('reporte');
            $reporte->parametros = json_encode($parametros);
            $reporte->urg_id = auth()->user()->urg_id;
            $reporte->save();
            $response = ['success' => true, 'message' => 'Reporte generado correctamente'];
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => 'Error al generar el reporte'.$e];
        }
        return $response;
    }

    public function showReporte($reporte_id){
        $reporte = $this->hashEncode(ReporteAdmin::find($this->hashDecode($reporte_id)));
        $parametros = json_decode($reporte->parametros);
        $parametros->fecha_reporte = Carbon::parse($reporte->created_at)->format('d/m/Y');
        
        switch ($reporte->reporte) {
            case '1':   //ANALÍTICO DE CONTRATO MARCO COMPLETO
                $data = ReporteAdmin::analiticoCM($parametros);
                $data = $this->capituloPartida($data);
                $vista = 'analitico_cm';
                break;
            case '2':   //DIRECTORIO DE UNIDADES COMPRADORAS
                $data = ReporteAdmin::directorioURG($parametros);
                $vista = "directorio_urg";
                break;
            case '3':   //REPORTE DE ADHESIÓN PROVEEDOR
                $data = ReporteAdmin::reporteAdProveedor($parametros);
                $vista = "reporte_ad_proveedor";
                break;
            case '4':   //REPORTE DE ADHESIÓN URG
                $data = ReporteAdmin::reporteAdUrg($parametros);
                $vista = "reporte_ad_urg";
                break;
            case '5':   //REPORTE DE CATALOGO DE PRODUCTOS
                $data = ReporteAdmin::reporteCp($parametros);
                $vista = "reporte_cat_pro";
                break;
            case '6':   //REPORTE DE INCIDENCIAS DE LAS URGS
                $data = ReporteAdmin::reporteInUrg($parametros);
                $vista = "reporte_inc_urg";
                break;
            case '7':   //REPORTE DE INCIDENCIAS POR PROVEEDOR
                $data = ReporteAdmin::reporteInPro($parametros);
                $vista = "reporte_inc_pro";
                break;
            case '8':   //REPORTE DE ORDEN DE COMPRA COMPLETO
                $data = ReporteAdmin::reporteOCCompleto($parametros);
                $vista = "reporte_oc_com";
                break;
            case '9':   //REPORTE DE ORDEN DE COMPRA COMPLETO POR PROVEEDOR
                $data = ReporteAdmin::reporteOCCProveedor($parametros);
                $vista = "reporte_oc_com_pro";
                break;
            case '10':  //REPORTE DE ORDEN DE COMPRA COMPLETO POR URG
                $data = ReporteAdmin::reporteOCCUrg($parametros);
                $vista = "reporte_oc_com_urg";
                break;
            case '11':  //REPORTE DE ORDEN DE COMPRA GENERAL
                $data = ReporteAdmin::reporteOCGeneral($parametros);
                $vista = "reporte_oc_gen";
                break;
            case '12':  //REPORTE DE PRECIOS CLAVES CABMS POR CONTRATO MARCO
                $data = ReporteAdmin::reporteCabmsCM($parametros);
                $vista = "reporte_cabms_cm";
                break;
            case '13':  //REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO
                $data = ReporteAdmin::reporteProCM($parametros);
                $vista = "reporte_pro_cm";
                break;
            case '14':  //REPORTE DE SOLICITUD DE PRORROGA PROVEEDOR
                $data = ReporteAdmin::reporteProrroga($parametros);
                $vista = "reporte_prorroga";
                break;   
        }
        
        return view('admin.reportes.'.$vista)->with(['data' => $data,"reporte" => $reporte]);
    }

    public function capituloPartida($data){
        if($data != []){
            foreach($data as $key => $value){
                $capitulo = "";
                $partida = "";
                $aux = json_decode($value->capitulo_partida);
                foreach($aux as $value2){
                    $capitulo .= $value2->capitulo."000, ";
                    $partida .= $value2->partida.", ";
                }
                $data[$key]->capitulo = substr($capitulo,0,-2);
                $data[$key]->partida = substr($partida,0,-2);
            }
        }
        return $data;
    }

    public function descargaReporte(Request $request){
        $reporte = $this->hashEncode(ReporteAdmin::find($this->hashDecode($request->input('reporte'))));
        $export = new ReporteAdminExport($this->hashDecode($request->input('reporte')));
        return Excel::download($export, str_replace(" ","_",$reporte->nombre_reporte).str_replace(["-",":"," "],"_",$reporte->created_at).'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
   
}
