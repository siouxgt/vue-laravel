@extends('layouts.proveedores_ficha_productos')
@section('content')
    @include('proveedores.orden_compra.seguimiento.encabezado_interno')

    <hr>
    <section class="row justify-content-center">
        <div class="col-lg-6 col-md-11 col-11 align-self-center border rounded">
            <div class="col text-center mt-3">
                <p class="text-1 mt-4 m-2">
                    @if (!$facturaEntregada)
                        Para evitar errores, revisa los datos de facturación
                        <a href="javascript: void(0)" id="btn_datos_facturacion">
                            <span class="text-5 font-weight-bold">aquí.</span>
                        </a>
                    @else
                        A partir de este momento corren <b>máximo 20 días</b> para que se realice el pago.
                    @endif
                </p>
            </div>
            <hr>
            @if (!$facturaEntregada)
                <div class="text-center mt-3 mb-3">
                    <p class="text-1 mb-3 font-weight-bold">Días para concluir la facturación</p>
                    @if ($tiempoRestante !== null)
                        @if ($tiempoRestante === 0)
                            <p class="text-18">Hoy es el ultímo día para subir la factura sin ser penalizado</p>
                        @else
                            <p class="text-11">{{ $tiempoRestante }}</p>
                        @endif
                    @else
                        <p class="text-18">Existe {{ $tiempoRetraso }} día(s) de retraso para entregar la factura</p>
                    @endif
                </div>
                <hr>
            @endif
            @if ($tiempoRetraso !== null && $facturaEntregada)
                <div class="text-center mt-3 mb-3">
                    <p class="text-14 mb-3 font-weight-bold">Retraso en facturación</p>
                    <p class="text-18">Existe {{ $tiempoRetraso }} día(s) de retraso al entregar la factura.</p>
                </div>
                <hr>
            @endif
            @if ($etapaFactura === 3)
                <div class="col text-center mb-4">
                    <p class="text-1 mt-4">Fecha de aceptación</p>
                    <p class="text-1">
                        <strong>{{ Carbon\Carbon::parse($consultaFactura[0]->fecha_factura_envio)->format('d/m/Y') }}</strong>
                    </p>

                    <p class="text-1 mt-4">Fecha de <strong>ingreso en SAP GRP</strong></p>
                    <p class="text-1">
                        <strong>{{ Carbon\Carbon::parse($consultaFactura[0]->fecha_sap)->format('d/m/Y') }}</strong>
                    </p>
                </div>
            @else
                <div class="col text-center mb-4">
                    <p class="text-14">
                        @if ($etapaFactura === 0)
                            1. Adjuntar Prefactura
                        @elseif($etapaFactura === 1)
                            1. Adjuntar Factura timbrada
                        @endif
                    </p>
                    @if ($desgloceCorrecciones)
                        @if ($consultaFactura[0]->contador_rechazos_prefactura === 2)
                            <p class="text-21 mt-3">Nota: Está es la ultima corrección que podrás realizar.
                                Para evitar errores, revisa los datos de facturación.<br>
                                Si necesitas más detalles del cambio, contacta al comprador.</p>
                        @endif
                    @endif
                    <button type="button" class="btn boton-3a mt-3" id="btn_adjuntar_prefactura"
                        @if (!$btnAdjuntarArchivo) disabled="true" @endif>
                        Adjuntar archivo
                    </button>

                    @if ($desgloceFactura)
                        <p class="text-1 mt-4 mb-2">
                            @if ($leyendaTipoFecha === 0)
                                Fecha de envío
                            @elseif($leyendaTipoFecha === 1)
                                Archivo corregido
                            @else
                                Fecha de aceptación
                            @endif
                        </p>
                        @if ($etapaFactura === 0)
                            {{-- Prefactura  --}}
                            <p class="text-1 mb-3">
                                <strong>{{ Carbon\Carbon::parse($consultaFactura[0]->fecha_prefactura_envio)->format('d/m/Y') }}</strong>
                            </p>
                            <a class="text-5 font-weight-bold" target="_blank"
                                href="{{ route('orden_compra_factura.descargar_archivo', [$consultaFactura[0]->archivo_prefactura, 0]) }}">
                                <i class="fa-solid fa-file-invoice text-goldoc"></i>
                                <strong>Prefactura</strong>
                            </a>
                        @elseif($etapaFactura === 1)
                            <p class="text-1 mb-2">
                                <strong>{{ Carbon\Carbon::parse($consultaFactura[0]->fecha_factura_envio)->format('d/m/Y') }}</strong>
                            </p>
                            <a class="text-5 font-weight-bold" target="_blank"
                                href="{{ route('orden_compra_factura.descargar_archivo', [$consultaFactura[0]->archivo_factura, 1]) }}">
                                <i class="fa-solid fa-file-invoice text-goldoc"></i>
                                <strong>Factura timbrada</strong>
                            </a>
                        @endif
                    @endif
                </div>
                @if ($desgloceCorrecciones)
                    <hr>
                    <div class="col text-center mb-4">
                        <p class="text-14">Correcciones solicitadas</p>
                        <p class="text-1">
                            Si necesitas más detalles del cambio, contacta al comprador.
                        </p>


                        <p class="text-2 font-weight-bold mt-4">Tipo de corrección</p>
                        <p class="text-21">{{ $correcciones->tipo_correccion }}</p>

                        <p class="text-2 font-weight-bold mt-4">Descripción del cambio</p>
                        <p class="text-21">{{ $correcciones->descripcion }}</p>
                    </div>
                @endif
                @if ($numeroPenalizaciones !== 0)
                    <hr>
                    <div class="col text-center mb-4">
                        <p class="text-14">Penalización</p>
                        <p class="text-1">
                            El sistema registró
                            @if ($numeroPenalizaciones === 1)
                                1 penalización
                            @else
                                2 penalizaciones
                            @endif por entrega tardía. El monto será descontado <br> de la factura
                            (antes
                            de IVA).
                        </p>

                        <p class="text-1 font-weight-bold mt-3">Monto total de la penalización </p>
                        <p class="text-18">
                            ${{ number_format($penalizacionPrecioEnvio + $penalizacionPrecioSustitucion, 2) }}
                        </p>
                        @if ($penalizacionEnvio != null)
                            <p class="text-1 font-weight-bold mt-3">
                                Penalización del 1% por {{ $penalizacionEnvio }} día(s) de atraso en primera entrega
                            </p>
                            <p class="text-18">${{ number_format($penalizacionPrecioEnvio, 2) }}</p>
                        @endif

                        @if ($penalizacionSustitucion != null)
                            <p class="text-1 font-weight-bold mt-3">
                                Penalización del 1% por {{ $penalizacionSustitucion }} día(s) de atraso en sustitución
                            </p>
                            <p class="text-18">${{ number_format($penalizacionPrecioSustitucion, 2) }}</p>
                        @endif


                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection

@section('js')
    @routes(['ocp', 'ordenCompraFactura'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
