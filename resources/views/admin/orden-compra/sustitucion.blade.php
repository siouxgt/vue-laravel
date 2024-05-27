@extends('layouts.admin')
    @section('content')
        @include('admin.orden-compra.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">

                <div class="col text-center mt-3">
                    <a href="{{ asset('storage/proveedor/orden_compra/envios/notas_remision/'.$envio->nota_remision) }}" target="_bank"><p class="text-gold-2">Ver la nota de remisión <span class="text-1">del pedido.</span> </p></a>
                </div>
                <hr>

                
                <div class="col text-center">
                    <p class="text-14">1. Pedido aceptado</p>
                    <div class="row mt-3 pz-5">
                        @if($envio->estatus == true || is_null($envio->estatus))
                            <div class="@if($envio->estatus == true) col-12 @else col-6 float-right @endif">
                                <button type="button" class="btn boton-3a">Sí</button>
                            </div>
                        @endif
                        @if($envio->estatus == false || is_null($envio->estatus))
                            <div class="@if($envio->estatus == false and is_null($envio->estatus)) col-6 float-left @else col-12 @endif">
                                <button type="button" class="btn boton-3a">No</button>
                            </div>
                        @endif
                    </div>
                </div>
                <hr>

                <div class="col @if($envio->estatus == false) ocultar @endif hr" id="div_fecha">
                    <p class="text-1 text-center">Entrega @if($envio->estatus) aceptada @else rechazada @endif</p>
                    <p class="text-1 text-center">@if($envio->fecha_entrega_aceptada) {{ $envio->fecha_entrega_aceptada->format('d/m/Y') }} @endif</p>
                </div>

                <p class="text-14 text-center">2. Datos de facturación</p>
                <div class="text-center mt-3">
                    <button type="button" class="btn boton-3a"  onclick="datosFacturacion()">Revisar</button>
                </div>

                <hr>
                @if($sustitucion != "[]")
                    <div class="col px-3 mb-4">
                        <p class="text-1 text-center mt-3">Sustitución.</p>

                        <p class="text-rojo mt-4 text-center">ID Solicitud: {{ $sustitucion[0]->sustitucion }}</p>

                        @if($sustitucion[0]->archivo_acuse_sustitucion)
                            <a href="{{ asset('storage/acuse-sustitucion/'.$sustitucion[0]->archivo_acuse_sustitucion) }}" target="_blank"><p class="text-5 mt-4 text-center"><strong><span><i class="fa-solid fa-file-invoice text-5"></i></span> Acuse</strong></p></a>
                        @endif 
                    </div>
                    <hr>

                    <div class="col text-center mb-3">
                        <p class="text-14">3. Entrega</p>

                        <p class="text-1 mt-3"><strong>Días para entregar la Sustitución</strong></p>
                        <p class="text-red-precio mt-1"><strong id="dias">{{ $diasSustitucion }}</strong></p>

                        <p class="text-1 mt-3">Fecha de entrega en almacén</p>
                        <p class="text-11 mt-1"><strong> @if($sustitucion[0]->fecha_entrega) {{ $sustitucion[0]->fecha_entrega->format('d/m/Y') }} @endif </strong></p>
                        @if($sustitucion[0]->archivo_nota_remision)
                            <a href="{{ asset('storage/proveedor/orden_compra/sustitucion/notas_remision/'.$sustitucion[0]->archivo_nota_remision) }}" target="_blank"><p class="text-5 mt-3 text-center"><i class="fa-solid fa-file-invoice text-5"></i><strong>Nota de remisión</strong> </p></a>
                            <hr>
                            <div class="col">
                                <p class="text-14 text-center">¿Aceptas la sustitución del pedido?</p>
                                <div class="row mt-3 pz-5">
                                    <div class="col-12">
                                        <button type="button" class="btn boton-3a">Sí</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endif
                    </div>
                    <hr>
                @endif

                <div class="col text-center">
                    <p class="text-14">Penalización de sustitución</p>
                    <p class="text-1 px-5">El sistema registra penalización por entrega tardía. El monto será descontado de la factura (antes de IVA).</p>

                    <p class="text-1 mt-3"><strong>Fecha de entrega (Contrato)</strong></p>
                    <p class="text-1"><strong>{{ $fechaEntrega->fecha_entrega->format('d/m/Y') }}</strong></p>

                    <p class="text-1 mt-3"><strong>Días de diferencia vs Contrato</strong></p>
                    <p class="text-11"><strong>@if($diasDiferencia < 0) {{ $diasDiferencia * -1 }} @else 0 @endif </strong></p>

                    <p class="text-1 mt-3"><strong>Penalización del 1% por @if($diasDiferencia < -16)  15 @elseif($diasDiferencia < 0) {{ $diasDiferencia * -1 }} @else 0 @endif días</strong></p>
                    <p class="text-11"><strong>$ {{ number_format($penalizacion, 2) }}</strong></p>
                </div>
                
            </div>


            </div>
        </section>

    @endsection
    @section('js')
    @routes(['ordenCompraAdmin'])
        <script src="{{ asset('asset/js/seguimiento_admin.js') }}" type="text/javascript"></script>
    @endsection