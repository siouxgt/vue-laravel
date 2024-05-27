@extends('layouts.proveedores_ficha_productos')

@section('content')
    <div class="row">
        <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
            <a href="javascript: void(0)" onclick='history.back()' class="text-gold ml-5"><i
                    class="fa-solid fa-arrow-left text-gold ml-1"></i> Regresar</a>
            <a class="nav-item nav-link active ml-3 text-1" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                role="tab" aria-controls="nav-home" aria-selected="true">Orden compra</a>
        </div>

        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            <div class="row  justify-content-md-center">
                <div class="col-sm-12 col-md-12 text-center mt-3">
                    <p class="text-10">{{ $datos[0]->urg_nombre }}</p>
                    <p class="text-1 mt-3">ID ORDEN DE COMPRA: <span class="text-gold">{{ $datos[0]->orden_compra }}</span>
                    </p>
                </div>
                <div class="col-md-12 text-center my-4">
                    <button type="button" class="btn boton-3a" id="btn_comentario_sobre_urg" data-toggle="modal"
                        data-target="#ComentariosSobre">Comentarios sobre URG</button>
                </div>
                <div class="col-md-12 text-center">
                    <p class="text-14">Total compra: ${{ number_format($suma_total, 2) }}</p>
                </div>
                <div class="my-4 col-md-7 col-sm-12">
                    <div class="row justify-content-md-center">
                        <div class="col-md-5 col-sm-12 text-center">
                            <p class="text-1"><strong>Entrega: </strong>
                                @if ($datos[0]->fecha_entrega != null)
                                    {{ $datos[0]->fecha_entrega }}
                                @else
                                    Aún no definido
                                @endif
                            </p>
                        </div>
                        <div class="col-md-5 col-sm-12 text-center">

                            <p class="text-1">
                                <strong>
                                    <i class="fa-regular fa-clock text-rojo"></i>
                                    Restan:
                                </strong>
                                @if ($datos[0]->dias != null)
                                    @if ($datos[0]->finalizada != 2)
                                        @if ($datos[0]->envio != 2)
                                            @if (\Carbon\Carbon::now()->gt($datos[0]->dias))
                                                Retraso de {{ \Carbon\Carbon::parse($datos[0]->dias)->diffInDays(now()) }} días
                                            @else
                                                {{ \Carbon\Carbon::parse($datos[0]->dias)->diffInDays(now()) }} días
                                            @endif
                                        @else
                                            Producto entregado
                                        @endif
                                    @else
                                        Ha concluido la orden de compra
                                    @endif
                                @else
                                    Aún no definido
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col col-md-5 col-sm-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                <p class="text-1"><strong>Etapa</strong></p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                <p><span class="confirmacion px-2">{{ $datos[0]->etapa }}</span></p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                <p class="text-1"><strong>Estatus</strong></p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                <p><span class="etapa-{{ $datos[0]->css }} px-2">{{ $datos[0]->estatus }}</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col col-md-3 col-sm-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                <p class="text-1"><strong>Acuse</strong></p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                @if (json_decode($datos[0]->confirmacion_estatus_proveedor)->mensaje === 'Se aceptó Orden completa' ||
                                        json_decode($datos[0]->confirmacion_estatus_proveedor)->mensaje === 'No se aceptaron todos los productos')
                                    <a class="text-5" href="{{ route('orden_compra_proveedores.acuse_confirmada') }}">
                                        <i class="fa-solid fa-receipt text-gold"></i>
                                    </a>
                                @else
                                    <i class="fa-solid fa-receipt text-gold"></i>
                                @endif
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                <p class="text-1"><strong>Contrato</strong></p>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 text-center">
                                @if ($datos[0]->contrato_pedido != null || $datos[0]->contrato_pedido != '')
                                    <a href="{{ asset('storage/contrato-pedido/contrato_pedido_' . $datos[0]->contrato_pedido . '.pdf') }}" target="_blank">
                                        <i class="fa-solid fa-file-contract text-gold"></i>
                                    </a>
                                @else
                                    <i class="fa-solid fa-file-contract text-1"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto col-sm-12 text-center" style="top: -.3rem;">
                        <a href="{{ url('/orden_compra_proveedores/seguimiento', $datos[0]->id_e) }}">
                            <p class="text-5 font-weight-bold" style="font-size: 1.2rem;">Seguimiento<i
                                    class="fa-solid fa-pen-to-square text-gold-2"></i></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>

    <div class="tab-content col-9 mx-auto d-block">
        <div class="table-responsive">
            <table class="table table-hover jtable_center nowrap" style="width:100%" id="tbl_productos_orden_compra">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="sortable text-1 tab-cent">CABMSCDMX</th>
                        <th scope="col" class="sortable text-1">Producto</th>
                        <th scope="col" class="sortable tab-cent text-1">Cantidad</th>
                        <th scope="col" class="sortable tab-cent text-1">Total</th>
                        <th scope="col" class="sortable tab-cent text-1">Confirmación</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('js')
    @routes(['ocp'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
@endsection
