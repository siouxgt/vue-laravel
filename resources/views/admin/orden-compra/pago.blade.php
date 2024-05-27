@extends('layouts.admin')
    @section('content')
        @include('admin.orden-compra.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">

                <div class="col text-center mb-3">
                    <p class="text-14">1. Pago en CLC</p>

                    <div @if($pago[0]->archivo_clc == null) class="ocultar" @endif id="div_archivo">
                        <div class="row d-flex align-items-center justify-content-center mt-3">
                            <a @if($pago[0]->archivo_clc) href="{{ asset('storage/comprobante-clc/'.$pago[0]->archivo_clc) }}" @endif target="_blank" id="archivo_clc"><p class="text-5 mt-4 text-center"><strong><span><i class="fa-solid fa-file-invoice-dollar text-5"></i></span>Comprobante de pago</strong></p></a>

                        </div>
                    
                        <p class="text-1 mt-4">Fecha de envío</p>
                        <p class="text-1"><strong id="fecha_ingreso">@if($pago[0]->fecha_ingreso) {{ $pago[0]->fecha_ingreso->format('d/m/y') }} @endif</strong></p>
                    </div>

                </div>

                <hr>
                
                <div class="col text-center mb-3 mt-4">
                    <p class="text-14">Retraso en el pago</p>
                    <p class="text-2">Abiertos por la URG.</p>
                </div>

                <div class="col text-center mb-3" id="div_retraso">
                    @if($retraso != '[]')
                        <p class="text-center text-rojo p-2">ID Retraso: {{ $retraso[0]->id_retraso }}</p>
                    @endif
                </div>
        </section>

    @endsection