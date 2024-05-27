<?php

namespace App\Exports;

use App\Models\Proveedor;
use App\Models\ReporteAdmin;
use App\Models\Urg;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteAdminExport implements FromView, WithStrictNullComparison, WithStyles
{

	protected $reporteId;

    public function __construct(string $reporteId)
    {
        $this->reporteId = $reporteId;
    }

	public function view(): View
	{
		$reporte = ReporteAdmin::find($this->reporteId);
		$parametros = json_decode($reporte->parametros);
        $parametros->fecha_reporte = Carbon::parse($reporte->created_at)->format('d/m/Y');
        $columna = [1 => "A", 2 => "B", 3 => "C", 4 => "D", 5 => "E", 6 => "F", 7 => "G", 8 => "H", 9 => "I", 10  => "J", 11  => "K", 12  => "L", 13  => "M", 14  => "N", 15 => "O", 16 => "P", 17 => "Q", 18 => "R", 19 => "S", 20 => "T", 21 => "U", 22 => "V", 23 => "W", 24 => "X", 25 => "Y", 26 => "Z"];
        $this->ultimaCelda = "A1";
        switch ($reporte->reporte) {
            case '1':   //ANALÍTICO DE CONTRATO MARCO COMPLETO
                $data = ReporteAdmin::analiticoCM($parametros);
                $head = 5;
                $data = $this->capituloPartida($data);
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])-2].count((array)$data) + $head;
                }
                // dd($data,$this->ultimaCelda, $reporte);
                $vista = 'analitico_cm';
                break;
            case '2':   //DIRECTORIO DE UNIDADES COMPRADORAS
                $data = ReporteAdmin::directorioURG($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])-1].count((array)$data) + $head;
                }
                $vista = "directorio_urg";
                break;
            case '3':   //REPORTE DE ADHESIÓN PROVEEDOR
                $data = ReporteAdmin::reporteAdProveedor($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_ad_proveedor";
                break;
            case '4':   //REPORTE DE ADHESIÓN URG
                $data = ReporteAdmin::reporteAdUrg($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_ad_urg";
                break;
            case '5':   //REPORTE DE CATALOGO DE PRODUCTOS
                $data = ReporteAdmin::reporteCp($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_cat_pro";
                break;
            case '6':   //REPORTE DE INCIDENCIAS DE LAS URGS
                $data = ReporteAdmin::reporteInUrg($parametros);
                $head = 6;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_inc_urg";
                break;
            case '7':   //REPORTE DE INCIDENCIAS POR PROVEEDOR
                $data = ReporteAdmin::reporteInPro($parametros);
                $head = 6;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_inc_pro";
                break;
            case '8':   //REPORTE DE ORDEN DE COMPRA COMPLETO
                $data = ReporteAdmin::reporteOCCompleto($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])-1].count((array)$data) + $head;
                }
                $vista = "reporte_oc_com";
                break;
            case '9':   //REPORTE DE ORDEN DE COMPRA COMPLETO POR PROVEEDOR
                $data = ReporteAdmin::reporteOCCProveedor($parametros);
                $head = 6;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])-3].count((array)$data) + $head;
                }
                $reporte->proveedor = "TODOS";
                if($parametros->proveedor){
                	$reporte->proveedor = Proveedor::select('nombre')->where('id', $parametros->proveedor)->get();
                }
                $vista = "reporte_oc_com_pro";
                break;
            case '10':  //REPORTE DE ORDEN DE COMPRA COMPLETO POR URG
                $data = ReporteAdmin::reporteOCCUrg($parametros);
                $head = 6;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])-1].count((array)$data) + $head;
                }
                $reporte->urgp = "TODAS";
                if($parametros->urg){
                	$reporte->urgp = Urg::select('nombre')->where('id', $parametros->urg)->get();
                }
                $vista = "reporte_oc_com_urg";
                break;
            case '11':  //REPORTE DE ORDEN DE COMPRA GENERAL
                $data = ReporteAdmin::reporteOCGeneral($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])-1].count((array)$data) + $head;
                }
                $vista = "reporte_oc_gen";
                break;
            case '12':  //REPORTE DE PRECIOS CLAVES CABMS POR CONTRATO MARCO
                $data = ReporteAdmin::reporteCabmsCM($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_cabms_cm";
                break;
            case '13':  //REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO
                $data = ReporteAdmin::reporteProCM($parametros);
                $head = 5;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_pro_cm";
                break;
            case '14':  //REPORTE DE SOLICITUD DE PRORROGA PROVEEDOR
                $data = ReporteAdmin::reporteProrroga($parametros);
                $head = 6;
                if($data != []){
                	$this->ultimaCelda = $columna[count((array)$data[0])].count((array)$data) + $head;
                }
                $vista = "reporte_prorroga";
                break;   
        }		
		
		
		return view('export.reportes.admin.'.$vista,['data' => $data, 'reporte' => $reporte]);
	}

	 public function styles(Worksheet $sheet){
	 	$sheet->getStyle('A1:' . $this->ultimaCelda)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000'],],],]); //Bordes a toda la tabla
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
}