@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')
        
        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <div class="text-center  ml-1">
                    <p class="text-1 m-2">Fecha de entrega: @if($fechaEntrega) {{ $fechaEntrega->format('d/m/Y') }} @endif</p>
                </div>
                <hr>
                <div class="text-center">
                    <p class="text-14">1. Productos confirmados: {{ $contProductoAceptados }} de {{ $countTodosProducto }}</p>
                </div>
        
                <div class="text-center mt-2">
                     <p class="text-gold">
                        <a @if($contProductoAceptados) href="{{ route('orden_compra_urg.acuse_confirmada') }}" class="text-gold-titulo" @else class="text-gris-titulo" @endif><i class="fa-solid fa-file-invoice @if($contProductoAceptados)  gold @else gris @endif"></i>Acuse</a>
                    </p>
                </div>    
                <hr>
                <div class="text-center">
                    <p class="text-14">2. Productos rechazados: {{ $contProductoRechazados}} de {{ $countTodosProducto }}</p>
                </div>
                <div class="text-center mt-2">
                  <p><a href="javascript:void(0)" @if($contProductoRechazados > 0) onclick="rechazadas()" @endif class="@if($contProductoRechazados > 0) text-gold-titulo @else text-gris-titulo @endif">Ver productos rechazados</a></p>
                </div> 
                <hr>
                <div class="text-center">
                    <p class="text-2">
                      La Orden de compra no puede ser modificada en cantidades una vez que se emite en el sistema electrónico. <br> 
                      Para cambios de lugar y datos de entrega comunícate con el proveedor.
                    </p>
                </div>
                <br>
                <div class="text-center mt-1">
                    <p class="text-14">¿Quieres cancelar la compra?</p>
                </div> 
        
                <div class="text-center m-3">
                  <button type="button" id="cancelar" class="btn btn-outline-light-v" @if($contProductoAceptados > 0 or $contProductoRechazados  > 0 or !$cancelacion->isEmpty()) disabled @else onclick="cancelar('confirmacion')" @endif >Cancelar compra</button>
                </div>
            
                <div id="des_cancelacion">
                    @if(!$cancelacion->isEmpty())
                        <p class="text-center text-rojo p-2"><b>ID Cancelación: {{ $cancelacion[0]->cancelacion}}</b></p>
                        <p class="text-center"><b>Motivo de la cancelación:</b></p>
                        <p class="text-center text-2">{{ $cancelacion[0]->motivo}}</p>
                        <p class="text-center"><b>Comentarios:</b></p>
                        <p class="text-center text-2">{{ $cancelacion[0]->descripcion }}</p>
                    @endif
                </div>
            </div>
        </section>
    @endsection
    @section('js')
        @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection