@extends('layouts.proveedores_ficha_productos')
@section('content')
    @include('proveedores.orden_compra.seguimiento.encabezado_interno')

    <hr>
    <section class="row justify-content-md-center">
        <div class="col-md-5 col-sm-11 align-self-center border rounded">
            <div class="col text-center">
                <p class="text-1 mt-4 m-2">Información correspondiente al pago.</p>
            </div>
            <hr>
            <div class="text-center mt-3 mb-3">
                <p class="text-1 mt-4"><strong>Fecha de ingreso en SAP GRP</strong> </p>
                <p class="text-1">{{ Carbon\Carbon::parse($consultaFactura[0]->fecha_sap)->format('d/m/Y') }}</p>

                @if(!$desglocePago)
                <p class="text-1 font-weight-bold mt-4">Días transcurridos</p>
                <p
                    class="@if (session()->get('diasTranscurridos') <= 14) text-precio-mayoreo @elseif(session()->get('diasTranscurridos') >= 15 && session()->get('diasTranscurridos') <= 20)text-amarillo @else text-rojo1 @endif">
                    {{ session()->get('diasTranscurridos') }}
                </p>
                @endif

                @if ($desglocePago)
                    <hr>
                    <p class="text-1 mt-3">Fecha de envío</p>
                    <p class="text-1">
                        <strong>{{ Carbon\Carbon::parse($consultaPagos->created_at)->format('d/m/Y') }}</strong>
                    </p>

                    <a class="text-goldoc" target="_blank"
                        href="{{ route('orden_compra_pago.descargar_archivo', $consultaPagos->archivo_clc) }}">
                        <i class="fa-solid fa-file-invoice text-goldoc mt-4"></i>
                        <strong>Comprobante de pago</strong>
                    </a>

                    @if (!$btnPago)
                        <p class="text-1 mt-2">Pago validado</p>
                    @else
                        <form action="">
                            <button type="button"
                                class="btn @if (!$btnPago) boton-10 @else boton-3a @endif mt-4"
                                id="btn_validar_pago" @if (!$btnPago) disabled @endif>Validar
                                pago</button>
                        </form>
                    @endif
                @endif
            </div>
            <hr>
            <div class="col text-center mb-4">
                <p class="text-14">Retraso en el pago</p>
                <p class="text-1">Mensajes recibidos</p>

                @if ($consultaMotivosRetraso !== null)
                    <p class="text-2 font-weight-bold mt-4">Motivo del retraso</p>
                    <p class="text-mensaje">{{ $consultaMotivosRetraso->motivo }}</p>

                    <p class="text-2 font-weight-bold mt-4">Descripción del cambio</p>
                    <p class="text-mensaje">{{ $consultaMotivosRetraso->descripcion }}</p>
                @endif
            </div>
            <hr>
            <div class="col text-center mb-4">
                <p class="text-14">Reportes de retraso en pago</p>
                <p class="text-2">Si tienes problemas con el pago puedes abrir un reporte.</p>

                <button type="button" class="btn @if (!$btnReportes) boton-10 @else boton-3a @endif mt-3"
                    id="btn_reporte_retraso" @if (!$btnReportes) disabled @endif>Reportar</button>

                <div class="mt-4"></div>
                @if ($desgloceReportes)
                    @foreach ($consultaReportes as $reporte)
                        <p class="text-mensaje">ID Reporte: {{ $reporte->id_reporte }}</p>
                    @endforeach
                @endif
            </div>

            <div class="col text-center mb-4">
                <p class="text-14">Abrir incidencia</p>
                <p class="text-2">Antes de abrir una incidencia, te sugerimos contactar al comprador.</p>

                <button type="button" class="btn @if (!$btnIncidencias) boton-10 @else boton-3a @endif mt-3"
                    id="btn_incidencia_pago" @if (!$btnIncidencias) disabled @endif>Abrir incidencia</button>

                @if ($desgloceIncidencias)
                    @foreach ($consultaIncidencias as $incidencia)
                        <p class="text-mensaje mt-4 mb-3">ID Incidencia: {{ $incidencia->id_incidencia }}</p>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection

@section('js')
    @routes(['ocp', 'ordenCompraFactura', 'ordenCompraPago'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
@endsection
