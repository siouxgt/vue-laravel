@extends('layouts.proveedores_ficha_productos')

@section('content')
    <div class="row">
        <div class="col">
            <h1 class="p-2 mt-1">
                @if ($filtro)
                    Productos del contrato marco: {{ strtoupper($cm[0]->nombre_cm) }}
                @else
                    Todos los Productos
                @endif
            </h1>
        </div>

    </div>

    <div class="row">
        <div class="col col-sm-12 col-md">
            <h5 class="text-2 p-2 mt-2 text-justify">
                @if ($filtro != '')
                    A continuación encontrarás los productos que has dado de alta en el contrato marco:
                    {{ strtoupper($cm[0]->nombre_cm) }}.
                @else
                    En está página encontrarás todos los productos que has dado de alta.
                @endif
            </h5>
        </div>
        <div class="col col-sm-auto p-2 ml-2 text-justify">

            @if ($filtro != '')
                <a class="btn boton-15 mt-1 col col-sm-auto" href="{{ route('proveedor_fp.abrir_pi', $filtro) }}"><i
                        class="fa-solid fa-plus"></i>Agregar producto</a>
                <a class="btn boton-15 mt-1 col col-sm-auto" href="{{ url('proveedor_fp/abrir_index', 0) }}">Mostrar todos
                    los productos</a>
                <a class="btn boton-16 mt-1 col col-sm-auto" href="{{ route('proveedor_fp.index') }}"><i
                        class="fa-solid fa-arrow-left gold"></i>Regresar</a>
            @else
                <button class="btn boton-16 mt-1 col col-sm-auto" onclick="history.back()"><i
                        class="fa-solid fa-arrow-left gold"></i>Regresar</button>
            @endif
        </div>
    </div>

    <div class="separator mb-3"></div>

    <div class="row">
        @php
            $eProducto = [];
            $eFichaTec = [];
        @endphp
        @for ($i = 0; $i < count($pp); $i++)
            @php
                $eProducto[$i] = $pp[$i]->estatus_producto;
                $eFichaTec[$i] = $pp[$i]->estatus_ficha_tec;
            @endphp

            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 my-2">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-2">{{ $pp[$i]->id_producto }}</p>
                        <div class="separator mt-1"></div>

                        <div class="row">
                            <div class="col-10 ">
                                <h5 class="card-title text-1 mt-3 text-truncate" title="{{ $pp[$i]->cabms }} - {{ strtoupper($pp[$i]->nombre_corto) }}">{{ $pp[$i]->cabms }} - {{ strtoupper($pp[$i]->nombre_corto) }}</h5>
                            </div>
                            <div class="col-2">
                                <div class="btn-group dropright mt-2 offset-11">
                                    <button type="button" class="btn btn-white dropdown-toggle boton-3 bg-transparent"
                                        data-toggle="dropdown" aria-expanded="false">
                                        <span class="fa-solid fa-ellipsis-vertical text-gold">

                                        </span>
                                    </button>
                                    <div class="dropdown-menu bg-white">
                                        <div class="card text-9" style="width: 11rem;">
                                            <ul class="list-group list-group-flush list-unstyled bg-white text-2">
                                                <li class="list-group-item-2 dropdown-header bg-white border-bottom">
                                                    <strong>Configurar producto</strong>
                                                </li>
                                                <li class="list-group-item bg-white border-bottom text-9">
                                                    <a href="{{ route('proveedor_fp.edit', $pp[$i]->id_e) }}">
                                                        <i class="fa-solid fa-pen-to-square gris"></i>Editar</a>
                                                </li>
                                                <input type="hidden" id="mi_id" value="{{ $pp[$i]->id_e }}">
                                                <li class="list-group-item bg-white border-bottom text-9">
                                                    <a href="javascript:void(0)" onclick="eliminar('<?php echo $pp[$i]->id_e; ?>')">
                                                        <i class="fa-regular fa-rectangle-xmark gris"></i>Eliminar</a>
                                                </li>
                                                @if ($pp[$i]->estatus)
                                                    <form method="POST" action="{{ route('proveedor_fp.duplicar') }}"
                                                        id="frm_duplicar[{{ $i }}]">
                                                        @csrf
                                                        <input type="hidden" name="el_id[]" value="{{ $pp[$i]->id_e }}">
                                                        <li class="list-group-item bg-white border-bottom text-9">
                                                            <a href="javascript:void(0)"
                                                                onclick="document.getElementById('frm_duplicar[{{ $i }}]').submit()">
                                                                <i class="fa-regular fa-clone gris"></i>Duplicar</a>
                                                        </li>
                                                    </form>
                                                    <li class="list-group-item bg-white border-bottom text-9">
                                                        <a href="{{ route('proveedor_fp.show', [$pp[$i]->id_e]) }}_"
                                                            title="Ver a detalle la descripción del producto.">
                                                            <i class="fa fa-eye fa-lg gris"></i>Ver</a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator "></div>
                    </div>
                    <div class="card-body">
                        <div class="row d-flex justify-content-between ">
                            <div class="col-xs-4 ">
                                @php
                                    $clase = '';
                                    $notificacion = '';
                                @endphp

                                @if ($pp[$i]->validacion_precio === true || $pp[$i]->validacion_precio === false)
                                    @if ($pp[$i]->validacion_precio === true)
                                        @php
                                            $clase = 'aceptado';
                                            $notificacion = 'Aceptado (precio)';
                                        @endphp
                                    @else
                                        @if ($pp[$i]->validacion_cuenta < 3)
                                            @php
                                                $clase = 'rechasado';
                                                $notificacion = 'Rechazada (precio fuera de rango)';
                                            @endphp
                                        @elseif($pp[$i]->validacion_cuenta === 3)
                                            @php
                                                $clase = 'bloqueado';
                                                $notificacion = 'Bloqueado (precio)';
                                            @endphp
                                        @else
                                            @php
                                                $clase = 'enRevision';
                                                $notificacion = 'En revisión (precio)';
                                            @endphp
                                        @endif
                                    @endif
                                @endif
                                @if (
                                    $pp[$i]->validacion_administracion === true ||
                                        ($pp[$i]->validacion_administracion === false && $pp[$i]->validacion_administracion !== null))
                                    @if ($pp[$i]->validacion_administracion === true)
                                        @php
                                            $clase = 'aceptado';
                                            $notificacion = 'Aceptado (adtvo.)';
                                        @endphp
                                    @else
                                        @php
                                            $clase = 'rechasado';
                                            $notificacion = 'Rechazada (adtvo.)';
                                        @endphp
                                    @endif
                                @endif
                                @if ($pp[$i]->estatus_validacion_tec == true)
                                    @if (
                                        $pp[$i]->validacion_tecnica === true ||
                                            $pp[$i]->validacion_tecnica === false ||
                                            ($pp[$i]->validacion_tecnica === null &&
                                                ($pp[$i]->validacion_administracion === true || $pp[$i]->validacion_administracion === false)))
                                        @if ($pp[$i]->validacion_tecnica === true)
                                            @php
                                                $clase = 'aceptado';
                                                $notificacion = 'Aceptado (val tec.)';
                                            @endphp
                                        @else
                                            @php
                                                $clase = 'rechasado';
                                                $notificacion = 'Rechazada (val tec.)';
                                            @endphp
                                        @endif
                                    @endif
                                @endif

                                @if ($pp[$i]->publicado == true)
                                    @php
                                        $clase = 'publicado';
                                        $notificacion = 'Publicado';
                                    @endphp
                                @endif

                                <p class="card-text"><span class="{{ $clase }}"
                                        id="notificacion_estado_producto">{{ $notificacion }}</span></p>

                            </div>
                            <div class="col-xs-4">
                                <label class="card-text" for="">Activo</label>
                                <label class="switch ml-1 ">
                                    <input type="checkbox" id="estatus_{{ $i }}"
                                        onchange="preguntarCambiar(this, '{{ $pp[$i]->id_e }}')"
                                        @if ($pp[$i]->estatus) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        @php
                            $definido = false;
                            $fotoDefinida = '';
                        @endphp

                        @if ($definido == false && $pp[$i]->foto_uno != null)
                            @php
                                $definido = true;
                                $fotoDefinida = $pp[$i]->foto_uno;
                            @endphp
                        @endif

                        @if ($definido == false && $pp[$i]->foto_dos != null)
                            @php
                                $definido = true;
                                $fotoDefinida = $pp[$i]->foto_dos;
                            @endphp
                        @endif

                        @if ($definido == false && $pp[$i]->foto_tres != null)
                            @php
                                $definido = true;
                                $fotoDefinida = $pp[$i]->foto_tres;
                            @endphp
                        @endif

                        @if ($definido == false && $pp[$i]->foto_cuatro != null)
                            @php
                                $definido = true;
                                $fotoDefinida = $pp[$i]->foto_cuatro;
                            @endphp
                        @endif

                        @if ($definido == false && $pp[$i]->foto_cinco != null)
                            @php
                                $definido = true;
                                $fotoDefinida = $pp[$i]->foto_cinco;
                            @endphp
                        @endif

                        @if ($definido == false && $pp[$i]->foto_seis != null)
                            @php
                                $definido = true;
                                $fotoDefinida = $pp[$i]->foto_seis;
                            @endphp
                        @endif

                        <img class="card-img-top imag-card text-center"
                            src="@if ($definido) {{ asset('storage/img-producto-pfp/' . $fotoDefinida) }} @else {{ asset('asset/img/bac_imag_fondo.svg') }} @endif"
                            alt="Foto...">
                    </div>

                    <div class="card-body">
                        <p class="card-text text-1">
                            @if ($pp[$i]->marca != null)
                                {{ strtoupper($pp[$i]->marca) }}
                            @else
                                <br>
                            @endif
                        </p>
                        <a
                            href="@if ($pp[$i]->estatus) {{ route('proveedor_fp.show', [$pp[$i]->id_e]) }}_ @else {{ route('proveedor_fp.edit', [$pp[$i]->id_e]) }} @endif">
                            <p class="card-text text-truncate nombre-prod gold"
                                title="@if ($pp[$i]->estatus) Clic para ver a detalle la descripción del producto.@else Este producto tiene datos faltantes. Da clic para completar los datos por favor. @endif">
                                @if ($pp[$i]->nombre_producto != null)
                                    {{ strtoupper($pp[$i]->nombre_producto) }}
                                @else
                                    <br>
                                @endif
                            </p>
                        </a>
                        <p class="card-text text-truncate text-2">Tamaño: {{ ucfirst(strtolower($pp[$i]->tamanio)) }}</p>
                        <p class="card-text text-1 mt-3 nombre-prod">
                            <strong>${{ number_format($pp[$i]->precio_unitario, 2) }}</strong> <span class="text-2">x 1
                                {{ $pp[$i]->medida }}</span>
                        </p>
                        <div class="separator mt-2"></div>
                    </div>
                    <div class="card-footer bg-transparent">
                        <div class="row  mt-2">
                            <div class="col d-flex">
                                <p class="text-2">Validación adtva.</p>
                            </div>
                            <div class="d-flex align-items-start">
                                <a href="javascript: void(0)" onclick="modalValAdmin('{{ $pp[$i]->id_e }}')">
                                    <span class="text-8">Ver comentarios</span>
                                </a>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col d-flex">
                                <p class="text-2 ">Validación téc.</p>
                            </div>
                            <div class="d-flex align-items-start">
                                <a href="javascript: void(0)" onclick="modalValTec('{{ $pp[$i]->id_e }}')">
                                    <p class="text-8 text-right">Ver resultados</p>
                                </a>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col d-flex">
                                <p class="text-2">Preguntas</p>
                            </div>
                            <div class="d-flex align-items-start">
                                <a href="@if ($pp[$i]->estatus) {{ route('proveedor_fp.show', [$pp[$i]->id_e]) }}_#punto-encuentro-preguntas @else {{ route('proveedor_fp.edit', [$pp[$i]->id_e]) }} @endif"
                                    id="btn-link-preguntas">
                                    <p class="text-8 text-right">
                                        @if ($pp[$i]->numero_preguntas != 0)
                                            {{ $pp[$i]->numero_preguntas }} preguntas sin responder
                                        @else
                                            No hay preguntas nuevas
                                        @endif
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    <input type="hidden" id="e_producto" value="{{ json_encode($eProducto) }}">
    <input type="hidden" id="e_ficha_tec" value="{{ json_encode($eFichaTec) }}">
@endsection
@section('js')
    @routes(['proveedor_fichap, mensajeProveedor'])

    <script>
        var arrayEProducto = JSON.parse(document.getElementById('e_producto').value),
            arrayEFichaTec = JSON.parse(document.getElementById('e_ficha_tec').value);

        function eliminar(id) {
            let titulo = "¿Está seguro?",
                texto = "¿Desea eliminar su producto registrado? (El proceso no podrá revertirse)";

            Swal.fire({
                title: titulo,
                text: texto,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });
                    $.ajax({
                        type: "DELETE",
                        url: route("proveedor_fp.destroy", id),
                        success: function(response) {
                            if (response.status == 400) {
                                Swal.fire("¡Alerta!", response.message, "warning");
                            } else {
                                Swal.fire("Proceso correcto!", response.message, "success");
                                location.reload()
                            }
                        },
                    });
                }
            });
        }

        function preguntarCambiar(obj, id) {
            let miCheck = $("[id$=" + obj.id + "]"),
                separador = obj.id.split('_');

            if (arrayEProducto[separador[1]] && arrayEFichaTec[separador[1]]) {

                let opcion = "",
                    titulo = "";

                if (!$(miCheck).is(":checked")) {
                    titulo = "Deshabilitar, ¿Está seguro?";
                    opcion = "El producto ya no podrá ser visto en la tienda para su venta.";
                } else {
                    titulo = "Habilitar, ¿Está seguro?";
                    opcion = "¿Está seguro de habilitar el producto?";
                }

                !obj.checked ?
                    miCheck.prop("checked", true) :
                    miCheck.prop("checked", false);

                Swal.fire({
                    title: titulo,
                    text: opcion,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si",
                    cancelButtonText: "No",
                }).then((result) => {
                    if (result.isConfirmed) {
                        cambiar(!obj.checked, id, miCheck, obj.id);
                    }
                });
            } else {
                !obj.checked ?
                    miCheck.prop("checked", true) :
                    miCheck.prop("checked", false);
                Swal.fire("¡No se te permite activar!",
                    "Este producto tiene campos sin llenar, procede a llenarlos para poder activar.", "warning");
            }
        }

        function cambiar(opcion, id, miCheck, objetivo) {
            let formData = new FormData();
            formData.append("emisor", "cambiar");
            formData.append("estatus", opcion);
            formData.append("_method", "PUT");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                url: route("proveedor_fp.update", id),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 400) {
                        Swal.fire("¡Alerta!", response.message, "warning");
                    } else {
                        opcion ? miCheck.prop("checked", true) : miCheck.prop("checked", false);
                    }
                },
            });
        }

        function abrirShow(quien) {
            window.location = route("proveedor_fp.show", quien);
        }

        let modalAbierto = [false, false];
        const modalValAdmin = (id, posicion = 0) => {
            if (modalAbierto[posicion]) return false;
            modalAbierto[posicion] = true;

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: route("proveedor_fp.modal_val_admin", id),
                dataType: "html",
                success: function(resp_success) {
                    $(resp_success)
                        .modal()
                        .on("shown.bs.modal", function() {
                            $("[class='make-switch']").bootstrapSwitch("animate", true);
                            $(".select2").select2({
                                dropdownParent: $('modal_comentarios_val_admin'),
                            });
                        }).on("hidden.bs.modal", function() {
                            $(this).remove();
                            modalAbierto[posicion] = false;
                        });
                },
                error: function(respuesta) {
                    console.log(respuesta);
                },
            });
        }

        const modalValTec = (id, posicion = 1) => {
            if (modalAbierto[posicion]) return false;
            modalAbierto[posicion] = true;

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                url: route("proveedor_fp.modal_val_tec", id),
                dataType: "html",
                success: function(resp_success) {
                    $(resp_success)
                        .modal()
                        .on("shown.bs.modal", function() {
                            $("[class='make-switch']").bootstrapSwitch("animate", true);
                            $(".select2").select2({
                                dropdownParent: $('modal_comentarios_val_tec'),
                            });
                        }).on("hidden.bs.modal", function() {
                            $(this).remove();
                            modalAbierto[posicion] = false;
                        });
                },
                error: function(respuesta) {
                    console.log(respuesta);
                },
            });
        }
    </script>
@endsection
