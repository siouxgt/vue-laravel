<?php

namespace App\Exports;

use App\Models\ReporteProveedor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class OrdenCompraReporteProveedorExport implements FromView, WithStrictNullComparison, WithStyles {
    protected $ultimaCelda, $letraColumna, $datos;

    public function __construct($urgId, $contratoId, $anio, $fechaInicio, $fechaFin) {
        switch (session('tipoReporte')) {
            case 1: //orden_compra_general
                $this->letraColumna = 'I';
                $this->datos = ReporteProveedor::getOrdenCompraGeneral(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
            case 2: //Directorio unidades compradoras
                $this->letraColumna = 'E';
                $this->datos = ReporteProveedor::getDirectorioUnidadesCompradoras(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
            case 3: //Reporte de orden compra completo (este es general, por URG esta en el case 10)
                $this->letraColumna = 'R';
                $this->datos = ReporteProveedor::getOrdenCompraCompleto(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
            case 4: //Incidencias URG
                $this->letraColumna = 'J';
                $this->datos = ReporteProveedor::getIncidenciasUrg(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
            case 5: //Productos por contrato marco completo
                $this->letraColumna = 'S';
                $this->datos = ReporteProveedor::getProductosContratoCompleto(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
            case 6: //Productos por contrato marco general
                $this->letraColumna = 'N';
                $this->datos = ReporteProveedor::getProductosContratoGeneral(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
            case 7: //Adhesion urg contrato
                $this->letraColumna = 'J';
                $this->datos = ReporteProveedor::getAdhesionUrgContrato(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                foreach ($this->datos as $key => $dato) {
                    $dato->fecha_registro = $this->obtenerTrimestre($dato->fecha_registro);
                }
                break;
            case 8: //Analiticos contrato completo
                $this->letraColumna = 'S';
                $this->datos = ReporteProveedor::getAnaliticosContratoCompleto(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                foreach ($this->datos as $key => $dato) {
                    $dato->capitulo_partida = json_decode($dato->capitulo_partida);
                    $dato->mes = $this->obtenerTrimestre($dato->mes);
                    $dato->numero_cm = strtoupper($dato->numero_cm);
                    $capitulos = $partidas = $tipoContratacion = '';

                    foreach ($dato->capitulo_partida as $value) {
                        $capitulos .= $value->capitulo . '000,';
                        $partidas .= $value->partida;
                        $tipoContratacion .= $this->obtenerTipoContratacion($value->capitulo . '000') . ',';
                    }
                    $this->datos[$key]->capitulo = substr($capitulos, 0, -1);
                    $this->datos[$key]->partida = $partidas;
                    $this->datos[$key]->tipo_contratacion = substr($tipoContratacion, 0, -1);
                }
                break;
            case 9: //Claves cambs contrato
                $this->letraColumna = 'F';
                $this->datos = ReporteProveedor::getClavesCambsContrato(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
            case 10: //Reporte de orden compra completo por URG
                $this->letraColumna = 'T';
                $this->datos = ReporteProveedor::getOrdenCompraCompletoUrg(Auth::guard('proveedor')->user()->id, $urgId, $contratoId, $anio, $fechaInicio, $fechaFin);
                break;
        }
        $this->ultimaCelda = $this->letraColumna . ((session('tipoReporte') == 10 ? 6 : 5) + count($this->datos));
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A1:' . $this->ultimaCelda)->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000'],],],]); //Bordes a toda la tabla
        $sheet->getStyle('A1:' . $this->letraColumna . '2')->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true,],]); //Titulo del reporte 'A1:?2'
        $sheet->getStyle('A3:' . $this->ultimaCelda)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true,],]); //Head y datos
        $sheet->getStyle('B3:' . $this->letraColumna . (session('tipoReporte') == 10 ? '5' : '4'))->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true,],]); //Head y datos
    }

    public function view(): View {
        switch (session('tipoReporte')) {
            case 1: //orden_compra_general
                return view('export.reportes.proveedores.ordenes_compra_general', ['datos' => $this->datos]);
                break;
            case 2: //Directorio unidades compradoras                
                return view('export.reportes.proveedores.directorio_unidades_compradoras', ['datos' => $this->datos]);
                break;
            case 3: //Reporte de orden compra completo
                return view('export.reportes.proveedores.ordenes_compra_completo', ['datos' => $this->datos]);
                break;
            case 4: //Incidencias URG
                return view('export.reportes.proveedores.incidencias_urg', ['datos' => $this->datos]);
                break;
            case 5: //Productos por contrato marco general
                return view('export.reportes.proveedores.productos_contrato_completo', ['datos' => $this->datos]);
                break;
            case 6: //Productos por contrato marco general
                return view('export.reportes.proveedores.productos_contrato_general', ['datos' => $this->datos]);
                break;
            case 7: //Adhesion urg contrato
                return view('export.reportes.proveedores.adhesion_urg_contrato', ['datos' => $this->datos]);
                break;
            case 8: //Adhesion urg contrato
                return view('export.reportes.proveedores.analiticos_contrato_completo', ['datos' => $this->datos]);
                break;
            case 9: //Claves cambs contrato
                return view('export.reportes.proveedores.claves_cambs_contrato', ['datos' => $this->datos]);
                break;
            case 10: //Reporte de orden compra completo por URG
                return view('export.reportes.proveedores.ordenes_compra_completo_urg', ['datos' => $this->datos]);
                break;
        }
    }

    protected function obtenerTrimestre($mes) {
        if ($mes == 1 || $mes == 2 || $mes == 3) return 'PRIMER TRIMESTRE';
        if ($mes == 4 || $mes == 5 || $mes == 6) return 'SEGUNDO TRIMESTRE';
        if ($mes == 7 || $mes == 8 || $mes == 9) return 'TERCER TRIMESTRE';
        if ($mes == 10 || $mes == 11 || $mes == 12) return 'CUARTO TRIMESTRE';
    }

    protected function obtenerTipoContratacion($capitulo) {
        if ($capitulo == '1000') return 'SERVICIOS PERSONALES';
        if ($capitulo == '2000') return 'MATERIALES Y SUMINISTROS';
        if ($capitulo == '3000') return 'SERVICIOS GENERALES';
        if ($capitulo == '4000') return 'TRANSFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS';
        if ($capitulo == '5000') return 'BIENES MUEBLES, INMUEBLES E INTANGIBLES';
    }
}
