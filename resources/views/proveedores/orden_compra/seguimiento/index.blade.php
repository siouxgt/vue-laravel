@extends('layouts.proveedores_ficha_productos')
@section('content')
    <!-------------------------Nombre----------------------->
    <div class="row my-5 d-flex justify-content-center">
        <div class="col-8 text-center">
            <h1 class="text-14">{{ $datos[0]->urg_nombre }}</h1>
            <p class="text-1 mb-2">ID ORDEN DE COMPRA: <span class="text-gold ml-2">{{ $datos[0]->orden_compra }}</span></p>
            <a href="javascript: void(0)" onclick="history.back()" class="text-goldoc">
                <i class="fa-solid fa-arrow-left text-gold"></i>
                Regresar
            </a>
        </div>
    </div>
    <!-------------------------Nombre----------------------->

    <hr>

    <!-- -----Alerta 1------- -->
    @if (json_decode($ordenCompraEstatus->alerta_proveedor)->mensaje != '')
        <div class="alert-dismissible fade show d-flex justify-content-center ml-5" role="alert">
            <div class="row d-flex align-items-center alert alert-warning mz-3">
                <div class="bg-amarillo mr-3">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="mr-4">
                    <span
                        class="text-{{ json_decode($ordenCompraEstatus->alerta_proveedor)->css }}">{{ json_decode($ordenCompraEstatus->alerta_proveedor)->mensaje }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <!-- -----Alerta 1------- -->

    <section>

        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-11 col-12 align-self-center border rounded">
                <div class="row p-2 ml-1" style='display:flex; justify-content: center; align-items: center;'>
                    <div class="col-8">
                        <p class="text-2 mt-2">Fecha de compra: {{ $ordenCompraEstatus->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-4">
                        <button type="button" id="btn_mensaje_para_comprador"
                            class="btn bg-white d-flex align-items-center float-right" style="border: 0;"
                            data-toggle="modal" data-target="#MensajeProveedo">
                            <i class="fa-solid fa-message text-mensaje"></i>
                            <p class="text-mensaje ml-2">Enviar mensaje</p>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="col text-center">
                    <p class="text-1  m-2">En las siguientes pantallas podrás dar seguimiento y realizar acciones
                        requeridas.</p>
                </div>
                <br>

                {{-- Confirmacion --}}
                <div class="row p-2 mz-5 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->confirmacion == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="text-15">Confirmación</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->confirmacion_estatus_proveedor)->css }}"
                                    id="estatus_confirmacion">
                                    {{ json_decode($ordenCompraEstatus->confirmacion_estatus_proveedor)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('orden_compra_proveedores.abrir_pagina', 1) }}" method="get">
                                <input
                                    class="btn {{ json_decode($ordenCompraEstatus->confirmacion_boton_proveedor)->css }} ajustar-btn-seguimiento"
                                    type="submit"
                                    value="{{ json_decode($ordenCompraEstatus->confirmacion_boton_proveedor)->mensaje }}">
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Confirmacion --}}

                <hr>

                {{-- Contrato --}}
                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->contrato == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if ($ordenCompraEstatus->contrato == 0) text-1 @else text-15 @endif">Contrato</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->contrato_estatus_proveedor)->css }}"
                                    id="estatus_contrato">
                                    {{ json_decode($ordenCompraEstatus->contrato_estatus_proveedor)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('orden_compra_proveedores.abrir_pagina', [2, 'contrato_pdf']) }}"
                                method="get">
                                <input
                                    class="btn {{ json_decode($ordenCompraEstatus->contrato_boton_proveedor)->css }} ajustar-btn-seguimiento"
                                    type="submit"
                                    value="{{ json_decode($ordenCompraEstatus->contrato_boton_proveedor)->mensaje }}"
                                    @if (json_decode($ordenCompraEstatus->contrato_estatus_proveedor)->mensaje === 'En espera') disabled @endif>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Contrato --}}

                <hr>

                {{-- Envío --}}
                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->envio == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if ($ordenCompraEstatus->envio == 0) text-1 @else text-15 @endif">Envío</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->envio_estatus_proveedor)->css }}"
                                    id="estatus_envio">
                                    {{ json_decode($ordenCompraEstatus->envio_estatus_proveedor)->mensaje }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('orden_compra_proveedores.abrir_pagina', [3, 'index']) }}"
                                method="get">
                                <input
                                    class="btn {{ json_decode($ordenCompraEstatus->envio_boton_proveedor)->css }} ajustar-btn-seguimiento"
                                    type="submit"
                                    value="{{ json_decode($ordenCompraEstatus->envio_boton_proveedor)->mensaje }}"
                                    @if ($ordenCompraEstatus->envio === 0) disabled @endif>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Envío --}}

                <hr>

                {{-- Sustitucion // Entrega --}}
                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->entrega == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if ($ordenCompraEstatus->entrega == 0) text-1 @else text-15 @endif">Sustitución</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->entrega_estatus_proveedor)->css }}"
                                    id="estatus_entrega">
                                    {{ json_decode($ordenCompraEstatus->entrega_estatus_proveedor)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('orden_compra_proveedores.abrir_pagina', [4, 'index']) }}"
                                method="get">
                                <input
                                    class="btn {{ json_decode($ordenCompraEstatus->entrega_boton_proveedor)->css }} ajustar-btn-seguimiento"
                                    type="submit"
                                    value="{{ json_decode($ordenCompraEstatus->entrega_boton_proveedor)->mensaje }}"
                                    @if ($ordenCompraEstatus->entrega === 0) disabled @endif>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Sustitucion --}}

                <hr>

                {{-- Facturacion --}}
                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->facturacion == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if ($ordenCompraEstatus->facturacion == 0) text-1 @else text-15 @endif">Facturación</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->facturacion_estatus_proveedor)->css }}"
                                    id="estatus_facturacion">
                                    {{ json_decode($ordenCompraEstatus->facturacion_estatus_proveedor)->mensaje }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('orden_compra_proveedores.abrir_pagina', [5, 'index']) }}"
                                method="get">
                                <input
                                    class="btn {{ json_decode($ordenCompraEstatus->facturacion_boton_proveedor)->css }} ajustar-btn-seguimiento"
                                    type="submit"
                                    value="{{ json_decode($ordenCompraEstatus->facturacion_boton_proveedor)->mensaje }}"
                                    @if ($ordenCompraEstatus->facturacion === 0) disabled @endif>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Facturacion --}}

                <hr>

                {{-- Pago --}}
                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->pago == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if ($ordenCompraEstatus->pago == 0) text-1 @else text-15 @endif">Pago</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->pago_estatus_proveedor)->css }}"
                                    id="estatus_pago">
                                    {{ json_decode($ordenCompraEstatus->pago_estatus_proveedor)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('orden_compra_proveedores.abrir_pagina', 6) }}" method="get">
                                <input
                                    class="btn {{ json_decode($ordenCompraEstatus->pago_boton_proveedor)->css }} ajustar-btn-seguimiento"
                                    type="submit"
                                    value="{{ json_decode($ordenCompraEstatus->pago_boton_proveedor)->mensaje }}"
                                    @if ($ordenCompraEstatus->pago === 0) disabled @endif>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Pago --}}

                <hr>

                {{-- Encuesta --}}
                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->evaluacion == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if ($ordenCompraEstatus->evaluacion == 0) text-1 @else text-15 @endif">Evaluación</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->evaluacion_estatus_proveedor)->css }}"
                                    id="estatus_encuesta">
                                    {{ json_decode($ordenCompraEstatus->evaluacion_estatus_proveedor)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <form action="{{ route('orden_compra_proveedores.abrir_pagina', 7) }}" method="get">
                                <input
                                    class="btn {{ json_decode($ordenCompraEstatus->evaluacion_boton_proveedor)->css }} ajustar-btn-seguimiento"
                                    type="submit"
                                    value="{{ json_decode($ordenCompraEstatus->evaluacion_boton_proveedor)->mensaje }}"
                                    @if ($ordenCompraEstatus->evaluacion === 0) disabled @endif>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Encuesta --}}

                <hr>

                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i
                                    class="fa-solid fa-check @if ($ordenCompraEstatus->finalizada == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if (json_decode($ordenCompraEstatus->evaluacion_estatus_proveedor)->mensaje == 'Comentarios enviados') text-verde @else text-gris @endif">Finalizada
                                </p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @routes(['ocp'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
@endsection
