<?php

namespace App\Http\Controllers;

use App\Exports\OrdenCompraReporteProveedorExport;
use App\Models\ReporteProveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\HashIdTrait;
use App\Traits\SessionTrait;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReporteProveedorController extends Controller {
    use HashIdTrait, SessionTrait;

    public function __construct() {
        $this->middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia', 'perfilActivo']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $contratos = $this->hashEncode(ReporteProveedor::getContratos());
        $urgs = $this->hashEncode(ReporteProveedor::getUrgs());
        $proveedores = $this->hashEncode(ReporteProveedor::getProveedores());
        return view('reportes.proveedores.index')->with(['anios' => ReporteProveedor::getAnios(), 'contratos' => $contratos, 'urgs' => $urgs, 'proveedores' => $proveedores]);
    }

    protected $items;

    public function store(Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'tipo_reporte' => 'required|in:REPORTE DE ORDENES DE COMPRA GENERAL,DIRECTORIO DE UNIDADES COMPRADORAS,REPORTE DE ORDENES DE COMPRA COMPLETO,REPORTE DE ORDENES DE COMPRA COMPLETO POR URG,REPORTE DE INCIDENCIAS DE LA URG,REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO,REPORTE DE PRODUCTOS POR CONTRATO MARCO GENERAL,REPORTE DE ADHESIÓN DE URG EN CONTRATO MARCO,ANALITICOS DE CONTRATO MARCO COMPLETO,REPORTE DE CLAVES CABMS POR CONTRATO MARCO',
                'contratos' => 'required',
                'urgs' => 'required',
                'anios' => 'required',
                'trimestres' => 'required',
            ],
            [
                'tipo_reporte.required' => 'Es necesario que selecciones el tipo de reporte a generar!',
                'tipo_reporte.in' => 'Es necesario que selecciones el tipo de reporte a generar!',
            ],
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $request->input('contratos') != 0 ? 0 : $this->hashDecode($request->input('contratos'));
            $request->input('urgs') != 0 ? 0 : $this->hashDecode($request->input('urgs'));
            $buscados = $this->hashEncode(ReporteProveedor::buscarReportes($request->input('tipo_reporte'), Auth::guard('proveedor')->user()->id));

            $this->items = array("contrato_id" => $request->input('contratos'), "urg_id" => $request->input('urgs'), "anio" => $request->input('anios'), "trimestre" => $request->input('trimestres'), "fecha_inicio" => $request->input('fecha_inicio'), "fecha_fin" => $request->input('fecha_fin'),);

            $total = $idActualizar = 0;
            if (count($buscados) > 0) {
                foreach ($buscados as $key => $buscado) {
                    $buscado->parametros = json_decode($buscado->parametros);
                    if ($buscado->parametros->contrato_id == $this->items['contrato_id']) $total++;
                    if ($buscado->parametros->urg_id == $this->items['urg_id']) $total++;
                    if ($buscado->parametros->anio == $this->items['anio']) $total++;
                    if ($buscado->parametros->trimestre == $this->items['trimestre']) $total++;
                    if ($buscado->parametros->fecha_inicio == $this->items['fecha_inicio']) $total++;
                    if ($buscado->parametros->fecha_fin == $this->items['fecha_fin']) $total++;

                    if ($total != 6) {
                        $total = 0;
                    } else {
                        $idActualizar = $buscado->id;
                        break;
                    }
                }
            }

            if ($total == 6) { // Actualizacion
                return $this->update($request, $idActualizar);
            } else { //Nuevo reporte
                $reporte = new ReporteProveedor();
                $reporte->tipo =  $request->input('tipo_reporte');
                $reporte->parametros = json_encode($this->items);
                $reporte->proveedor_id = Auth::guard('proveedor')->user()->id;
                $reporte->save();

                return response()->json(['status' => 200, 'mensaje' => 'Reporte generado correctamente.']);
            }
        }
    }

    public function update(Request $request, $id) {
        $reporte = ReporteProveedor::find($id);
        $reporte->tipo =  $request->input('tipo_reporte');
        $reporte->parametros = json_encode($this->items);
        $reporte->proveedor_id = Auth::guard('proveedor')->user()->id;
        $reporte->update();

        return response()->json(['status' => 200, 'mensaje' => 'Reporte actualizado correctamente.']);
    }

    public function show($id) {
        $datosReporte = ReporteProveedor::buscarTipoReporte($this->hashDecode($id));
        $tipoReporte = ['REPORTE DE ORDENES DE COMPRA GENERAL' => 1, 'DIRECTORIO DE UNIDADES COMPRADORAS' => 2, 'REPORTE DE ORDENES DE COMPRA COMPLETO' => 3, 'REPORTE DE INCIDENCIAS DE LA URG' => 4, 'REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO' => 5, 'REPORTE DE PRODUCTOS POR CONTRATO MARCO GENERAL' => 6, 'REPORTE DE ADHESIÓN DE URG EN CONTRATO MARCO' => 7, 'ANALITICOS DE CONTRATO MARCO COMPLETO' => 8, 'REPORTE DE CLAVES CABMS POR CONTRATO MARCO' => 9, 'REPORTE DE ORDENES DE COMPRA COMPLETO POR URG' => 10];
        $this->crearSession(['reporteId' => $id, 'nombreReporte' => $datosReporte[0]->tipo, 'tipoReporte' => $tipoReporte[$datosReporte[0]->tipo], 'fechaReporte' => $datosReporte[0]->fecha_reporte]);

        return view('reportes.proveedores.show');
    }

    public function fetchReportes() {
        $reportes = $this->hashEncode(ReporteProveedor::allReportes(Auth::guard('proveedor')->user()->id));
        return Datatables::of($reportes)->toJson();
    }

    protected $fechaInicio = 0, $fechaFin = 0, $urgId = 0, $contratoId = 0, $anio = 0;
    public function fetchReportesDesgloce() {
        $datos = null;
        $this->extraerDatos();

        if (session('tipoReporte') === 1) $datos = $this->hashEncode(ReporteProveedor::getOrdenCompraGeneral(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin));
        if (session('tipoReporte') === 2) $datos = $this->hashEncode(ReporteProveedor::getDirectorioUnidadesCompradoras(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin));
        if (session('tipoReporte') === 3) $datos = ReporteProveedor::getOrdenCompraCompleto(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin);        
        if (session('tipoReporte') === 4) $datos = ReporteProveedor::getIncidenciasUrg(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin);
        if (session('tipoReporte') === 5) $datos = $this->hashEncode(ReporteProveedor::getProductosContratoCompleto(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin));
        if (session('tipoReporte') === 6) $datos = $this->hashEncode(ReporteProveedor::getProductosContratoGeneral(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin));
        if (session('tipoReporte') === 7) {
            $datos = $this->hashEncode(ReporteProveedor::getAdhesionUrgContrato(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin));
            foreach ($datos as $key => $dato) {
                $dato->fecha_registro = $this->obtenerTrimestre($dato->fecha_registro);
            }
        }
        if (session('tipoReporte') === 8) {
            $datos = $this->hashEncode(ReporteProveedor::getAnaliticosContratoCompleto(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin));
            foreach ($datos as $key => $dato) {
                $dato->capitulo_partida = json_decode($dato->capitulo_partida);
                $dato->mes = $this->obtenerTrimestre($dato->mes);
                $dato->numero_cm = strtoupper($dato->numero_cm);
                $capitulos = $partidas = $tipoContratacion = '';

                foreach ($dato->capitulo_partida as $value) {
                    $capitulos .= $value->capitulo . '000,';
                    $partidas .= $value->partida;
                    $tipoContratacion .= $this->obtenerTipoContratacion($value->capitulo . '000') . ',';
                }
                $datos[$key]->capitulo = substr($capitulos, 0, -1);
                $datos[$key]->partida = $partidas;
                $datos[$key]->tipo_contratacion = substr($tipoContratacion, 0, -1);
            }
        }
        if (session('tipoReporte') === 9) $datos = $this->hashEncode(ReporteProveedor::getClavesCambsContrato(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin));
        if (session('tipoReporte') === 10) $datos = ReporteProveedor::getOrdenCompraCompletoUrg(Auth::guard('proveedor')->user()->id, $this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin);

        return Datatables::of($datos)->toJson();
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

    protected function extraerDatos() {
        $reporte = ReporteProveedor::find($this->hashDecode(session('reporteId')));
        $reporte->parametros = json_decode($reporte->parametros);
        $this->urgId = $reporte->parametros->urg_id != 0 ? (int) $this->hashDecode($reporte->parametros->urg_id) : 0;
        $this->contratoId = $reporte->parametros->contrato_id != 0 ? (int) $this->hashDecode($reporte->parametros->contrato_id) : 0;
        $this->anio = (int) $reporte->parametros->anio;

        if ((int) $reporte->parametros->trimestre != 0) {
            switch ((int) $reporte->parametros->trimestre) {
                case 1:
                    $this->fechaInicio = $reporte->parametros->anio . '-01-01 00:00:00';
                    $this->fechaFin = $reporte->parametros->anio . '-03-31 23:59:59';
                    break;
                case 2:
                    $this->fechaInicio = $reporte->parametros->anio . '-04-01 00:00:00';
                    $this->fechaFin = $reporte->parametros->anio . '-06-30 23:59:59';
                    break;
                case 3:
                    $this->fechaInicio = $reporte->parametros->anio . '-07-01 00:00:00';
                    $this->fechaFin = $reporte->parametros->anio . '-09-30 23:59:59';
                    break;
                case 4:
                    $this->fechaInicio = $reporte->parametros->anio . '-10-01 00:00:00';
                    $this->fechaFin = $reporte->parametros->anio . '-12-31 23:59:59';
                    break;
            }
        }

        if ($reporte->parametros->fecha_inicio != 0 && $reporte->parametros->fecha_fin != 0) {
            $this->fechaInicio = $reporte->parametros->fecha_inicio;
            $this->fechaFin = $reporte->parametros->fecha_fin;
        }

        if ((int) $reporte->parametros->anio != 0 && (int) $reporte->parametros->trimestre != 0) $this->anio = 0;
    }

    public function export() {
        $this->extraerDatos();
        $export = new OrdenCompraReporteProveedorExport($this->urgId, $this->contratoId, $this->anio, $this->fechaInicio, $this->fechaFin);
        return Excel::download($export, strtolower(str_replace(' ', '_', session('nombreReporte'))) . '_' . now() . '_' . Str::random(3) . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
