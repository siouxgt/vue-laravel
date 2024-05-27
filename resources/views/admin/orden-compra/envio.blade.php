@extends('layouts.admin')
    @section('content')
        @include('admin.orden-compra.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">

                <div class="col text-center">
                    <p class="text-1  m-1 mt-3">Si tienes dudas, contacta al proveedor.</p>
                </div>
                <hr>

                <div class="col text-center">
                    <p class="text-14">1. Datos de envío</p>

                    <p class="text-1 mt-3">Fecha de envío</p>
                    <p class="text-1"><strong> @if($envio->fecha_envio) {{ $envio->fecha_envio->format('d/m/Y') }} @endif</strong></p>

                    <p class="text-1 mt-3">Comentarios</p>
                    <p class="text-1 mb-3"><strong>{{ $envio->comentarios }}</strong></p>
                </div>
                <hr>

                <div class="col text-center">
                    <p class="text-14">2. Entrega del paquete</p>

                    <p class="text-1 mt-3">Fecha de entrega en almacén</p>
                    <p class="text-1"><strong>@if($envio->fecha_entrega_almacen) {{ $envio->fecha_entrega_almacen->format('d/m/Y') }} @endif</strong></p>

                    <p class="text-gris mt-3 mb-3"><a @if($envio->nota_remision) href="{{ asset('storage/proveedor/orden_compra/envios/notas_remision/'.$envio->nota_remision) }}" class="gold" @endif target="_blank"><i class="fa-solid fa-file-invoice @if($envio->nota_remision) gold @else gris @endif"></i>  Nota de remisión </a></p>
                </div>
                <hr>

                <div class="col text-center">
                    <p class="text-14">Penalización de envío</p>
                    <p class="text-1 px-5">El sistema registra penalización por entrega tardía. El monto será descontado de la factura (antes de IVA).</p>

                    <p class="text-1 mt-3"><strong>Fecha de entrega (Contrato)</strong></p>
                    <p class="text-1"><strong>{{ $fechaEntrega->fecha_entrega->format('d/m/Y') }}</strong></p>

                    <p class="text-1 mt-3"><strong>Días de diferencia vs Contrato</strong></p>
                    <p class="text-11"><strong>@if($diasDiferencia < 0) {{ $diasDiferencia * -1 }} @else 0 @endif </strong></p>

                    <p class="text-1 mt-3"><strong>Penalización del 1% por @if($diasDiferencia < -16)  15 @elseif($diasDiferencia < 0) {{ $diasDiferencia * -1 }} @else 0 @endif días</strong></p>
                    <p class="text-11"><strong>$ {{ number_format($penalizacion, 2) }}</strong></p>
                </div>
                <hr>
                @if($prorroga != '[]')
                    <div class="col text-center">
                        <p class="text-14">Prórroga</p>
                        <p class="text-2"><strong>Revisa la solicitud. Para aceptarla se solicitará tu eFirma.</strong></p>

                        <p class="text-1 mt-4">Fecha de solicitud</p>
                        <p class="text-1"><strong>{{ $prorroga[0]->fecha_solicitud->format('d/m/Y') }}</strong></p>

                        <div class="row mt-4">
                            <div class="col-4 offset-md-2">
                                <p class="text-5 mt-3 mb-3"><a href="{{ asset('storage/proveedor/orden_compra/envios/prorroga_solicitud/'.$prorroga[0]->solicitud) }}" class="gold" target="_blank"><i class="fa-solid fa-file-invoice text-5"></i> Solicitud</a></p>
                            </div>
                            <div class="col-4">
                                <p class="text-5 mt-3 mb-3"><a href="{{ asset('storage/proveedor/orden_compra/envios/prorroga_justificacion/'.$prorroga[0]->justificacion) }}" class="gold" target="_blank"><i class="fa-solid fa-file-invoice text-5"></i> Justificación </a></p>
                            </div>
                        </div>
                        

                        <p class="text-1 mt-4">Días solicitados</p>
                        <p class="text-11"><strong>{{ $prorroga[0]->dias_solicitados }}</strong></p>

                        <p class="text-1 mt-4">Fecha de entrega solicitada</p>
                        <p class="text-1"><strong>{{ $prorroga[0]->fecha_entrega_compromiso->format('d/m/Y') }}</strong></p>

                        <p class="text-1 mt-4">Fecha respuesta</p>
                        <p class="text-1"><strong id="fecha_respuesta">@if($prorroga[0]->fecha_aceptacion){{ $prorroga[0]->fecha_aceptacion->format('d/m/Y') }} @endif</strong></p>
                        <a id="descarga"></a>
                        
                        <div class="row mt-4">
                            @if($prorroga[0]->estatus != 0)
                                <div class="col-4 offset-md-2">
                                    <p class="text-5 mt-3 mb-3"><a href="{{ asset('storage/acuse-prorroga/acuse_prorroga_'.$prorroga[0]->id.'.pdf') }}" class="gold" target="_blank"><i class="fa-solid fa-file-invoice text-5"></i> Acuse</a></p>
                                </div>
                            @endif
                            @if($prorroga[0]->acuse)
                                <div class="col-4">
                                    <p class="text-5 mt-3 mb-3"><a href="{{ asset('storage/acuse-prorroga/'.$prorroga[0]->acuse)}}" class="gold" target="_blank"><i class="fa-solid fa-file-invoice text-5"></i> Acuse firmado</a></p>
                                </div> 
                            @endif
                        </div>
                    </div>
                    <hr>
                @endif

                <div class="col text-center">
                    <p class="text-14">Reportes</p>
                    <p class="text-2"><strong>Abiertos por la URG.</strong></p>

                    @foreach($reportes as $reporte)
                        <p class="text-center text-rojo p-2"><b>ID Reporte: {{ $reporte->id_reporte}}</b></p>
                    @endforeach

                    <p class="text-14 mt-5">Incidencia</p>
                    <p class="text-2"><strong>Abiertas por la URG.</strong></p>

                    <div id="des_incidencia">
                        @if($incidencias != "[]")
                            <p class="text-center text-rojo p-2"><b>ID Incidencia: {{ $incidencias[0]->id_incidencia }}</b></p>
                        @endif
                    </div>

                </div>
                <hr>

                <div class="col text-center">
                    <p class="text-14 mt-3">Compra cancelada</p>
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
                <br>
            </div>


            </div>
        </section>

    @endsection