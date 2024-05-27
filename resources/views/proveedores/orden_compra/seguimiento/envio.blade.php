@extends('layouts.proveedores_ficha_productos')

@section('content')
    <!-------------------------Nombre----------------------->
    <div class="row my-5 d-flex justify-content-center">
        <div class="col-8 text-center">
            <p class="text-1">{{ $datos[0]->urg_nombre }}</p>
            <h1 class="text-14">Confirmación envío/entrega</h1>
            <a href="javascript: void(0)" onclick="history.back()" class="text-goldoc">
                <i class="fa-solid fa-arrow-left text-gold"></i>
                Regresar
            </a>
        </div>
    </div>
    <!-------------------------Nombre----------------------->

    <hr>
    <section class="row justify-content-center">
        <div class="col-lg-6 col-md-11 col-11 align-self-center border rounded">
            @switch($seccion)
                @case('index')
                    <div class="col text-center">
                        <p class="text-1 m-2">Para aclaraciones, contacta al comprador.</p>
                    </div>
                    <hr>
                    <div class="col text-center">
                        <p class="text-14">1. ¿Ya enviaste el pedido?</p>
                        <button type="button" class="btn boton-3a mt-3" id="btn_confirmar_envio"
                            @if (!$botonEnvio) disabled @endif>Confirmar envío</button>
                        @if (!$botonEnvio)
                            {{-- Si el botón de envío esta bloqueado, significa que ya se realizó el envío --}}
                            <p class="text-1 mt-4">Fecha de envío</p>
                            <p class="text-1">
                                <strong>{{ Carbon\Carbon::parse($consultaEnvio[0]->fecha_envio)->format('d/m/Y') }}</strong>
                            </p>
                            <p class="text-1 mt-4">Comentarios</p>
                            <p class="text-1"><strong>{{ $consultaEnvio[0]->comentarios }}</strong></p>
                        @endif
                    </div>
                    <hr>
                    <div class="col text-center mb-4">
                        <p class="text-14">2. ¿Ya entregaste el pedido?</p>
                        <button type="button" class="btn boton-3a mt-3" id="btn_confirmar_entrega"
                            @if (!$botonNotaRemision) disabled @endif>Adjuntar
                            Nota de remisión</button>
                        @if ($banderaEntrega)
                            {{-- Si ya se hizo la entrega --}}
                            <p class="text-1 mt-4">Fecha de entrega en almacén</p>
                            <p class="text-1 mb-4">
                                <strong>{{ Carbon\Carbon::parse($consultaEnvio[0]->fecha_entrega_almacen)->format('d/m/Y') }}</strong>
                            </p>

                            <a class="text-goldoc" target="_blank"
                                href="{{ route('orden_compra_envio.descargar_nota_remision', $consultaEnvio[0]->nota_remision) }}">
                                <i class="fa-solid fa-file-invoice text-goldoc"></i>
                                <strong>Nota de remisión</strong>
                            </a>

                            @if ($consultaEnvio[0]->estatus != null)
                                <p class="text-1 mt-4">
                                    @if ($consultaEnvio[0]->estatus)
                                        Entrega aceptada
                                    @else
                                        Entrega rechazada
                                    @endif
                                </p>
                                <p class="text-1 mb-4">
                                    <strong>{{ Carbon\Carbon::parse($consultaEnvio[0]->fecha_entrega_aceptada)->format('d/m/Y') }}</strong>
                                </p>
                            @endif
                        @endif
                    </div>
                    <hr>
                    <div class="col text-center mt-3">
                        <p class="text-1"><strong>Fecha de entrega (Contrato)</strong></p>
                        <p class="text-1">{{ Carbon\Carbon::parse($datos[0]->fecha_entrega)->format('d/m/Y') }}</p>
                    </div>
                    @if ($desglocePenalizacionProrroga)
                        {{-- Si el boton de prorroga ya no esta disponible (desbloqueado) significa que ya se levanto una prorroga --}}
                        <div class="col text-center mt-3">
                            <p class="text-1"><strong>Fecha de entrega (Prórroga)</strong></p>
                            <p class="text-1">
                                {{ Carbon\Carbon::parse($consultaProrroga[0]->fecha_entrega_compromiso)->format('d/m/Y') }}</p>
                        </div>
                    @endif
                    <div class="col text-center mt-3">
                        <p class="text-1">
                            <strong>
                                @if (!$desglocePenalizacionProrroga)
                                    Días de diferencia vs Contrato
                                @else
                                    Días de diferencia vs Prórroga
                                @endif
                            </strong>
                        </p>
                        @php
                            $diasPenalizacion = $consultaEnvio[0]->penalizacion;
                            $diasDiferencia = 0;
                        @endphp
                        @if ($diasPenalizacion != 0)
                            @if($consultaEnvio[0]->fecha_entrega_almacen != null)
                                @php $diasDiferencia = \Carbon\Carbon::parse($datos[0]->fecha_entrega)->diffInDays(\Carbon\Carbon::parse($consultaEnvio[0]->fecha_entrega_almacen)); @endphp
                            @else
                                @php $diasDiferencia = \Carbon\Carbon::parse($datos[0]->fecha_entrega)->diffInDays(now()); @endphp
                            @endif
                        @endif

                        <p class="@if ($diasDiferencia != 0) text-10 @else text-11 @endif">{{ $diasDiferencia }}</p>
                    </div>
                    <div class="col text-center mt-3">
                        <p class="text-1"><strong>Penalización del 1% por {{ $diasPenalizacion }} días</strong></p>
                        <p class="@if ($diasPenalizacion != 0) text-10 @else text-11 @endif">
                            ${{ number_format($precioTotalSinIva[0]->total * ($diasPenalizacion / 100), 2) }}</p>
                    </div>
                    <hr>

                    <div class="col text-center mb-4">
                        <p class="text-14">Prórroga</p>
                        <p class="text-2">Si el pedido no llegará a tiempo, puedes solicitar una prórroga. 
                            <span class="text-rojo2">Se pedirá tu eFirma.</span></p>
                        <button type="button" class="btn boton-3a mt-3" id="btn_solicitar_prorroga"
                            @if ($diasPenalizacion != 0) disabled
                            @else
                                @if (!$botonProrroga) disabled @endif
                            @endif >Solicitar Prórroga
                        </button>

                        @if ($desgloceProrroga)
                            {{-- Si el boton de la prorroga esta bloqueado significa  que ya se levanto una solicitud --}}
                            <p class="text-1 mt-4">Fecha de solicitud</p>
                            <p class="text-1 mb-4">
                                <strong>{{ Carbon\Carbon::parse($consultaProrroga[0]->fecha_solicitud)->format('d/m/Y') }}</strong>
                            </p>

                            {{-- Muesta link para descarga de PDF --}}
                            <a class="text-goldoc" target="_blank"
                                href="{{ route('orden_compra_prorroga.descargar_solicitud', $consultaProrroga[0]->solicitud) }}">
                                <i class="fa-solid fa-file-invoice text-goldoc"></i>
                                <strong>Solicitud</strong>
                            </a>
                        @endif
                    </div>
                    @if ($desgloceProrroga)
                        {{-- Si el boton de la prorroga esta bloqueado significa  que ya se levanto una solicitud --}}
                        <div class="col text-center mt-3 mb-4">
                            <p class="text-1"><strong>Días solicitados</strong></p>
                            <p class="text-11">{{ $consultaProrroga[0]->dias_solicitados }}</p>

                            <p class="text-1 mt-4">Fecha de entrega solicitada</p>
                            <p class="text-1">
                                <strong>{{ Carbon\Carbon::parse($consultaProrroga[0]->fecha_entrega_compromiso)->format('d/m/Y') }}</strong>
                            </p>

                            <p
                                class="@if ($consultaProrroga[0]->estatus === 1) text-14 @elseif($consultaProrroga[0]->estatus === 2 || $consultaProrroga[0]->estatus === 3) text-10 @else text-10 @endif mt-4">
                                @if ($consultaProrroga[0]->estatus === 1)
                                    Prórroga aceptada
                                @elseif($consultaProrroga[0]->estatus === 2)
                                    Prórroga rechazada
                                @elseif($consultaProrroga[0]->estatus === 3)
                                    Prórroga cancelada
                                @else
                                    Prórroga en espera
                                @endif
                            </p>

                            <p class="text-1 mt-4">
                                @if ($consultaProrroga[0]->estatus === 1)
                                    Fecha aceptación Prórroga
                                @elseif($consultaProrroga[0]->estatus === 2)
                                    Fecha rechazo
                                @elseif($consultaProrroga[0]->estatus === 3)
                                    Fecha cancelación
                                @endif
                            </p>
                            @if ($consultaProrroga[0]->estatus !== 0)
                                <p class="text-11">
                                    {{ Carbon\Carbon::parse($consultaProrroga[0]->fecha_aceptacion)->format('d/m/Y') }}
                                </p>
                            @endif
                            @if ($consultaProrroga[0]->acuse !== null)
                                <a class="text-goldoc" target="_blank"
                                    href="{{ route('orden_compra_prorroga.descargar_acuse', $consultaProrroga[0]->acuse) }}">
                                    <i class="fa-solid fa-file-invoice text-goldoc"></i>
                                    <strong>Acuse</strong>
                                </a>
                            @endif
                        </div>
                    @endif
                @break

                @case('pdf_firma_prorroga')
                    <div class="d-flex justify-content-center align-items-center border mt-3" style="height: 420px; width: auto;">
                        <iframe
                            src="{{ asset('storage/proveedor/orden_compra/envios/prorroga_solicitud/' . $consultaProrroga[0]->solicitud) }}"
                            frameborder='0' style="height: 420px; width: 650px;">
                        </iframe>
                    </div>

                    <div class="row mb-4 mt-1">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-light-v mt-3 mr-2 float-right" data-toggle="modal"
                                data-target="#">
                                <i class="fa-solid fa-arrow-left text-9"></i> Atras</button>
                        </div>
                        <div class="col-6">
                            <div class="botones">
                                <a class="btn boton-2 mt-3"
                                    href="{{ route('orden_compra_proveedores.abrir_pagina', [3, 'cer_key_prorroga']) }}"
                                    role="button">
                                    Firmar Prórroga</a>
                            </div>
                        </div>
                    </div>
                @break

                @case('cer_key_prorroga')
                    <div class="col text-center">
                        <p class="text-1 mt-4 m-2">Firma el contrato usando tu eFirma</p>
                    </div>
                    <hr>
                    <form id="frm_firma_cer_key">
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-6 m-4 p-3 border rounded text-center">
                                <p class="text-1"><strong>Archivo .cer</strong></p>
                                <input type="file" id="archivo_cer" name="archivo_cer" class="ocultar" accept=".cer" required
                                    multiple />
                                <div class="border rounded punteado text-center m-3 p-4 integrar_cursor" id="drop_cer"></div>
                                <p class="text-1" id="nombre_cer" required></p>
                            </div>

                            <div class="col-6 m-4 p-3 border rounded text-center">
                                <p class="text-1"><strong>Archivo .key</strong></p>
                                <input type="file" id="archivo_key" name="archivo_key" class="ocultar" accept=".key"
                                    required />
                                <div class="border rounded punteado text-center m-3 p-4 integrar_cursor" id="drop_key"></div>
                                <p class="text-1" id="nombre_key" required></p>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-7">
                                <div class="form-group">
                                    <label for="contrasenia">
                                        <p class="text-1 ml-4">Contraseña</p>
                                    </label>
                                    <input type="password" id="contrasenia" name="contrasenia" class="form-control mx-sm-3"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-light-v mt-3 mr-2 float-right"
                                    onclick="history.back()">
                                    <i class="fa-solid fa-arrow-left text-9"></i>Atras
                                </button>
                            </div>
                            <div class="col-6">
                                <div class="botones">
                                    <button type="submit" class="btn boton-2 mt-3" id="btn_firmar_prorroga">
                                        Firmar Prórroga
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script src="{{ asset('asset/js/drag_drop.js') }}" type="text/javascript"></script>
                @break

                @case('cancelacion')
                    <!-- Ventana mostrada si la URG no acepta la prorroga por x razon y procede a cancelar la orden -->
                    <div class="col text-center">
                        <p class="text-rojo-titulo mt-4 m-2">ID Cancelación: {{ $cancelacion[0]->cancelacion }}</p>
                    </div>
                    <hr>
                    <div class="text-center mt-3">
                        <p class="text-2 font-weight-bold">Motivo de la cancelación:</p>
                        <p class="text-2">{{ $cancelacion[0]->motivo }}</p>
                    </div>
                    <div class="text-center mt-3 mb-4">
                        <p class="text-2 font-weight-bold">Comentarios:</p>
                        <p class="text-2">{{ $cancelacion[0]->descripcion }}</p>
                    </div>
                @break
            @endswitch

        </div>
    </section>

    <!-- #####Ultimos modales -->

    <!-- Modalmodal_confirmar_prorroga-->
    <div class="modal fade" id="modal_confirmar_prorroga" data-backdrop="static" data-keyboard="false" role="dialog"
        aria-labelledby="modal_confirmar_prorrogaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="dialog">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modal_confirmar_prorrogaLabel"><span class="text-rojo">Solicitud de
                            Prórroga</span>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2  d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-triangle-exclamation text-17"></i>
                        </div>
                        <div class="col-10">
                            <p class="text-2">
                                Al generar la solicitud, deberás completar el proceso
                                con tu firma electrónica. Si no lo concluyes, no se
                                podrá generar de nuevo.
                            </p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mt-3">
                        <p class="text-10">¿Quieres generar la solicitud?</p>
                    </div>
                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col text-right">
                            <button type="button" class="btn boton-5 ajustar-btn-si-no" data-dismiss="modal"
                                data-toggle="modal">
                                No
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn boton-12 ajustar-btn-si-no"
                                id="btn_si_confirmar_prorroga">Sí</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal_confirmar_firma_prorroga-->
    <div class="modal fade" id="modal_confirmar_firma_prorroga" tabindex="-1" role="dialog"
        aria-labelledby="modal_confirmar_firma_prorrogaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modal_confirmar_firma_prorrogaLabel">
                        <span class="text-mensaje">Solicitud de Prórroga</span>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2  d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-triangle-exclamation text-17"></i>
                        </div>
                        <div class="col-10">
                            <p class="text-2">
                                Al firmar la solicitud será enviada al comprador y será
                                sujeta a revisión y aprobación.</p>
                            <br>
                            <p class="text-2">Al confirmar la acción no se podrá deshacer.</p>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mt-3">
                        <p class="text-10">¿Confirmas la firma de la solicitud?</p>
                    </div>
                    <div class="row d-flex justify-content-center mt-3">
                        <div class="col text-right">
                            <button type="button" class="btn boton-5" data-dismiss="modal" data-toggle="modal">
                                No
                            </button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn boton-12" id="btn_si_firma_prorroga">
                                Sí
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @routes(['ocp', 'ordenCompraEnvio', 'ordenCompraProrroga'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
@endsection
