@extends('layouts.admin')
    @section('content')
        @include('admin.orden-compra.encabezado_interno')
        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <div class="col text-center">
                    <p class="text-14 mt-4 m-2">Contrato número: {{ $contrato->contrato_pedido }}</p>
                </div>
                
                @if($firmantes != [])
                    <div class="text-center">
                        <p class="text-1 mt-3">Firma Titular Dirección General de Administración y Finanzas u Homólogo:
                            <span><strong>@if($firmantes[1]['fecha_firma']) {{ Carbon\Carbon::parse($firmantes[1]['fecha_firma'])->format('d/m/Y') }} @endif</strong></span></p>
                        <p class="text-1 mt-3">Firma Titular Área de Adquisiciones o Compras:
                            <span><strong>@if($firmantes[2]['fecha_firma']) {{  Carbon\Carbon::parse($firmantes[2]['fecha_firma'])->format('d/m/Y') }} @endif</strong></span></p>
                        <p class="text-1 mt-3">Firma Representante Legal: <span><strong>@if($firmantes[3]['fecha_firma']) {{ Carbon\Carbon::parse($firmantes[3]['fecha_firma'])->format('d/m/Y') }} @endif</strong></span></p>
                        @if(isset($firmantes[4]))
                            <p class="text-1 mt-3">Firma Titular Área Financiera: <span><strong>@if($firmantes[4]['fecha_firma']) {{ Carbon\Carbon::parse($firmantes[4]['fecha_firma'])->format('d/m/Y') }} @endif</strong></span></p>
                        @endif
                        @if(isset($firmantes[5]))
                            <p class="text-1 mt-3">Firma Titular Área Requirente: <span><strong>@if($firmantes[5]['fecha_firma']) {{ Carbon\Carbon::parse($firmantes[5]['fecha_firma'])->format('d/m/Y') }} @endif</strong></span></p>
                        @endif
                        <div class="mt-4">
                            <a href="{{ asset('storage/contrato-pedido/contrato_pedido_'.$contrato->contrato_pedido.'.pdf') }}" class="mx-4" target="_blank">
                                <p class="text-5"><span><i class="fa-solid fa-file-contract text-5"></i></span><strong>Contrato</strong></p>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <p class="text-gris-titulo">Sin contrato creado</p>
                    </div>
                @endif

            </div>
        </section>

    @endsection