@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <p class="text-1  text-center mt-4">Adjunta aquí el comprobante de pago. Archivo PDF menor a 3MB.</p>
                <hr>

                <div class="col text-center mb-3">
                    <p class="text-14">1. ¿Ya realizaste el pago?</p>

                    <div class="text-center mt-3">
                        <button type="button" class="btn boton-3a" @if($pago[0]->archivo_clc)  disabled @else onclick="comprobanteClcModal()" @endif id="adjuntar_clc">Adjuntar comprobante CLC</button>
                    </div>

                    <div @if($pago[0]->archivo_clc == null) class="ocultar" @endif id="div_archivo">
                        <div class="row d-flex align-items-center justify-content-center mt-3">
                            <a @if($pago[0]->archivo_clc) href="{{ asset('storage/comprobante-clc/'.$pago[0]->archivo_clc) }}" @endif target="_blank" id="archivo_clc"><p class="text-5 mt-4 text-center"><strong><span><i class="fa-solid fa-file-invoice-dollar text-5"></i></span>Comprobante de pago</strong></p></a>

                        </div>
                    
                        <p class="text-1 mt-4">Fecha de envío</p>
                        <p class="text-1"><strong id="fecha_ingreso">@if($pago[0]->fecha_ingreso) {{ $pago[0]->fecha_ingreso->format('d/m/Y') }} @endif</strong></p>
                    </div>

                </div>

                <hr>
                <p class="text-1  text-center mt-4">Si no has realizado el pago, contacta al proveedor para explicarle el motivo.</p>

                <div class="col text-center mb-3 mt-4">
                    <p class="text-14">Retraso en el pago</p>
                    <p class="text-2">El mensaje le llegará al proveedor y al administrador.</p>
                </div>

                <div class="text-center mt-3 mb-4">
                    <button type="button" class="btn boton-3a" @if($pago[0]->archivo_clc == null && $retraso == '[]') onclick="retrasoModal();" @else  disabled @endif id="retraso">Informar al proveedor</button>
                </div>

                <div class="col text-center mb-3" id="div_retraso">
                    @if($retraso != '[]')
                        <p class="text-center text-rojo p-2">ID Retraso: {{ $retraso[0]->id_retraso }}</p>
                    @endif
                </div>
        </section>

    @endsection
    @section('js')
    @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection