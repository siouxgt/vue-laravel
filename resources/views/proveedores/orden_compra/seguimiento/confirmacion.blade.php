@extends('layouts.proveedores_ficha_productos')

@section('content')

    @include('proveedores.orden_compra.seguimiento.encabezado_interno')
    <hr>

    <section class="row justify-content-center">
        <div class="col-md-5 col-sm-11 align-self-center border rounded">
            @switch($seccion)
                @case(0)
                    <!-- Cancelado por la URG -->
                    <div class="col text-center">
                        <p class="text-rojo-titulo m-2">ID Cancelación: {{ $cancelacion[0]->cancelacion }}</p>
                    </div>
                    <hr>
                    <div class="col text-center">
                        <p class="text-1 font-weight-bold">Motivo de la cancelación:</p>
                        <p class="text-1">{{ $cancelacion[0]->motivo }}</p>
                    </div>
                    <div class="col text-center mt-4 mb-5">
                        <p class="text-1 font-weight-bold">Comentarios:</p>
                        <p class="text-1">{{ $cancelacion[0]->descripcion }}</p>
                    </div>
                @break

                @case(1)
                    <!-- Rechazado por el proveedor -->
                    <div class="col text-center">
                        <p class="text-rojo-titulo m-2">ID Rechazo: {{ $rechazo[0]->rechazo }}</p>
                    </div>
                    <hr>
                    <div class="col text-center">
                        <p class="text-1 font-weight-bold">Motivo del rechazo:</p>
                        <p class="text-1">{{ $rechazo[0]->motivo }}</p>
                    </div>
                    <div class="col text-center mt-4 mb-5">
                        <p class="text-1 font-weight-bold">Comentarios:</p>
                        <p class="text-1">{{ $rechazo[0]->descripcion }}.</p>
                    </div>
                @break

                @case(2)
                    <!-- Formulario de opciones, En espera... -->
                @case(3)
                    <!-- Formulario de que muestra si se ha confirmado la compra de los productos y descarga de acuse -->
                    <style>
                        .swal2-styled.swal2-cancel {
                            background-color: #dadada;
                            color: #98989a;
                        }

                        .swal2-icon.swal2-warning {
                            border-color: #9E2241;
                            color: #9E2241;
                        }
                    </style>
                    <div class="col text-center">
                        <p class="text-1 m-2">
                            @if ($seccion === 2)
                                En esta pantalla selecciona los productos que confirmas entregar.
                            @else
                                <strong>Fecha de entrega: </strong>{{ $ocp[0]->fecha_entrega->format('d/m/Y') }}
                            @endif
                        </p>
                    </div>
                    <hr>
                    <div class="col text-center">
                        @if ($seccion === 2)
                            <p class="text-14">1. Selecciona los productos a entregar</p>
                            <button type="button" class="btn boton-3a mt-3" id="btn_seleccionar_productos_entregar">Seleccionar
                                productos</button>
                        @else
                            <p class="text-14">1. Productos confirmados: {{ $contProductoAceptados }} de {{ $countTodosProducto }}
                            </p>
                            <a class="text-5" href="{{ route('orden_compra_proveedores.acuse_confirmada') }}">
                                <i class="fa-solid fa-file-invoice text-5"></i><strong>Acuse</strong>
                            </a>
                        @endif
                    </div>
                    <hr>
                    <div class="col text-center mt-4 mb-5">
                        @if ($seccion === 2)
                            <p class="text-1 ">Para rechazar la Orden de compra completa, da clic en el siguiente botón.</p>
                            <button type="button" class="btn boton-3a mt-3" id="btn_modal_rechazar_orden">Rechazar Orden</button>
                        @else
                            <p class="text-14">2. Productos rechazados: {{ $countTodosProducto - $contProductoAceptados }}</p>
                            @if ($contProductoRechazados === 0)
                                <button type="button" class="btn btn-link" disabled>Ver productos rechazados</button>
                            @else
                                <p><a href="javascript: void(0)" id="btn_ver_productos_rechazados" class="text-5">Ver productos
                                        rechazados</a></p>
                            @endif
                        @endif
                    </div>
                    <hr>
                    <div class="col text-center mt-4 mb-5">
                        <p class="text-14 ">¿Cambiaron tus datos fiscales o legales?</p>
                        <p class="text-1">Cámbialos en
                            <a href="javascript: void(0)" data-toggle="modal" data-target="#PadronProveedores">
                                <span class="text-3 font-weight-bold">
                                    <u>Padrón de Proveedores</u>
                                </span>
                            </a>
                        </p>
                        <br>
                        <p class="text-1">El representante legal registrado en el Padrón de Proveedores, es el mismo que estará facultado para
                            firma de los contratos pactados con la URG</p>
                        <button type="button" class="btn boton-3a mt-3" id="btn_modal_datos_legales_proveedor">Revisar
                            datos</button>
                    </div>
                @break
            @endswitch
        </div>
    </section>

    <!-- ModalPadronProveedores (inicio)-->
    <div class="modal fade" id="PadronProveedores" data-backdrop="static" data-keyboard="false" role="dialog"
        aria-labelledby="PadronProveedoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-rojo" id="PadronProveedoresLabel">Actualizar datos en Padrón de Proveedores
                    </h5>
                    <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2  d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-triangle-exclamation text-17"></i>
                        </div>
                        <div class="col-10">
                            <p class="text-2">
                                Si actualizas tus datos en Padrón de Proveedores, tendrás que confirmar la información en tu
                                Matriz de
                                Escalamiento antes de firmar el contrato. De lo contrario no se reflejará el cambio.</p>
                            <br>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center mt-3">
                        <button type="button" class="btn boton-12" id="btn_ir_padron"
                            title="Ir a tianguis digital para modificar tus datos.">Ir al Padrón de Proveedores</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ModalPadronProveedores (fin)-->

@endsection

@section('js')
    @routes(['ocp'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            $(document).on("click", `#btn_ir_padron`, function(e) {
                e.preventDefault();
                $('#PadronProveedores').modal('hide')
                window.open("https://tianguisdigital.finanzas.cdmx.gob.mx/", '_blank');
            });

        });
    </script>
@endsection
