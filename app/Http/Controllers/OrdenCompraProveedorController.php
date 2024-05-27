<?php

namespace App\Http\Controllers;

use App\Models\CancelarCompra;
use App\Models\Contrato;
use App\Models\FacturasCorreccion;
use App\Models\Incidencia;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraBien;
use App\Models\OrdenCompraEnvio;
use App\Models\OrdenCompraEstatus;
use App\Models\OrdenCompraEvaluacionProducto;
use App\Models\OrdenCompraEvaluacionProveedor;
use App\Models\OrdenCompraFactura;
use App\Models\OrdenCompraFirma;
use App\Models\OrdenCompraPago;
use App\Models\OrdenCompraProrroga;
use App\Models\OrdenCompraProveedor;
use App\Models\OrdenCompraSustitucion;
use App\Models\Proveedor;
use App\Models\ProveedorComentario;
use App\Models\RechazarCompra;
use App\Models\Reporte;
use App\Models\Retraso;
use App\Traits\HashIdTrait;
use App\Traits\ServicesTrait;
use App\Traits\SessionTrait;
use App\Traits\MensajeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class OrdenCompraProveedorController extends Controller {

    use HashIdTrait, SessionTrait, ServicesTrait, MensajeTrait;

    public function __construct() {
        $this->middleware(['auth:proveedor', 'matrizLlena', 'verificarConstancia', 'perfilActivo']);
    }

    public function id() { //Id del proveedor (el proveedor se loguea y desde ahi se obtiene su ID)
        return Auth::guard('proveedor')->user()->id;
    }

    public function index() {
        $fullOrdenCompra = OrdenCompraProveedor::totalesOrdenCompra($this->id());
        $ordenCompraEstatus = OrdenCompraEstatus::todosEstatuses($this->id());
        $confirmadas = $entregadas = $sustitucion = $facturadas = $pagadas = $evaluadas = 0;
        foreach ($ordenCompraEstatus as $key => $estatus) {
            $llaveEtapa = 0;
            if ($estatus->confirmacion) $llaveEtapa++;
            if ($estatus->contrato) $llaveEtapa++;
            if ($estatus->envio) $llaveEtapa++;
            if ($estatus->entrega) $llaveEtapa++;
            if ($estatus->facturacion) $llaveEtapa++;
            if ($estatus->pago) $llaveEtapa++;
            if ($estatus->evaluacion) $llaveEtapa++;
            if ($estatus->finalizada) $llaveEtapa++;

            if ($llaveEtapa == 1) $confirmadas++;
            if ($llaveEtapa == 3) $entregadas++;
            if ($llaveEtapa == 4) $sustitucion++;
            if ($llaveEtapa == 5) $facturadas++;
            if ($llaveEtapa == 6) $pagadas++;
            if ($llaveEtapa == 7) $evaluadas++;
        }
        $totalNuevas = $fullOrdenCompra[0]->total_nuevas;
        $totalNuevas -= ($fullOrdenCompra[0]->total_canceladas + $fullOrdenCompra[0]->total_rechazadas);
        $totalNuevas = $totalNuevas < 0 ? 0 : $totalNuevas;
        return view('proveedores.orden_compra.index')->with(['totalOC' => $fullOrdenCompra[0]->total_ocp, 'totalNuevas' => $totalNuevas, 'totalCanceladas' => $fullOrdenCompra[0]->total_canceladas, 'totalRechazadas' => $fullOrdenCompra[0]->total_rechazadas, 'totalConfirmadas' => $confirmadas, 'totalEntregadas' => $entregadas, 'totalSustitucion' => $sustitucion, 'totalFacturadas' => $facturadas, 'totalPagadas' => $pagadas, 'totalEvaluadas' => $evaluadas]);
    }

    public function show($id) { //Se esta recibiendo el id de la orden compra
        $datos = $this->hashEncode(OrdenCompra::datosProductosPorOrdenCompra($this->hashDecode($id), $this->id()));
        $datos[0]->fecha_entrega = $datos[0]->fecha_entrega != null ? Carbon::parse($datos[0]->fecha_entrega)->format('d/m/Y') : null;
        $this->crearSession(['urgId' => $datos[0]->urg_id]);
        $sumaTotal = OrdenCompra::precioTotalProductosConIva($this->hashDecode($id), $this->id());
        $aux = json_decode($datos[0]->indicador_proveedor);
        $datos[0]->estatus = $aux->estatus;
        $datos[0]->etapa = $aux->etapa;
        $datos[0]->css = $aux->css;

        $this->crearSession(['ordenCompraId' => $id]);
        return view('proveedores.orden_compra.show')->with(['datos' => $datos, 'suma_total' => $sumaTotal[0]->total]);
    }

    public function seguimiento($id) { //Abre la pagina de seguimiento (index) donde se observa cada una de las secciones del seguimiento por medio de botones
        $ordenCompraEstatus = OrdenCompraEstatus::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', $this->id())->get();
        $datos = $this->hashEncode(OrdenCompra::datosProductosPorOrdenCompra($this->hashDecode(session('ordenCompraId')), $this->id()));
        $this->crearSession(['ordenCompraEstatusId' => $id, 'ordenCompraReqId' => $ordenCompraEstatus[0]->ordenCompra->orden_compra, 'proveedorId' => $ordenCompraEstatus[0]->proveedor_id, 'requisicionId' => $ordenCompraEstatus[0]->ordenCompra->requisicion_id]);
        return view('proveedores.orden_compra.seguimiento.index')->with(['ordenCompraEstatus' => $ordenCompraEstatus[0], 'datos' => $datos]);
    }

    public function acuseConfirmada() { // Funcioón que abre la ventana para ver el acuse de los productos
        $datosOrdenCompra =  OrdenCompra::datosOrdenCompraConfirmada($this->hashDecode(session()->get('ordenCompraId')));
        $datosFechaEntrega =  OrdenCompraProveedor::obtenerFechaEntrega($this->hashDecode(session()->get('ordenCompraId')), $this->id());
        $productosConfirmados =  OrdenCompraProveedor::todosProductosConfirmados($this->hashDecode(session()->get('ordenCompraId')), $this->id());
        return view('proveedores.orden_compra.seguimiento.acuse_confirmada')->with(['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados]);
    }

    public function exportOrdenConfirmada() {
        $datosOrdenCompra =  OrdenCompra::datosOrdenCompraConfirmada($this->hashDecode(session()->get('ordenCompraId')));
        $datosFechaEntrega =  OrdenCompraProveedor::obtenerFechaEntrega($this->hashDecode(session()->get('ordenCompraId')), $this->id());
        $productosConfirmados =  OrdenCompraProveedor::todosProductosConfirmados($this->hashDecode(session()->get('ordenCompraId')), $this->id());
        $pdf = \PDF::loadView('pdf.acuse_compra_confirmada', ['datosOrdenCompra' => $datosOrdenCompra, 'datosFechaEntrega' => $datosFechaEntrega, 'productosConfirmados' => $productosConfirmados])->setPaper('A4', 'landscape');
        return $pdf->download('acuse_orden_compra_confirmada' . $datosOrdenCompra[0]->orden_compra . '.pdf');
    }

    public function inicializarEnvio() {
        $consultaEnvio = OrdenCompraEnvio::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
        if (count($consultaEnvio) === 0) {
            $env = new OrdenCompraEnvio();
            $env->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
            $env->proveedor_id = session()->get('proveedorId');
            $env->urg_id = session()->get('urgId');
            $env->save();
        }
    }

    public function abrirPagina($quienSeguimiento, $seccion = '') {
        $datos = $this->hashEncode(OrdenCompra::datosProductosPorOrdenCompra($this->hashDecode(session()->get('ordenCompraId')), $this->id()));
        $consultaEstatuses = OrdenCompraEstatus::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
        $etapas = ['Confirmación', 'Contrato', 'Envío', 'Entrega', 'Facturación', 'Pago', 'Evaluación', 'Finalizada']; //buscando la etapa activa
        $llaveEtapa = 0;
        if ($consultaEstatuses[0]->confirmacion) $llaveEtapa++;
        if ($consultaEstatuses[0]->contrato) $llaveEtapa++;
        if ($consultaEstatuses[0]->envio) $llaveEtapa++;
        if ($consultaEstatuses[0]->entrega) $llaveEtapa++;
        if ($consultaEstatuses[0]->facturacion) $llaveEtapa++;
        if ($consultaEstatuses[0]->pago) $llaveEtapa++;
        if ($consultaEstatuses[0]->evaluacion) $llaveEtapa++;
        if ($consultaEstatuses[0]->finalizada) $llaveEtapa++;
        $this->crearSession(['etapaActiva' => $etapas[$llaveEtapa - 1]]);

        switch ($quienSeguimiento) {
            case 1: //Confirmacion
                $cancelacion = CancelarCompra::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get(); //Primero: Se procede a consultar la tabla cancelar_compras con el fin de verificar si la URG ha cancelado la orden de compra
                $rechazo = RechazarCompra::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get(); //Segundo: Se procede a consultar la tabla rechazar_compras con el fin de verificar si el proveedor ha rechazado la compra
                $data = [];

                if ($cancelacion->isNotEmpty()) { //Si las tablas de cancelacion tienen datos (si no estan vacias), entonces significa que la URG cancelo la compra por X razón
                    $data = ['cancelacion' => $cancelacion, 'seccion' => 0];
                } else if ($rechazo->isNotEmpty()) {
                    $data = ['rechazo' => $rechazo, 'seccion' => 1];
                } else {
                    $consultaSeguimientoConfirmacion = OrdenCompraProveedor::consultaSeguimientoConfirmacion($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
                    if ($consultaSeguimientoConfirmacion[0]->fecha_entrega === null && $consultaSeguimientoConfirmacion[0]->motivo_rechazo === null) {
                        $data = ['seccion' => 2]; //Seccion 2: significa que está en espera para aceptar o rechazar productos
                    } else if (($consultaSeguimientoConfirmacion[0]->fecha_entrega !== null) || ($consultaSeguimientoConfirmacion[0]->fecha_entrega === null && $consultaSeguimientoConfirmacion[0]->motivo_rechazo !== null)) { //Significa que ya se aceptaron o rechazaron productos
                        $contProductoAceptados = count($this->bienesAceptados());
                        $contProductoRechazados = count($this->bienesRechazados());
                        $countTodosProducto = count($this->todosBienes());
                        $ocp = OrdenCompraProveedor::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
                        $data = ['contProductoAceptados' => $contProductoAceptados, 'contProductoRechazados' => $contProductoRechazados, 'countTodosProducto' => $countTodosProducto, 'ocp' => $ocp, 'seccion' => 3];
                    }
                }

                $data['datos'] = $datos;
                $data['tituloEtapa'] = 'Confirmación de Orden de compra';
                return view('proveedores.orden_compra.seguimiento.confirmacion')->with($data);
                break;
            case 2: //Zona de contrato, en el se aceptan las firmas                
                $data = [];

                if (json_decode($consultaEstatuses[0]->contrato_estatus_proveedor)->mensaje === 'En espera' || json_decode($consultaEstatuses[0]->contrato_estatus_proveedor)->mensaje === '') {
                    return redirect()->back();
                } else {
                    $consultaContrato = Contrato::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                    $this->crearSession(['contratoId' => $consultaContrato[0]->id]);
                    $this->inicializarEnvio();
                    switch (json_decode($consultaEstatuses[0]->contrato_estatus_proveedor)->mensaje) {
                        case 'Has recibido el contrato':
                            if ($seccion === 'contrato_pdf') $data = ['contrato' => $consultaContrato,];
                            break;
                        case 'Firmado':
                        case 'Completo': //Mostrar vista show
                            $seccion = 'contrato_resumen';
                            $firmantes = $this->hashEncode(OrdenCompraFirma::where('contrato_id', $consultaContrato[0]->id)->get());
                            $array = [];
                            foreach ($firmantes as $key => $firmante) {
                                $array[$firmante->identificador] = ['id' => $firmante->id_e, 'rfc' => $firmante->rfc, 'nombre' => $firmante->nombre, 'primer_apellido' => $firmante->primer_apellido, 'segundo_apellido' => $firmante->segundo_apellido, 'puesto' => $firmante->puesto, 'telefono' => $firmante->telefono, 'extension' => $firmante->extension, 'correo' => $firmante->correo, 'fecha_firma' => $firmante->fecha_firma];
                            }
                            $data = ['contrato' => $consultaContrato[0], 'firmantes' => $array];
                            break;
                    }
                }
                $data += ['datos' => $datos, 'tituloEtapa' => 'Firma de contrato', 'quien' => $seccion];
                return view('proveedores.orden_compra.seguimiento.contrato')->with($data);
                break;
            case 3: //Envios
                if (json_decode($consultaEstatuses[0]->envio_estatus_proveedor)->mensaje === '') {
                    return redirect()->back();
                } else {
                    $cancelacion = CancelarCompra::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get(); //Primero: Se procede a consultar la tabla cancelar_compras con el fin de verificar si la URG ha cancelado la orden de compra
                    $data = [];

                    if ($cancelacion->isNotEmpty()) { //Si las tablas de cancelacion tienen datos (si no estan vacias), entonces significa que la URG cancelo la compra por X razón
                        $data = ['datos' => $datos, 'cancelacion' => $cancelacion, 'seccion' => 'cancelacion'];
                    } else {
                        $consultaContrato = Contrato::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                        $this->crearSession(['contratoId' => $consultaContrato[0]->id]);

                        switch ($seccion) {
                            case 'index': //Consultar si el producto ya ha sido enviado
                                $this->verificarAceptacionProrroga();
                                $this->actualizarPenalizacion($this->verificarDiasDiferencia($datos));
                                $consultaEnvio = OrdenCompraEnvio::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                                $consultaProrroga = OrdenCompraProrroga::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                                $precioTotalSinIva = OrdenCompra::precioTotalProductosSinIva($this->hashDecode(session()->get('ordenCompraId')), $this->id(), session()->get('urgId'));
                                $botonEnvio = $botonNotaRemision = $banderaEntrega = $desgloceProrroga = $desglocePenalizacionProrroga = $botonProrroga = false;

                                if ($consultaEnvio->isNotEmpty() && $consultaEnvio[0]->fecha_entrega_almacen !== null) { //Ya se hizo el envio pero aun no se entrega
                                    $botonEnvio = $botonNotaRemision = $botonProrroga = false;
                                    $banderaEntrega = true;
                                    if ($consultaProrroga->isNotEmpty()) {
                                        $desglocePenalizacionProrroga = $desgloceProrroga = true;
                                    }
                                } else {
                                    if ($consultaEnvio[0]->fecha_envio === null && $consultaProrroga->isEmpty()) { //Sin envio y sin prorroga
                                        $botonNotaRemision = $banderaEntrega = $desglocePenalizacionProrroga = $desgloceProrroga = false;
                                        $botonEnvio = $botonProrroga = true;
                                    } else if ($consultaEnvio[0]->fecha_envio !== null && $consultaProrroga->isNotEmpty()) { //Enviado y con prorroga
                                        $botonEnvio = $banderaEntrega = $botonProrroga = false;
                                        $botonNotaRemision = $desgloceProrroga = true;
                                        if ($consultaProrroga[0]->estatus === 1) {
                                            $desglocePenalizacionProrroga = true;
                                        }
                                    } else if ($consultaEnvio[0]->fecha_envio !== null && $consultaProrroga->isEmpty()) { //Enviado sin prorroga
                                        $botonEnvio = $banderaEntrega = $desglocePenalizacionProrroga = $desgloceProrroga = false;
                                        $botonNotaRemision = $botonProrroga = true;
                                    } else if ($consultaEnvio[0]->fecha_envio === null && $consultaProrroga->isNotEmpty()) { //Sin envio y con prorroga
                                        $botonNotaRemision = $banderaEntrega = $botonProrroga = false;
                                        $botonEnvio = $desgloceProrroga = true;
                                        if ($consultaProrroga[0]->estatus === 1) {
                                            $desglocePenalizacionProrroga = true;
                                        }
                                    }
                                }

                                $data = ['datos' => $datos, 'consultaEnvio' => $consultaEnvio, 'consultaProrroga' => $consultaProrroga, 'precioTotalSinIva' => $precioTotalSinIva, 'seccion' => $seccion, 'botonEnvio' => $botonEnvio, 'botonNotaRemision' => $botonNotaRemision, 'banderaEntrega' => $banderaEntrega, 'desgloceProrroga' => $desgloceProrroga, 'desglocePenalizacionProrroga' => $desglocePenalizacionProrroga, 'botonProrroga' => $botonProrroga];
                                break;
                            case 'pdf_firma_prorroga':
                                $consultaProrroga = OrdenCompraProrroga::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                                if ($consultaProrroga[0]->solicitud !== null && $consultaProrroga[0]->estatus === null) { //En la seccion prorroga consultar si ya existe una prorroga en proceso para evitar que se abra una nueva
                                    $data = ['datos' => $datos, 'consultaProrroga' => $consultaProrroga, 'seccion' => $seccion];
                                } else {
                                    return $this->abrirPagina(3, 'index');
                                }
                                break;
                            case 'cer_key_prorroga':
                                $data = ['datos' => $datos, 'seccion' => $seccion];
                                break;
                            case 'firmar_prorroga':
                                $data = ['datos' => $datos, 'seccion' => $seccion];
                                break;
                        }
                    }
                    // dd($data);
                    return view('proveedores.orden_compra.seguimiento.envio')->with($data);
                }
                break;
            case 4: //Sustitución
                $consultaSustitucion = OrdenCompraSustitucion::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                $fechaComparada = $diasEntregaSustitucion = $penalizacion = $penalizacionPrecio = 0;
                $botonEnvio = $botonNotaRemision = $desgloceNotaRemision = false;
                $data = [];

                if ($consultaSustitucion->isNotEmpty()) { //Significa que existe una solicitud de sustitucion
                    $this->crearSession(['ordenCompraSustitucionId' => $consultaSustitucion[0]->id]);
                    if ($consultaSustitucion[0]->fecha_envio === null) {
                        $botonEnvio = true;
                        $botonNotaRemision = $desgloceNotaRemision = false;
                    } else if ($consultaSustitucion[0]->fecha_envio !== null && $consultaSustitucion[0]->archivo_nota_remision === null) {
                        $botonNotaRemision = true;
                        $botonEnvio = $desgloceNotaRemision = false;
                    } else if ($consultaSustitucion[0]->fecha_envio !== null && $consultaSustitucion[0]->archivo_nota_remision !== null) {
                        $botonEnvio = $botonNotaRemision = false;
                        $desgloceNotaRemision = true;
                    }
                    if ($consultaSustitucion[0]->fecha_entrega !== null) { //Se pregunta si ya hay una fecha de entrega (Ya se entrego)
                        $fechaComparada = $consultaSustitucion[0]->fecha_entrega;
                    } else { //Si aun no hay fecha de entrega
                        $fechaComparada = now();
                    }

                    $diasDiferencia = \Carbon\Carbon::parse($consultaSustitucion[0]->created_at)->diffInDays($fechaComparada);
                    if ($diasDiferencia <= 5) {
                        $diasEntregaSustitucion = 5 - $diasDiferencia; //Dias faltantes para entregar la sustitucion
                    } else { //Si la diferencia es mayor que 5, entonces ya se paso de la fecha limite
                        $precioTotalSinIva = OrdenCompra::precioTotalProductosSinIvaSustitucion($this->hashDecode(session()->get('ordenCompraId')), $this->id(), session()->get('urgId'));
                        $penalizacion = $diasDiferencia - 5;
                        $penalizacionPrecio = $precioTotalSinIva[0]->total * ($penalizacion / 100);
                    }
                } else {
                    return redirect()->back();
                }
                $data = ['datos' => $datos, 'consultaSustitucion' => $consultaSustitucion, 'diasEntregaSustitucion' => $diasEntregaSustitucion, 'penalizacion' => $penalizacion, 'penalizacionPrecio' => $penalizacionPrecio, 'botonEnvio' => $botonEnvio, 'botonNotaRemision' => $botonNotaRemision, 'desgloceNotaRemision' => $desgloceNotaRemision, 'fecha_hoy' => $this->obtenerFechaHoy()];
                return view('proveedores.orden_compra.seguimiento.sustitucion')->with($data);
                break;
            case 5: //Facturacion
                $consultaFactura = OrdenCompraFactura::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                $consultaSustitucion = OrdenCompraSustitucion::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                $consultaEnvio = OrdenCompraEnvio::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                $fechaPivote = $fechaComparada = $tiempoRestante = $tiempoRetraso  =  $penalizacionEnvio =  $penalizacionSustitucion =  $consultaCorrecciones = null;
                $penalizacionPrecioSustitucion = $penalizacionPrecioEnvio = $etapaFactura = $leyendaTipoFecha = 0;
                $btnAdjuntarArchivo = $desgloceFactura = $desgloceCorrecciones = false;

                if (json_decode($consultaEstatuses[0]->facturacion_estatus_proveedor)->mensaje === 'En espera') {
                    $etapaFactura =  $leyendaTipoFecha = 0; //prefactura
                    $btnAdjuntarArchivo = true;
                    $desgloceFactura = $desgloceCorrecciones = false;

                    // Fechas
                    $fechaEncontrada = null;
                    if ($consultaSustitucion->isNotEmpty()) { //Se comprueba si existio un proceso de sustitucion en esta orden
                        $fechaEncontrada = $consultaSustitucion[0]->fecha_aceptada;
                    } else { //Si no se genero una sustitucion se pregunta por el envio original
                        $fechaEncontrada = $consultaEnvio[0]->fecha_entrega_aceptada;
                    }
                    $fechaPivote = $fechaEncontrada;

                    $this->crearSession(['tipoArchivo' => 'Archivo primera versión']);
                } else {
                    if (json_decode($consultaEstatuses[0]->facturacion_estatus_proveedor)->mensaje !== '') {
                        $consultaCorrecciones = FacturasCorreccion::where('orden_compra_facturas_id', $consultaFactura[0]->id)->latest()->first(); //Obteniendo la ultima correccion solicitada
                        $fechaPivote = $consultaFactura[0]->created_at;
                        $this->crearSession(['ordenCompraFacturasId' => $consultaFactura[0]->id]);
                        $this->eliminarSession(['tipoArchivo']);

                        switch (json_decode($consultaEstatuses[0]->facturacion_estatus_proveedor)->mensaje) {
                            case 'Prefactura enviada':
                                $etapaFactura = 0; //prefactura
                                $btnAdjuntarArchivo = $desgloceCorrecciones = false;
                                $desgloceFactura = true;
                                break;
                            case 'Prefactura rechazada':
                                $etapaFactura = 0; //prefactura
                                $btnAdjuntarArchivo = $desgloceFactura = $desgloceCorrecciones = true;
                                $this->crearSession(['tipoArchivo' => 'Prefactura corregida']);
                                break;
                            case 'Prefactura corregida':
                                $etapaFactura = 0; //prefactura
                                $btnAdjuntarArchivo = $desgloceCorrecciones = false;
                                $desgloceFactura = true;
                                $leyendaTipoFecha = 1;
                                break;
                            case 'Prefactura aceptada':
                                $etapaFactura = 1; //factura
                                $btnAdjuntarArchivo = true;
                                $desgloceFactura = $desgloceCorrecciones = false;
                                $this->crearSession(['tipoArchivo' => 'Factura timbrada']);
                                break;
                            case 'Factura timbrada':
                                $etapaFactura = 1; //factura
                                $btnAdjuntarArchivo = $desgloceCorrecciones = false;
                                $desgloceFactura = true;
                                break;
                            case 'Factura aceptada':
                                $etapaFactura = 1; //factura
                                $btnAdjuntarArchivo = $desgloceCorrecciones = false;
                                $desgloceFactura = true;
                                $leyendaTipoFecha = 2;
                                break;
                            case 'Factura en SAP GRP':
                                $etapaFactura = 3; //factura en SAP
                                $btnAdjuntarArchivo = $desgloceFactura = $desgloceCorrecciones = false;
                                break;
                        }
                    } else {
                        return redirect()->back();
                    }
                }
                // Fechas: Retraso en la entrega
                $facturaEntregada = false;
                if ($consultaFactura->isNotEmpty()) {
                    if ($consultaFactura[0]->estatus_factura) { //Se pregunta si ya hay una fecha de entrega  de la factura timbrada (Ya se entrego)
                        $fechaComparada = $consultaFactura[0]->fecha_factura_aceptada;
                        $facturaEntregada = true;
                    } else { //Si aun no hay fecha de entrega
                        $fechaComparada = Carbon::now();
                    }
                } else {
                    $fechaComparada = Carbon::now();
                }

                if (!$facturaEntregada) { // Factura no enviada = posible retraso
                    $diferencia = $fechaPivote->diffInDays($fechaComparada);
                    $this->crearSession(['fechaLimite' => $fechaPivote]);
                    if ($diferencia <= 7) { //Aún esta a tiempo
                        $tiempoRestante = 7 - $diferencia;
                    } else { //Atrasado... 
                        $tiempoRetraso = $diferencia - 7;
                    }
                }
                // Penalizaciones
                $numeroPenalizaciones = 0;
                if ($consultaEnvio[0]->penalizacion > 0) { //Se pregunta si existen penalizaciones en el envio
                    $precioTotalSinIva = OrdenCompra::precioTotalProductosSinIva($this->hashDecode(session()->get('ordenCompraId')), $this->id(), session()->get('urgId'));
                    $penalizacionEnvio = $consultaEnvio[0]->penalizacion;
                    $penalizacionPrecioEnvio = $precioTotalSinIva[0]->total * ($penalizacionEnvio / 100);
                    $numeroPenalizaciones++;
                }
                if ($consultaSustitucion->isNotEmpty()) {
                    if ($consultaSustitucion[0]->penalizacion > 0) { //Verificando penalizaciones en la sustitucion
                        $precioTotalSinIva = OrdenCompra::precioTotalProductosSinIvaSustitucion($this->hashDecode(session()->get('ordenCompraId')), $this->id(), session()->get('urgId'));
                        $penalizacionSustitucion = $consultaSustitucion[0]->penalizacion;
                        $penalizacionPrecioSustitucion = $precioTotalSinIva[0]->total * ($penalizacionSustitucion / 100);
                        $numeroPenalizaciones++;
                    }
                }

                $data = ['datos' => $datos, 'tituloEtapa' => 'Facturación', 'consultaFactura' => $consultaFactura, 'correcciones' => $consultaCorrecciones, 'etapaFactura' => $etapaFactura, 'btnAdjuntarArchivo' => $btnAdjuntarArchivo, 'desgloceCorrecciones' => $desgloceCorrecciones, 'desgloceFactura' => $desgloceFactura, 'leyendaTipoFecha' => $leyendaTipoFecha, 'tiempoRestante' => $tiempoRestante, 'tiempoRetraso' => $tiempoRetraso, 'facturaEntregada' => $facturaEntregada, 'penalizacionEnvio' => $penalizacionEnvio, 'penalizacionPrecioEnvio' => $penalizacionPrecioEnvio, 'penalizacionSustitucion' => $penalizacionSustitucion, 'penalizacionPrecioSustitucion' => $penalizacionPrecioSustitucion, 'numeroPenalizaciones' => $numeroPenalizaciones];
                return view('proveedores.orden_compra.seguimiento.facturacion')->with($data);
                break;
            case 6: //Pagos
                if (json_decode($consultaEstatuses[0]->pago_estatus_proveedor)->mensaje === '') {
                    return redirect()->back();
                } else {
                    $consultaIncidencias = Incidencia::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->where('etapa', 'pago')->where('reporta', 3)->latest()->get();
                    $consultaReportes = Reporte::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->where('etapa', 'pago')->where('reporta', 3)->latest()->get();
                    $consultaMotivosRetraso = Retraso::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->latest()->first();
                    $consultaFactura = OrdenCompraFactura::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                    $consultaPagos = null;
                    $btnReportes = $btnIncidencias = $desglocePago = $desgloceReportes = $desgloceIncidencias = $btnPago = false;
                    $this->crearSession(['diasTranscurridos' => Carbon::parse($consultaFactura[0]->fecha_sap)->diffInDays(Carbon::now())]);

                    if (json_decode($consultaEstatuses[0]->pago_estatus_proveedor)->mensaje === 'En espera') { //La urg aún no sube CLC
                        $btnReportes = $btnIncidencias = $desglocePago = $desgloceReportes = $desgloceIncidencias = $btnPago = false;
                        if (session()->get('diasTranscurridos') > 20) { //Si aún se está en espera, se procede a checar si aún no se han excedido de los 20 días                        
                            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Actualizando los estatuses
                            $ordenCompraEstatus->pago_estatus_proveedor = json_encode(['mensaje' => "Retraso en el pago", 'css' => 'text-rojo-estatus']);
                            $ordenCompraEstatus->pago_boton_proveedor = json_encode(['mensaje' => "Validar pago", 'css' => 'boton-verde']);
                            $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Detectamos un retraso.", 'css' => 'alert-warning']);
                            $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Pago', 'estatus' => "Retraso", 'css' => 'dorado']);
                            $ordenCompraEstatus->pago_estatus_urg = json_encode(['mensaje' => "Retraso en el pago", 'css' => 'text-rojo-estatus']);
                            $ordenCompraEstatus->pago_boton_urg = json_encode(['mensaje' => "Adjuntar CLC", 'css' => 'boton-verde']);
                            $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Detectamos un retraso.", 'css' => 'alert-warning']);
                            $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Pago', 'estatus' => "Retraso", 'css' => 'dorado']);
                            $ordenCompraEstatus->update();
                            return $this->abrirPagina(6, ''); //Volvemos a regresarnos para volver a comprobar en que seccion deberia de estar
                        }
                    } else {
                        switch (json_decode($consultaEstatuses[0]->pago_estatus_proveedor)->mensaje) {
                            case 'Retraso en el pago':
                                $btnReportes = true;
                                $btnIncidencias = $desglocePago = $desgloceReportes = $desgloceIncidencias = false;
                                break;
                            case 'Se generó reporte': //Se calcula la cantidad de reportes hechos por el proveedor                                                        
                                if (count($consultaReportes) < 3) { //Si existen menos de 3 reportes aun se pueden generar más reportes (el limite es de 3)                                    
                                    if ($consultaReportes[0]->created_at->diffInDays(Carbon::now()) >= 3) $btnReportes = true; //Si el tiempo transcurrido es mayor o igual a 3 entonces desbloquear boton para generar reporte
                                } else { //Si ya hay 3 reportes generados ya no se podran generar más. Por lo tanto el boton de reportes estara bloqueado
                                    $btnReportes = false;
                                    $btnIncidencias = true; //Si ya hay 3 reportes generados se pone a disposición el boton de incidencias
                                }
                                $desgloceReportes = true;
                                $desglocePago = $desgloceIncidencias = false;
                                break;
                            case 'Se abrió una incidencia': //Se obtienen los datos del ultimo incidencia generado, sobre todo la fecha en que se emitio                            
                                if ($consultaIncidencias->isNotEmpty()) {
                                    if ($consultaIncidencias[0]->created_at->diffInDays(Carbon::now()) >= 3) $btnIncidencias = true; //Si el tiempo transcurrido es mayor o igual a 3 entonces desbloquear boton para generar más incidencias
                                }
                                $btnReportes = $desglocePago = false;
                                $desgloceReportes = $desgloceIncidencias = true;
                                break;
                            case 'En proceso': //CLC subida, proveedor puede revisar para aceptar
                                $consultaPagos = OrdenCompraPago::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->first();
                                $btnReportes = $btnIncidencias = $desgloceReportes = $desgloceIncidencias = false;
                                $desglocePago = $btnPago = true;
                                break;
                            case 'Acreditado':
                                $consultaPagos = OrdenCompraPago::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->first();
                                $btnReportes = $btnIncidencias = $desgloceReportes = $desgloceIncidencias = $btnPago = false;
                                $desglocePago = true;
                                break;
                        }
                    }
                    $data = ['datos' => $datos, 'tituloEtapa' => 'Comprobante de pago', 'btnReportes' => $btnReportes, 'btnIncidencias' => $btnIncidencias, 'btnPago' => $btnPago, 'desglocePago' => $desglocePago, 'desgloceReportes' => $desgloceReportes, 'desgloceIncidencias' => $desgloceIncidencias, 'consultaFactura' => $consultaFactura, 'consultaMotivosRetraso' => $consultaMotivosRetraso, 'consultaReportes' => $consultaReportes, 'consultaIncidencias' => $consultaIncidencias, 'consultaPagos' => $consultaPagos,];
                    return view('proveedores.orden_compra.seguimiento.pago')->with($data);
                }
                break;
            case 7: // Evaluación final
                $consultaComentarios = $evaluacionProveedor = $evaluacionProducto = $productos = null;
                $data = [];

                if ($consultaEstatuses[0]->finalizada == 2) {
                    $consultaComentarios = ProveedorComentario::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                    $data = ['consultaComentarios' => $consultaComentarios[0]];
                }
                if ($consultaEstatuses[0]->finalizada != 0) { //Finalizada 1 y 2
                    $evaluacionProveedor = OrdenCompraEvaluacionProveedor::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                    $evaluacionProducto = OrdenCompraEvaluacionProducto::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('urg_id', session()->get('urgId'))->get();
                    $productos = $this->hashEncode(OrdenCompraBien::evaluacion($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId')));
                }
                $data += ['datos' => $datos, 'tituloEtapa' => 'Evaluación', 'finalizada' => $consultaEstatuses[0]->finalizada, 'evaluacionProveedor' => $evaluacionProveedor, 'evaluacionProducto' => $evaluacionProducto, 'productos' => $productos];
                return view('proveedores.orden_compra.seguimiento.encuesta')->with($data);
                break;
        }
    }

    // Modals
    public function abrirModal($quien) {
        switch ($quien) {
            case 0: // Comentarios sobre la URG
                return view('proveedores.orden_compra.modals.comentario_sobre_urg')->with(['comentarios' => ProveedorComentario::todosComentarios(session()->get('urgId'))]);
                break;
            case 1: // Mensaje para el comprador
                return view('proveedores.orden_compra.modals.mensaje_para_comprador');
                break;
            case 2: // Ver datos legales del proveedor
                return view('proveedores.orden_compra.modals.datos_legales_proveedor')->with(['proveedor' => Proveedor::find($this->id())]);
                break;
            case 3: // Ver modal para rechazar (0)/confirmar_rechazar (1) la orden de compra
            case 4:
                if (session('etapaActiva') !== 'Confirmación') return false;
                return view('proveedores.orden_compra.modals.rechazar_orden')->with(['quien' => ($quien == 3) ? 0 : 1]);
                break;
            case 5: // Ver formulario para seleccionar los productos que si podra entregar el proveedor
                if (session('etapaActiva') !== 'Confirmación') return false;
            case 6: // Ver el formulario para observar el resumen de los productos que podra entregar el proveedor
                $ocp = OrdenCompraProveedor::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
                $contProductoAceptados = count($this->bienesAceptados());
                $countTodosProducto = count($this->todosBienes());
                $bienes = $this->hashEncode($this->todosBienes());
                foreach ($bienes as $key => $objeto) {
                    $bienes[$key]->id_pfp = $this->hash()->encode($objeto->proveedor_ficha_producto_id);
                }
                return view('proveedores.orden_compra.modals.seleccionar_productos_entrega')->with(['quien' => $quien, 'productos' => $bienes, 'ocp' => $ocp, 'countTodosProducto' => $countTodosProducto, 'contProductoAceptados' => $contProductoAceptados]);
                break;
            case 7: // Modal correspondiente a la zona de confirmar envio
                if (session('etapaActiva') !== 'Envío') return false;
                return view('proveedores.orden_compra.modals.confirmacion_envio')->with(['fecha_hoy' => $this->obtenerFechaHoy()]);
                break;
            case 8: // Modal correspondiente a la zona de confirmar entrega                
                if (session('etapaActiva') !== 'Envío') return false;
                return view('proveedores.orden_compra.modals.confirmacion_entrega')->with(['fecha_hoy' => $this->obtenerFechaHoy()]);
                break;
            case 9: // Solicitud prorroga
                if (session('etapaActiva') !== 'Envío') return false;
                if (session('estadoProrroga') === 1) { //Se comprueba que la prorroga se este generando por primera vez                    
                    return view('proveedores.orden_compra.modals.solicitud_prorroga')->with(['fecha_hoy' => $this->obtenerFechaHoy()]);
                }
                break;
            case 10: // Modal correspondiente a la zona de confirmar entrega en sustitución
                if (session('etapaActiva') !== 'Entrega') return false;
                return view('proveedores.orden_compra.modals.confirmacion_entrega_sustitucion')->with(['fecha_hoy' => $this->obtenerFechaHoy()]);
                break;
            case 11: // Modal correspondiente a seccion facturacion: ver modal datos facturacion
                if (session('etapaActiva') !== 'Facturación') return false;
                $datosFacturacion = Contrato::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
                return view('proveedores.orden_compra.modals.facturacion_datos')->with(['datosFacturacion' => $datosFacturacion]);
                break;
            case 12:
                if (session('etapaActiva') !== 'Facturación') return false;
                return view('proveedores.orden_compra.modals.facturacion_adjuntar_prefactura')->with(['fecha_hoy' => $this->obtenerFechaHoy()]);
                break;
            case 13:
                if (session('etapaActiva') !== 'Pago') return false;
                return view('proveedores.orden_compra.modals.pago_reporte');
                break;
            case 14:
                if (session('etapaActiva') !== 'Pago') return false;
                return view('proveedores.orden_compra.modals.pago_incidencia');
                break;
            case 15:
                return view('proveedores.orden_compra.modals.encuesta_comentarios');
                break;
        }
    }

    public function rechazarOrdenCompra(Request $request) { //El rechazo se realiza desde la zona de confirmación, El rechazo es enviado por un modal                
        $validator = Validator::make(
            $request->all(),
            [
                'motivo_rechazo_orden' => 'required',
                'txt_a_descripcion_rechazo_orden' => 'required|max:1000',
            ],
            [
                'motivo_rechazo_orden.required' => 'Es necesario que declares el motivo de tu rechazo.',
                'txt_a_descripcion_rechazo_orden.required' => 'Describe el motivo de tu rechazo, por favor.',
            ],

        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $this->procesarRechazar($request->input('motivo_rechazo_orden'), $request->input('txt_a_descripcion_rechazo_orden'));
            return response()->json(['status' => 200, 'retornar' => session()->get('ordenCompraEstatusId'),]);
        }
    }

    public function procesarRechazar($motivo, $descripcion, $idOrden = null) {
        $rechazarCompra  = new RechazarCompra();
        $rechazarCompra->rechazo = str_replace('-', '', $idOrden == null ? session()->get('ordenCompraReqId') : $idOrden) . "Rz" . date('dmY');
        $rechazarCompra->motivo = $motivo;
        $rechazarCompra->descripcion = $descripcion;
        $rechazarCompra->proveedor_id = $this->id();
        $rechazarCompra->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
        $rechazarCompra->save();

        $productos = OrdenCompraBien::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', $this->id())->get();
        foreach ($productos as $p) { //Rechazando productos
            $producto = OrdenCompraBien::find($p->id);
            $producto->estatus = 2; //Fueron rechazados
            $producto->update();
        }

        $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId')));
        $ordenCompraEstatus->confirmacion = 2;
        $ordenCompraEstatus->finalizada = 2;
        $ordenCompraEstatus->confirmacion_estatus_urg = json_encode(['mensaje' => "Orden rechazada", 'css' => 'text-rojo-estatus']);
        $ordenCompraEstatus->confirmacion_estatus_proveedor = json_encode(['mensaje' => "Orden rechazada", 'css' => 'text-rojo-estatus']);
        $ordenCompraEstatus->confirmacion_boton_urg = json_encode(['mensaje' => "Orden rechazada", 'css' => 'boton-dorado']);
        $ordenCompraEstatus->confirmacion_boton_proveedor = json_encode(['mensaje' => "Orden rechazada", 'css' => 'boton-dorado']);
        $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Confirmación', 'estatus' => "Rechazada", 'css' => 'rojo']);
        $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Confirmación', 'estatus' => "Rechazada", 'css' => 'rojo']);
        $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "La compra fue rechazada", 'css' => 'alert-warning']);
        $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "La compra fue rechazada", 'css' => 'alert-warning']);
        $ordenCompraEstatus->update();
    }

    public function guardarConfirmacion(Request $request) { //Función que guarda la confirmacion del proveedor hacia los productos solicitados ya sea completa o parcial.
        $productos = OrdenCompraBien::cancelarProductos($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
        $cantidadProductoSeleccionado = count($request->input('chk_producto'));
        $cantidadProductoExistente = count($productos);

        if ($cantidadProductoSeleccionado !== null || $cantidadProductoSeleccionado !== 0) {
            foreach ($request->input('chk_producto') as $value) { //Confirmando los productos que aceptó entregar el proveedor
                $producto = OrdenCompraBien::find($this->hashDecode($value));
                $producto->estatus = 1;
                $producto->update();
            }

            $productos = OrdenCompraBien::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
            foreach ($productos as $value) {
                if ($value->estatus == null) { //Rechazando productos que no haya aceptado entregar el proveedor
                    $producto = OrdenCompraBien::find($value->id);
                    $producto->estatus = 2; //Fueron rechazados
                    $producto->update();
                }
            }

            $this->storeContrato($request->input('fecha_entrega'));  //creacion de contrato

            if ($cantidadProductoExistente === $cantidadProductoSeleccionado && $request->input('motivo_rechazo_producto') == 0) { //Se seleccionaron todos los productos
                $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Productos aceptados completamente (todos)
                $ordenCompraEstatus->confirmacion = 2;
                $ordenCompraEstatus->confirmacion_estatus_urg = json_encode(['mensaje' => "Se aceptó Orden completa", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->confirmacion_estatus_proveedor = json_encode(['mensaje' => "Se aceptó Orden completa", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->confirmacion_boton_urg = json_encode(['mensaje' => "Orden de compra", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->confirmacion_boton_proveedor = json_encode(['mensaje' => "Orden de compra", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Confirmación', 'estatus' => "Confirmada", 'css' => 'verde']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Confirmación', 'estatus' => "Confirmada", 'css' => 'verde']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Crea el contrato antes del " . date('d/m/Y', strtotime(' +2 day')) . ".", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Confirmación exitosa.", 'css' => 'alert-secondary']);

                $ordenCompraEstatus->contrato = 1;
                $ordenCompraEstatus->contrato_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->contrato_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->contrato_boton_urg = json_encode(['mensaje' => "Alta de contrato", 'css' => 'boton-verde']);
                $ordenCompraEstatus->contrato_boton_proveedor = json_encode(['mensaje' => "Firmar contrato", 'css' => 'boton-gris']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Contrato', 'estatus' => "En espera", 'css' => 'gris']);
                $ordenCompraEstatus->update();

                $ocp = OrdenCompraProveedor::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
                $ocp = OrdenCompraProveedor::find($ocp[0]->id);
                $ocp->fecha_entrega = $request->input('fecha_entrega');
                $ocp->update();

                return redirect()->route("orden_compra_proveedores.seguimiento", (session()->get('ordenCompraEstatusId')));
            } else if ($cantidadProductoExistente !== $cantidadProductoSeleccionado && $request->input('motivo_rechazo_producto') != 0) {
                $ocp = OrdenCompraProveedor::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
                $ocp = OrdenCompraProveedor::find($ocp[0]->id);
                $ocp->fecha_entrega = $request->input('fecha_entrega');
                $ocp->motivo_rechazo = $request->input('motivo_rechazo_producto');
                $ocp->descripcion_rechazo = $request->input('txt_a_descripcion_rechazo_producto');
                $ocp->update();

                $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId'))); //Estatuses de: No se aceptaron todos los productos
                $ordenCompraEstatus->confirmacion = 2;
                $ordenCompraEstatus->confirmacion_estatus_urg = json_encode(['mensaje' => "No se aceptaron todos los productos", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->confirmacion_estatus_proveedor = json_encode(['mensaje' => "No se aceptaron todos los productos", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->confirmacion_boton_urg = json_encode(['mensaje' => "Orden de compra", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->confirmacion_boton_proveedor = json_encode(['mensaje' => "Orden de compra", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Confirmación', 'estatus' => "Confirmada", 'css' => 'verde']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Confirmación', 'estatus' => "Confirmada", 'css' => 'verde']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "Crea el contrato antes del " . date('d/m/Y', strtotime(' +2 day')) . ".", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "Confirmación exitosa.", 'css' => 'alert-secondary']);

                $ordenCompraEstatus->contrato = 1;
                $ordenCompraEstatus->contrato_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->contrato_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->contrato_boton_urg = json_encode(['mensaje' => "Alta de contrato", 'css' => 'boton-verde']);
                $ordenCompraEstatus->contrato_boton_proveedor = json_encode(['mensaje' => "Firmar contrato", 'css' => 'boton-gris']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Contrato', 'estatus' => "En espera", 'css' => 'gris']);
                $ordenCompraEstatus->update();

                return redirect()->route("orden_compra_proveedores.seguimiento", (session()->get('ordenCompraEstatusId')));
            } else {
            }
        }
    }

    public function efirmaSave(Request $request) { //Firma del contrato
        $validator = Validator::make(
            $request->all(),
            [
                'archivo_cer' => 'required',
                'archivo_key' => 'required',
                'contrasena' => 'required',
                'archivo_banca' => 'required|mimes:pdf|max:5120',
            ],
            [
                'archivo_banca.required' => 'El archivo de cuenta bancaria es necesaria.',
                'archivo_banca.mimes' => 'El archivo de cuenta bancaria debe ser un archivo de tipo: pdf.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $firma = OrdenCompraFirma::select('id', 'rfc')->where('rfc', Auth::guard('proveedor')->user()->rfc)->where('contrato_id', session()->get('contratoId'))->get();
            $cer = base64_encode($request->file('archivo_cer')->get());
            $key = base64_encode($request->file('archivo_key')->get());
            $pass = base64_encode($request->input('contrasena'));

            $efirma = $this->efirma($cer, $key, $pass);

            if ($efirma->error->code != 0) return response()->json(['status' => 400, 'error' => $efirma->error->msg,]);

            // if ($efirma->data->RFC == Auth::guard('proveedor')->user()->rfc) {
            $firmante = OrdenCompraFirma::find($firma[0]->id);
            $firmante->folio_consulta = $efirma->data->folioConsulta;
            $firmante->sello = $efirma->data->sello;
            $firmante->fecha_firma = $efirma->data->fechaFirma;
            $firmante->update();

            $consultaFirma = OrdenCompraFirma::totalFirmados(session()->get('contratoId'));
            $ordenCompraEstatus = OrdenCompraEstatus::find($this->hashDecode(session()->get('ordenCompraEstatusId')));
            if ($consultaFirma[0]->total_firmantes == $consultaFirma[0]->total_firmados) { //Ya firmaron todos
                $ordenCompraEstatus->contrato = 2;
                $ordenCompraEstatus->contrato_estatus_proveedor = json_encode(['mensaje' => "Completo", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->contrato_boton_proveedor = json_encode(['mensaje' => "Contrato", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Contrato', 'estatus' => "Firmado", 'css' => 'verde']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "El contrato cuenta con todas las firmas.", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->contrato_estatus_urg = json_encode(['mensaje' => "Completo", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->contrato_boton_urg = json_encode(['mensaje' => "Contrato", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->indicador_urg = json_encode(['etapa' => 'Contrato', 'estatus' => "Firmado", 'css' => 'verde']);
                $ordenCompraEstatus->alerta_urg = json_encode(['mensaje' => "El contrato cuenta con todas las firmas.", 'css' => 'alert-secondary']);
                $ordenCompraEstatus->envio_estatus_proveedor = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']); //Envio
                $ordenCompraEstatus->envio_boton_proveedor = json_encode(['mensaje' => "Confirmar envío", 'css' => 'boton-verde']);
                $ordenCompraEstatus->envio = 1;
                $ordenCompraEstatus->envio_estatus_urg = json_encode(['mensaje' => "En espera", 'css' => 'text-gris-estatus']);
                $ordenCompraEstatus->envio_boton_urg = json_encode(['mensaje' => "Seguimiento", 'css' => 'boton-gris']);
            } else {
                $ordenCompraEstatus->contrato_estatus_proveedor = json_encode(['mensaje' => "Firmado", 'css' => 'text-verde-estatus']);
                $ordenCompraEstatus->contrato_boton_proveedor = json_encode(['mensaje' => "Contrato", 'css' => 'boton-dorado']);
                $ordenCompraEstatus->indicador_proveedor = json_encode(['etapa' => 'Contrato', 'estatus' => "Firmado", 'css' => 'verde']);
                $ordenCompraEstatus->alerta_proveedor = json_encode(['mensaje' => "", 'css' => '']);
            }
            $ordenCompraEstatus->update();
            $this->updateContrato($request->file('archivo_banca'));

            // } else {
            //     return response()->json(['status' => 400, 'error' => 'El RFC no coincide con el usuario.',]);
            // }

            return response()->json(['status' => 200, 'message' => 'Firmado correctamente.', 'retorno' => session()->get('ordenCompraEstatusId')]);
        }
    }

    public function updateContrato($archivoBanca) {
        $contrato = Contrato::find(session()->get('contratoId'));
        $productos = OrdenCompraBien::contratoPedido($contrato->orden_compra_id, $contrato->proveedor_id);

        $subtotal = 0;
        foreach ($productos as $producto) {
            $subtotal += $producto->subtotal;
        }

        $total = ($subtotal * .16) + $subtotal;
        $entero = intval(floor($total));
        $decimal = intval(($total - floor($total)) * 100);
        $format = new \NumberFormatter('es-Es', \NumberFormatter::SPELLOUT);
        $totalLetra = $format->format($entero);

        $firmantes = $this->firmantes($contrato->id);

        if ($archivoBanca != null) { //Subiendo archivo bancario
            $archivo_nombre = $archivoBanca->getClientOriginalName();
            Storage::disk('contrato_archivo_bancario')->put($archivo_nombre, File::get($archivoBanca));
            $contrato->archivo_bancario = $archivo_nombre;
        }
        $contrato->update();

        $pdf = \PDF::loadView('pdf.contrato_pedido', ['contrato' => $contrato, 'productos' => $productos, 'totalLetra' => $totalLetra, 'decimal' => $decimal, 'firmantes' => $firmantes])->download()->getOriginalContent();
        Storage::disk('contrato_pedido')->put('contrato_pedido_' . $contrato->contrato_pedido . '.pdf', $pdf);
    }

    public function firmantes($contrato_id) {
        $firmantesAll = OrdenCompraFirma::firmantes($contrato_id);
        $tipoFirmante = ['titular', 'adquisiciones', 'proveedor', 'financiera', 'requiriente'];
        $firmantes = [];
        foreach ($firmantesAll as $firmante) {
            $firmantes[$tipoFirmante[$firmante->identificador - 1]] =  ['nombre' => $firmante->nombre . " " . $firmante->primer_apellido . " " . $firmante->segundo_apellido, 'cargo' => $firmante->puesto, 'folio' => $firmante->folio_consulta, 'sello' => $firmante->sello];
        }

        return $firmantes;
    }

    public function guardarMensaje(Request $request) {

        $validator = Validator::make(
            $request->all(),
            [
                'asunto' => 'required|max:100',
                'mensaje' => 'required|max:1000',
            ],
            [
                'asunto.required' => 'Define el motivo de tu consulta',
                'mensaje.required' => 'Describe la situación'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->getMessageBag()]);
        } else {
            $data = [
                'remitente' => Auth::guard('proveedor')->user()->id,
                'receptor' => session()->get('urgId'),
                'tipo_remitente' => 2,
                'tipo_receptor' => 1,
                'origen' => 'ORDEN COMPRA PROVEEDOR'
            ];
            return $this->storeManual($request, $data);
        }
    }

    public function bienesAceptados() {
        return OrdenCompraBien::aceptados($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
    }

    public function bienesRechazados() {
        return OrdenCompraBien::rechazadas($this->hashDecode(session()->get('ordenCompraId')), session()->get('proveedorId'));
    }

    public function todosBienes() {
        return OrdenCompraBien::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->get();
    }

    public function verificarAceptacionProrroga() { //Funcion que permite verificar si la fecha para aceptar la prorroga aun no ha rebasado las 24 horas, si ya se paso de 24 horas se procede a actualizar el estatus de la prorroga como rechazado
        $consultaProrroga = OrdenCompraProrroga::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();
        $this->eliminarSession(['estadoProrroga']);
        $this->crearSession(['estadoProrroga' => 0]); //0 = No se permite generar una nueva prorroga
        if ($consultaProrroga->isNotEmpty()) { //Primero se comprueba si ya existe una prorroga levantada
            $intervalo = \Carbon\Carbon::parse($consultaProrroga[0]->fecha_solicitud)->diffInHours(\Carbon\Carbon::now());
            if (($consultaProrroga[0]->estatus === 0 || $consultaProrroga[0]->estatus === null)  && $intervalo >= 24) { //Despues se checa si ya se acepto o rechazo la prorroga (Si estan en 0 significa que no han aceptado), tambien se comprueba si ya han pasado las 24 horas
                $prorroga = OrdenCompraProrroga::find($consultaProrroga[0]->id);
                $prorroga->estatus = 2; //Se procede a rechazar la prorroga si ya pasaron las 24 horas
                $prorroga->update();
            }
        } else {
            $this->eliminarSession(['estadoProrroga']);
            $this->crearSession(['estadoProrroga' => 1]); //1 = no solicitado (EL proveedor aun no ha solicitado nada)
        }
    }

    public function verificarDiasDiferencia($datos) {
        $consultaProrroga = OrdenCompraProrroga::where('orden_compra_id', $this->hashDecode(session()->get('ordenCompraId')))->where('proveedor_id', session()->get('proveedorId'))->where('urg_id', session()->get('urgId'))->get();

        $diasDiferencia = 0;
        if ($consultaProrroga->isNotEmpty()) { //Existe prorroga levantada
            if ($consultaProrroga[0]->estatus === 1) {
                if ((\Carbon\Carbon::parse($consultaProrroga[0]->fecha_entrega_compromiso)->lt(now()))) $diasDiferencia = \Carbon\Carbon::parse($consultaProrroga[0]->fecha_entrega_compromiso)->diffInDays(now());
            } else {
                if (\Carbon\Carbon::parse($datos[0]->fecha_entrega)->lt(now())) $diasDiferencia = \Carbon\Carbon::parse($datos[0]->fecha_entrega)->diffInDays(now());
            }
        } else { //No hay prorroga
            if (\Carbon\Carbon::parse($datos[0]->fecha_entrega)->lt(now())) $diasDiferencia = \Carbon\Carbon::parse($datos[0]->fecha_entrega)->diffInDays(now());
        }

        if ($diasDiferencia > 15) $diasDiferencia = 15;

        return $diasDiferencia;
    }

    public function actualizarPenalizacion($dias) {
        $oce = new OrdenCompraEnvioController();
        $oce->guardarPenalizacion($dias);
    }

    public function obtenerFechaHoy() { //Funcion usada por algunos modales para evitar seleccionar fechas antiguas a hoy
        $carbon = new \Carbon\Carbon();
        $fecha_hoy = $carbon->now();
        return $fecha_hoy->format('Y-m-d');
    }

    public function fetchOrdenCompraProveedor() {
        $ocp = $this->hashEncode(OrdenCompraProveedor::allOrdenCompraProveedor($this->id()));

        foreach ($ocp as $key => $proveedor) {
            $aux = json_decode($proveedor->indicador_proveedor);
            $ocp[$key]->estatus = $aux->estatus;
            $ocp[$key]->etapa = $aux->etapa;
            $ocp[$key]->css = $aux->css;
            $ocp[$key]->estatus_pago = $this->verificarPagos($ocp[$key]);
            //$this->verificarEtapaConfirmacion($proveedor->confirmacion, $proveedor->fecha_oce, $proveedor->id_orden);
        }
        return Datatables::of($ocp)->toJson();
    }

    public function verificarEtapaConfirmacion($confirmacion, $fecha_oce, $idOrden) {
        /*  Función que permite verificar si la orden de compra es nueva (si está en la etapa de confirmación).
            Si la etapa está en confirmación se procede a verificar si han pasado 24 horas desde su creación.
            Si ya han pasado las 24 horas y el proveedor no ha declarado si acepta o rechaza la orden, entonces se procede a rechazarla de manera "automatica" */
        if ($confirmacion != 2) {
            if (now()->gt(\Carbon\Carbon::parse($fecha_oce)->addDay())) {
                $this->procesarRechazar('Otro', 'Orden de compra rechazada automaticamente por falta de confirmación por parte del proveedor', $idOrden);
            }
        }
    }

    public function verificarPagos($ocp) {
        if ($ocp->fecha_sap != null) {
            $tieneDeuda = $css = $retraso = ''; //tieneDeuda: '' = No aplica, Pagado, Deuda
            if ($ocp->fecha_pago != null) {
                $tieneDeuda = 'Pagada';
                $css = 'verde';
                $diasDiferencia = Carbon::parse($ocp->fecha_pago)->diffInDays(Carbon::parse($ocp->fecha_sap));
                if ($diasDiferencia > 20) {
                    $retraso = ($diasDiferencia - 20) . ' días';
                }
            } else {
                $tieneDeuda = 'Deuda';
                $css = 'rojo';
                $diasDiferencia = now()->diffInDays(Carbon::parse($ocp->fecha_sap)); //Se revisa cuantos dias de retraso lleva con la fecha actual
                if ($diasDiferencia > 20) {
                    $retraso = ($diasDiferencia - 20) . ' días';
                }
            }
            return ['pago' => $tieneDeuda, 'css' => $css, 'retraso' => $retraso];
        } else {
            return ['pago' => '', 'css' => '', 'retraso' => ''];
        }
    }

    public function fetchProductosPorOrdenCompra() //Se le esta enviando la id por medio de session
    {
        $productos = $this->hashEncode(OrdenCompraBien::productosPorOrdenCompra($this->hashDecode(session('ordenCompraId')), $this->id()));
        $estadoConfirmacion = ["En espera", "Aceptado", "Rechazado", "Sustituido", "Cancelado"]; //aceptado 1 rechazado 2 sustituido 3 cancelado 4
        $estatusCss = ['gris', 'verde', 'rojo', 'dorado', 'rojo'];
        foreach ($productos as $key => $producto) {
            if ($producto->estatus != null) {
                $productos[$key]->css = $estatusCss[$producto->estatus];
                $productos[$key]->estatus = $estadoConfirmacion[$producto->estatus];
            } else {
                $productos[$key]->css = $estatusCss[0];
                $productos[$key]->estatus = $estadoConfirmacion[0];
            }
        }

        return Datatables::of($productos)->toJson();
    }

    public function storeContrato($fecha) {
        $ultimoId = Contrato::ultimo();
        $ultimo = 1;
        if (isset($ultimoId[0]->id)) {
            $ultimo = $ultimoId[0]->id + 1;
        }

        $contrato = new Contrato();
        $contrato->contrato_pedido = "CM-CP-" . $ultimo . "-" . date('Y');
        $contrato->nombre_proveedor = Auth::guard('proveedor')->user()->nombre;
        $contrato->rfc_proveedor = Auth::guard('proveedor')->user()->rfc;
        $contrato->representante_proveedor = Auth::guard('proveedor')->user()->nombre_legal . " " . Auth::guard('proveedor')->user()->primer_apellido_legal . " " . Auth::guard('proveedor')->user()->segundo_apellido_legal;
        $contrato->domicilio_proveedor = Auth::guard('proveedor')->user()->tipo_vialidad . " " . Auth::guard('proveedor')->user()->vialidad . " No. Ext." . Auth::guard('proveedor')->user()->numero_exterior . " No. Int." . Auth::guard('proveedor')->user()->numero_interior . ", " . Auth::guard('proveedor')->user()->colonia . ", C.P." . Auth::guard('proveedor')->user()->codigo_postal . ", " . Auth::guard('proveedor')->user()->alcaldia . ", " . Auth::guard('proveedor')->user()->entidad_federativa;
        $contrato->telefono_proveedor = Auth::guard('proveedor')->user()->telefono_legal;
        $contrato->fecha_entrega = $fecha;
        $contrato->cedula_identificacion = Auth::guard('proveedor')->user()->cedula_identificacion;
        $contrato->acta_identidad = Auth::guard('proveedor')->user()->acta_identidad;
        $contrato->fecha_constitucion_identidad = Auth::guard('proveedor')->user()->fecha_constitucion_identidad;
        $contrato->titular_identidad = Auth::guard('proveedor')->user()->titular_identidad;
        $contrato->num_notaria_identidad = Auth::guard('proveedor')->user()->num_notaria_identidad;
        $contrato->entidad_identidad = Auth::guard('proveedor')->user()->entidad_identidad;
        $contrato->num_reg_identidad = Auth::guard('proveedor')->user()->num_reg_identidad;
        $contrato->fecha_reg_identidad = Auth::guard('proveedor')->user()->fecha_reg_identidad;
        $contrato->num_instrumento_representante = Auth::guard('proveedor')->user()->num_instrumento_representante;
        $contrato->titular_representante = Auth::guard('proveedor')->user()->titular_representante;
        $contrato->num_notaria_representante = Auth::guard('proveedor')->user()->num_notaria_representante;
        $contrato->entidad_representante = Auth::guard('proveedor')->user()->entidad_representante;
        $contrato->num_reg_representante = Auth::guard('proveedor')->user()->num_reg_representante;
        $contrato->fecha_reg_representante = Auth::guard('proveedor')->user()->fecha_reg_representante;
        $contrato->urg_id = session()->get('urgId');
        $contrato->orden_compra_id = $this->hashDecode(session()->get('ordenCompraId'));
        $contrato->proveedor_id = Auth::guard('proveedor')->user()->id;
        $contrato->requisicion_id = session()->get('requisicionId');
        $contrato->save();

        $firma = new OrdenCompraFirma();
        $firma->rfc = Auth::guard('proveedor')->user()->rfc;
        $firma->nombre = Auth::guard('proveedor')->user()->nombre_legal;
        $firma->primer_apellido = Auth::guard('proveedor')->user()->primer_apellido_legal;
        $firma->segundo_apellido = Auth::guard('proveedor')->user()->segundo_apellido_legal;
        $firma->puesto = 'Director General';
        $firma->telefono = Auth::guard('proveedor')->user()->telefono_legal;
        $firma->extension = Auth::guard('proveedor')->user()->extension_legal;
        $firma->correo = Auth::guard('proveedor')->user()->correo_legal;
        $firma->identificador = 3;
        $firma->contrato_id = $contrato->id;
        $firma->save();
    }

    public function indexContrato() {
        return view('proveedores.orden_compra.contratos.index');
    }

    public function fetchContratos() {
        $contratos = $this->hashEncode(Contrato::allFirmantePorProveedor(Auth::guard('proveedor')->user()->rfc));
        $firmante = ['titular', 'adquisiciones', 'proveedor', 'financiera', 'requiriente'];
        foreach ($contratos as $key => $contrato) {
            $firmas = OrdenCompraFirma::firmas($contrato->id);
            foreach ($firmas as $firma) {
                $aux = $firmante[$firma->identificador - 1];
                $contratos[$key]->$aux = true;
            }
        }
        return Datatables::of($contratos)->toJson();
    }
}
