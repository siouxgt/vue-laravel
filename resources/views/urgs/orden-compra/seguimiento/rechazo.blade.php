@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')
        
            <section class="row justify-content-md-center">
                <div class="col-md-5 col-sm-11 align-self-center border rounded">
                    <div class="col text-center">
                        <p class="text-rojo-titulo m-2">ID Rechazo: {{ $rechazo[0]->rechazo }}</p>
                    </div>
                    <hr>
                    <div class="col text-center">
                        <p class="text-1 font-weight-bold">Motivo de la cancelación:</p>
                        <p class="text-1">{{ $rechazo[0]->motivo }}</p>
                    </div>
                    <div class="col text-center mt-4 mb-5">
                        <p class="text-1 font-weight-bold">Comentarios:</p>
                        <p class="text-1">{{ $rechazo[0]->descripcion }}</p>
                    </div>
                     <div class="text-center mt-2">
                        <p><a href="javascript:void(0)" onclick="rechazadas()" class="@if($contProductoRechazados > 0) text-gold-titulo @else text-gris-titulo @endif">Ver productos rechazados</a></p>
                    </div> 
                </div>
            </section>

    @endsection
    @section('js')
        @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection