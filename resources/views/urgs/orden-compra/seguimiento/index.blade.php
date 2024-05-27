@extends('layouts.urg')
    @section('content')

        @include('urgs.orden-compra.seguimiento.encabezado')
        <div class="alert-dismissible fade show d-flex justify-content-center ml-5" role="alert">
            <div class="row d-flex align-items-center alert {{ json_decode($ordenCompraEstatus->alerta_urg)->css }} mz-3">
                <div class="mr-1">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="mr-4">
                    <strong class="text-{{ json_decode($ordenCompraEstatus->alerta_urg)->css }}">{{ json_decode($ordenCompraEstatus->alerta_urg)->mensaje }}</strong>
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <div class="row p-2 ml-1">
                    <div class="col-8">
                         <p class="text-2 mt-2">Fecha de compra: {{ $ordenCompraEstatus->created_at->format('d/m/Y')  }}</p>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn bg-white d-flex align-items-center float-right">
                            <i class="fa-solid fa-message red"></i>
                            <p class="text-mensaje ml-2">Enviar mensaje</p>
                        </button>
                    </div>
                </div>
                <hr>
                <div class="col text-center">
                    <p class="text-1  m-2">En las siguientes pantallas podrás dar seguimiento a tu compra y realizar acciones requeridas.</p>
                </div>
                <br>
                <div class="row p-2 mz-5 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->confirmacion == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->confirmacion == 2) text-verde @else text-1 @endif">Confirmación</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->confirmacion_estatus_urg)->css }}">{{ json_decode($ordenCompraEstatus->confirmacion_estatus_urg)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <a class="btn {{ json_decode($ordenCompraEstatus->confirmacion_boton_urg)->css }} ajustar-btn-seguimiento" href="{{ route('orden_compra_urg.confirmacion') }}">{{ json_decode($ordenCompraEstatus->confirmacion_boton_urg)->mensaje }}</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->contrato == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->contrato == 2) text-verde @else text-1 @endif">Contrato</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->contrato_estatus_urg)->css }}">{{ json_decode($ordenCompraEstatus->contrato_estatus_urg)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <a class="btn {{ json_decode($ordenCompraEstatus->contrato_boton_urg)->css }} ajustar-btn-seguimiento" @if($ordenCompraEstatus->contrato) href="{{ route('orden_compra_urg.alta_contrato_1') }}" @endif>{{ json_decode($ordenCompraEstatus->contrato_boton_urg)->mensaje }}</a>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->envio == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->envio == 2) text-verde @else text-1 @endif">Envío</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->envio_estatus_urg)->css }}">{{ json_decode($ordenCompraEstatus->envio_estatus_urg)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                             <a class="btn {{ json_decode($ordenCompraEstatus->envio_boton_urg)->css }} ajustar-btn-seguimiento" @if($ordenCompraEstatus->envio) href="{{ route('orden_compra_urg.envio') }}" @endif>{{ json_decode($ordenCompraEstatus->envio_boton_urg)->mensaje }}</a>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->entrega == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->entrega == 2) text-verde @else text-1 @endif">Sustitución</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->entrega_estatus_urg)->css }}">{{ json_decode($ordenCompraEstatus->entrega_estatus_urg)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <a class="btn {{ json_decode($ordenCompraEstatus->entrega_boton_urg)->css }} ajustar-btn-seguimiento" @if($ordenCompraEstatus->entrega) href="{{ route('orden_compra_urg.sustitucion') }}" @endif>{{ json_decode($ordenCompraEstatus->entrega_boton_urg)->mensaje }}</a>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->facturacion == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->facturacion == 2) text-verde @else text-1 @endif">Facturación</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->facturacion_estatus_urg)->css }}">{{ json_decode($ordenCompraEstatus->facturacion_estatus_urg)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <a class="btn {{ json_decode($ordenCompraEstatus->facturacion_boton_urg)->css }} border ajustar-btn-seguimiento" @if($ordenCompraEstatus->facturacion) href="{{ route('orden_compra_urg.facturacion') }}" @endif>{{ json_decode($ordenCompraEstatus->facturacion_boton_urg)->mensaje }}</a>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->pago == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->pago == 2) text-verde @else text-1 @endif">Pago</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->pago_estatus_urg)->css }}">{{ json_decode($ordenCompraEstatus->pago_estatus_urg)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                             <a class="btn {{ json_decode($ordenCompraEstatus->pago_boton_urg)->css }} border ajustar-btn-seguimiento" @if($ordenCompraEstatus->pago) href="{{ route('orden_compra_urg.pago') }}" @endif>{{ json_decode($ordenCompraEstatus->pago_boton_urg)->mensaje }}</a>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->evaluacion == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->evaluacion == 2) text-verde @else text-1 @endif">Encuesta de satisfacción</p>
                            </div>
                            <div class="col-1 sin_padding"></div>
                            <div class="col-11 sin_padding">
                                <p class="{{ json_decode($ordenCompraEstatus->evaluacion_estatus_urg)->css }}">{{ json_decode($ordenCompraEstatus->evaluacion_estatus_urg)->mensaje }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-end">
                            <a class="btn {{ json_decode($ordenCompraEstatus->evaluacion_boton_urg)->css }} border ajustar-btn-seguimiento" @if($ordenCompraEstatus->evaluacion) href="{{ route('orden_compra_urg.evaluacion') }}" @endif>{{ json_decode($ordenCompraEstatus->evaluacion_boton_urg)->mensaje }}</a>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row p-2 ml-1">
                    <div class="col-8">
                        <div class="row">
                            <div class="col-1 sin_padding">
                                <i class="fa-solid fa-check @if($ordenCompraEstatus->finalizada == 2) text-verde @else text-gris @endif float-right mt-1"></i>
                            </div>
                            <div class="col-11 sin_padding">
                                <p class="@if($ordenCompraEstatus->finalizada != 0) text-verde @else text-1 @endif">Finalizada</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>   
    @endsection