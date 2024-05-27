@extends('layouts.proveedores_ficha_productos')

@section('content')
    <!-------------------------Nombre----------------------->
    <div class="row my-5 d-flex justify-content-center">
        <div class="col-8 text-center">
            <p class="text-1">{{ $datos[0]->urg_nombre }}</p>
            <h1 class="text-14">Entrega por Sustitución</h1>
            <a href="javascript: void(0)" onclick="history.back()" class="text-goldoc">
                <i class="fa-solid fa-arrow-left text-gold"></i>
                Regresar
            </a>
            <input type="hidden" name="fecha_hoy" id="fecha_hoy"
                value="{{ Carbon\Carbon::parse($fecha_hoy)->format('d/m/Y') }}">
        </div>
    </div>
    <!-------------------------Nombre----------------------->

    <hr>
    <section class="row justify-content-center">
        <div class="col-lg-6 col-md-11 col-11 align-self-center border rounded">            
            <div class="col text-center mt-3">
                <a class="text-5 font-weight-bold" target="_blank"
                    href="{{ route('orden_compra_sustitucion.descargar_nota_remision', [$consultaSustitucion[0]->archivo_acuse_sustitucion, 1]) }}">
                    Descargar Acuse Sustitución
                </a>
            </div>
            <hr>
            @if (!$desgloceNotaRemision)

                <div class="text-center mt-3 mb-3">
                    <p class="text-1 font-weight-bold">Días para entregar la Sustitución</p>
                    @if ($penalizacion === 0)
                        @if ($diasEntregaSustitucion === 0)
                            <p class="text-18">Hoy es su último día para entregar sin ser penalizado</p>
                        @else
                            <p class="text-11"> {{ $diasEntregaSustitucion }} </p>
                        @endif
                    @else
                        <p class="text-18">Retraso de {{ $penalizacion }} días en la entrega.</p>
                    @endif

                </div>
                <hr>
            @endif

            <div class="col text-center mb-4">
                <p class="text-14">1. ¿Ya enviaste el pedido?</p>
                <button type="button" class="btn boton-3a mt-3" id="btn_confirmar_envio_sust"
                    @if (!$botonEnvio) disabled @endif>Confirmar envío</button>
                @if (!$botonEnvio)
                    {{-- Si el botón de envío esta bloqueado, significa que ya se realizó el envío --}}
                    <p class="text-1 mt-4">Fecha de envío</p>
                    <p class="text-1">
                        <strong>{{ Carbon\Carbon::parse($consultaSustitucion[0]->fecha_envio)->format('d/m/Y') }}</strong>
                    </p>
                @endif
            </div>

            <hr>

            <div class="col text-center mb-4">
                <p class="text-14">2. ¿Ya entregaste la Sustitución?</p>
                <button type="button" class="btn boton-3a mt-3" id="btn_confirmar_entrega_sustitucion"
                    @if (!$botonNotaRemision) disabled @endif>
                    Adjuntar Nota de remisión
                </button>

                @if ($desgloceNotaRemision)
                    <p class="text-1 mt-4">Fecha de entrega en almacén</p>
                    <p class="text-1  mb-4">
                        <strong>{{ Carbon\Carbon::parse($consultaSustitucion[0]->fecha_entrega)->format('d/m/Y') }}</strong>
                    </p>

                    <a class="text-goldoc" target="_blank"
                        href="{{ route('orden_compra_sustitucion.descargar_nota_remision', $consultaSustitucion[0]->archivo_nota_remision) }}">
                        <i class="fa-solid fa-file-invoice text-goldoc"></i>
                        <strong>Nota de remisión</strong>
                    </a>
                @endif

                @if ($consultaSustitucion[0]->aceptado)
                    <p class="text-1 mt-4">Sustitución aceptada</p>
                    <p class="text-1  mb-4">
                        <strong>{{ Carbon\Carbon::parse($consultaSustitucion[0]->fecha_aceptada)->format('d/m/Y') }}</strong>
                    </p>
                @endif

            </div>

            <hr>
            <div class="col text-center mt-3">
                <p class="text-1"><strong>Fecha de solicitud sustitución</strong></p>
                <p class="text-1">{{ Carbon\Carbon::parse($consultaSustitucion[0]->created_at)->format('d/m/Y') }}</p>
            </div>
            <div class="col text-center mt-3">
                <p class="text-1"><strong>Días de atraso en sustitución</strong></p>
                <p class="@if ($penalizacion === 0) text-11 @else text-10 @endif">{{ $penalizacion }}</p>
            </div>
            <div class="col text-center mt-3 mb-3">
                <p class="text-1"><strong>Penalización del 1% por {{ $penalizacion }} día(s)</strong></p>
                <p class="@if ($penalizacion === 0) text-11 @else text-10 @endif">
                    ${{ number_format($penalizacionPrecio, 2) }}
                </p>
            </div>

        </div>
    </section>
@endsection

@section('js')
    @routes(['ocp', 'ordenCompraSustitucion'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
@endsection
