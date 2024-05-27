@extends('layouts.proveedores_ficha_productos')
@section('content')
    <div class="row m-3">

        <div class="col-md-6 col-lg-4 mt-1 mb-3">
            <div class="row">
                <div class="col-12">
                    <div class="carousel slide" data-ride="carousel" style="padding: 0%;">
                        <div class="carousel-inner rounded">
                            <div class="carousel-item" style="background-color: #912e42;">
                                <img class="d-block w-100" src="{{ asset('asset/img/home_proveedor_2.svg') }}"
                                    alt="Subastas" style="width: 100%; height: auto;">
                            </div>
                            <div class="carousel-item active" style="background-color: #f8f9fa;">
                                <img class="d-block w-100" src="{{ asset('asset/img/home_proveedor_3.svg') }}"
                                    alt="Hola proveedor" style="width: 100%; height: auto;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-18">Fecha de consulta: {{ now()->translatedFormat('l d \d\e F \d\e\l Y') }}</p>
                </div>
            </div>
        </div>

        <style>
            .carousel {
                position: relative;
                height: 12rem;
            }
        </style>

        <div class="col-md-6 col-lg-4 mt-1 mb-3">
            <div class="row">
                <div class="col-12 rounded"
                    style="background-image: url({{ asset('asset/img/home_proveedor_1.svg') }}); background-repeat: no-repeat; background-position: right bottom, left top; background-color: #235B4E; padding: 0;">
                    <p class="text-7 text-center mt-2 mr-5">Participas en</p>
                    <p class="num-titulo-arena text-center mr-5">{{ $totalContratos }}</p>
                    <p class="text-7 text-center mr-5">Contrato{{ $totalContratos > 1 ? 's' : '' }} Marco</p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center mt-3" style="text-overflow: ellipsis;">
                    <form action="{{ route('contrato_proveedor.index_proveedor') }}">
                        <input class="btn boton-15" type="submit" value="Conoce todos los Contratos Marco">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-2 mt-1 mb-3">
            <div class="row">
                <div class="col-12 rounded py-2" style="background-color: #DDC9A3;">
                    <div class="text-center">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $evaluacion[0]->promedio_evaluacion)
                                <i class="fa-solid fa-star estrella-home-activo"></i>
                            @else
                                <i class="fa-solid fa-star"></i>
                            @endif
                        @endfor
                    </div>

                    <p class="text-15 text-center"><strong>Mi evaluación</strong></p>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-12 rounded py-2" style="background-color: #DDC9A3;">
                    <div class="text-center">
                        <a href="https://tianguisdigital.finanzas.cdmx.gob.mx/" target="_blank"
                            title="Ir a Padrón de Proveedores.">
                            <span class="text-15 text-center ">Padrón de Proveedores</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col rounded py-2" style="background-color: #DDC9A3;">
                    <div class="text-center">
                        <a href="{{ route('proveedor.abrir_me') }}" title="Ver mis contactos">
                            <span class="text-15 text-center ">Mis contactos</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col rounded py-2" style="background-color: #DDC9A3;">
                    <div class="text-center">
                        <a href="{{ route('proveedor_fp.abrir_index', 0) }}" title="Ver todos mis productos">
                            <span class="text-15 text-center ">Ver todos mis productos</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-2 pl-0 mt-1 mb-3">
            <div class="rounded" style="background-color: #235B4E; width: 100%; height: 13rem;">
                <div class="row">
                    <div class="col-12 text-center mt-2 ml-2">
                        <p class="text-7"><strong>¿Tienes más productos o quieres participar en otros Contratos
                                Marco?</strong></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center mt-3 ml-1">
                        <button type="button" class="btn boton-16 text-truncate" style="font-size: .8rem;"
                            id="btn_enviar_mensaje">Envíanos un
                            mensaje</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-4 mt-2">
            <div class="card bg-white border">
                <div class="card-header d-flex p-2" style="background-color: #DDC9A3;">
                    <div class="col-7">
                        <p class="text-10"><strong>Ventas</strong></p>
                    </div>
                    <div class="col-5">
                        <a href="{{ url('orden_compra_proveedores') }}" class="text-9 float-right mt-1" title="Ir a ordenes de compra"><u>Órdenes de
                                compra</u></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center ml-2">
                        <div class="col-lg-5 col-md-12 text-center rounded p-2 mt-3" style="background-color: #912e42;">
                            <p class="text-7 text-center mt-3 mb-4" style="letter-spacing: -1px;">Número de ventas</p>
                            <p class="num-general-arena text-center mt-2 mb-4">{{ $totalVendidos }}</p>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-lg-5 col-md-12 text-center rounded p-2 mt-3" style="background-color: #912e42;">
                            <p class="text-7 text-center mt-3 mb-4" style="letter-spacing: -1px;">Monto total de ventas
                                con
                                I.V.A
                            </p>
                            <p class="num-general-arena text-center text-truncate mt-2 mb-4">
                                ${{ number_format($totalConIva, 2) }}</p>
                        </div>
                    </div>

                    <div class="row justify-content-center mb-4">
                        <div class="col-lg-5 col-md-12">
                            <p class="text-24 mt-3">Ordenes pendientes por confirmar</p>
                            <p class="num-general-arena ml-3">{{ $totalPendientesConfirmar }}</p>
                            <p class="text-2 mt-2">Tienes <strong>24 horas para confirmar</strong> tu orden de lo contrario
                                se cancelará.</p>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-lg-5 col-md-12">
                            <p class="text-24 mt-3 mb-2">Contratos por firmar</p>
                            <p class="num-general-gris ml-3 mt-4">{{ $totalPendientesFirmar }}</p>
                            <p class="text-2 mt-2 mt-3">Tienes 48 horas para firmar el contrato.
                                Los retrasos pueden generar incidencias.</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-8 mt-2">
            <div class="card bg-white border">
                <div class="card-header d-flex p-2" style="background-color: #DDC9A3;">
                    <div class="col-9">
                        <p class="text-15" style="font-size: 1.3rem;"><strong>Información sobre tus productos</strong></p>
                    </div>
                    <div class="col-3">
                        <a href="{{ route('proveedor_fp.abrir_index', 0) }}"
                            class="text-9 float-right mt-1" title="Ver todos mis productos"><u>Productos</u></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 bg-light">
                        <p class="text-2 p-2">
                            Tus productos pasarán por tres verificaciones (técnica, administrativa, económica) antes de ser
                            publicados. La validación económica te permite hasta tres intentos para
                            cambiar antes de ser bloqueada temporalmente la ficha. Revisa tus
                            <a href="{{ url('mensaje_proveedor') }}" class="font-weight-bold text-gold"
                                title="Ir a mensajes">mensajes</a>
                            o tus
                            <a href="{{ route('proveedor_fp.abrir_index', 0) }}" class="font-weight-bold text-gold"
                                title="Ver tus productos">fichas de productos</a>
                            para conocer el estatus de tus fichas.
                        </p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4 col-sm-12">
                            <p class="text-24">Formularios activos</p>
                            <p class="num-general-arena ml-3">{{ $totalFormulariosActivos }}</p>
                            <p class="text-2 mt-2"><a href="{{ url('proveedor_fp/') }}"
                                    class="text-gold font-weight-bold" title="Ver formularios">Formularios</a> disponibles
                                para agregar tus productos.</p>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <p class="text-24">Enviados a revisión</p>
                            <p class="num-general-gris ml-3">{{ $estatusVerificacion->total_revision }}</p>
                            <p class="text-2 mt-2"><a href="{{ route('proveedor_fp.abrir_index', [0, 'revision']) }}"
                                    class="text-gold font-weight-bold" title="Ver productos en revisión">Productos</a> en revisión
                                por el equipo técnico o por el administrador.</p>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <p class="text-24">Publicados</p>
                            <p class="num-general-verde ml-3">{{ $estatusVerificacion->total_publicados }}</p>
                            <p class="text-2 mt-2"><a href="{{ route('proveedor_fp.abrir_index', [0, 'publicados']) }}"
                                    class="text-gold font-weight-bold" title="Ver productos publicados">Productos</a> que ya están
                                disponibles en la Tienda en línea.</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4 col-sm-12">
                            <p class="text-25">Fichas por concluir</p>
                            <p class="num-general-gris ml-3">{{ $estatusVerificacion->total_concluir }}</p>
                            <p class="text-2 mt-2"><a href="{{ route('proveedor_fp.abrir_index', [0, 'concluir']) }}"
                                    class="text-gold font-weight-bold" title="Ver fichas">Fichas de productos</a> sin
                                enviar a revisión.<span class="font-weight-bold"> Debes concluir la carga para evitar
                                    incidencias.</span></p>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <p class="text-25">Bloqueo temporal</p>
                            <p class="num-general-rojo ml-3">{{ $estatusVerificacion->total_bloqueados }}</p>
                            <p class="text-2 mt-2"><a href="{{ route('proveedor_fp.abrir_index', [0, 'bloqueo']) }}"
                                    class="text-gold font-weight-bold" title="Ver productos">Productos</a> que no
                                pasaron la validación económica.<span class="font-weight-bold"> Revisa el precio y
                                    bájalo.</span></p>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <p class="text-25">Fichas rechazadas</p>
                            <p class="num-general-gris ml-3">{{ $estatusVerificacion->total_rechazadas }}</p>
                            <p class="text-2 mt-2">
                                <a href="{{ route('proveedor_fp.abrir_index', [0, 'rechazadas']) }}"
                                    class="text-gold font-weight-bold" title="Ver productos">Productos</a>
                                que no pasaron algunas de las validaciones.
                                <a href="{{ url('mensaje_proveedor') }}" title="Ir a mensajes" class="text-gold">
                                    Revisa tus mensajes
                                </a>
                                para conocer el motivo y
                                hacer las correcciones.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-4 mt-2">
            <div class="card bg-white border">
                <div class="card-header d-flex p-2" style="background-color: #DDC9A3;">
                    <p class="text-10"><strong>Posibles ventas</strong></p>
                </div>
                <div class="card-body">
                    <div class="col-12 bg-light">
                        <p class="text-2 p-2">
                            Verifica frecuentemente tu stock para garantizar la entrega a tiempo. Revisa que los datos de tu
                            Representante legar y domicilio fiscal estén al día.
                        </p>
                    </div>
                    <div class="row mt-3 p-3">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <p class="text-24">Favoritos</p>
                            <p class="num-general-gris ml-3">{{ $totalFavoritos }}</p>
                            <p class="text-2 mt-2 p-2">Productos marcados por las URG como favoritos.</p>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <p class="text-24">Preguntas</p>
                            <p class="num-general-gris ml-3">{{ $totalPreguntas }}</p>
                            <p class="text-2 mt-2">Has recibido estas preguntas.
                                <a href="{{ url('mensaje_proveedor') }}" title="Ir a mensajes" class="text-gold">
                                    Ve a tus mensajes
                                </a>
                                para contestar.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-4 p-3">
                            <p class="text-24">Total de productos vendidos</p>
                            <p class="num-general-gris ml-3">{{ $totalCambs }}</p>
                            <p class="text-2 mt-2">Total de productos que has vendido. Para conocer el detalle, entra a la
                                sección
                                <a class="text-gold font-weight-bold" href="{{ url('orden_compra_proveedores') }}" title="Ir a ordenes de compra">
                                    Órdenes de compra.</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-8 mt-2">
            <div class="card bg-white">
                <div class="card-header border d-flex p-2" style="background-color: #DDC9A3;">
                    <div class="col-9">
                        <p class="text-15" style="font-size: 1.3rem;"><strong>Últimos 5 mensajes recibidos</strong></p>
                    </div>
                    <div class="col-3">
                        <a href="{{ url('mensaje_proveedor') }}" title="Ir a mensajes" class="text-9 float-right mt-1">
                            <u>Bandeja de mensajes</u>
                        </a>
                    </div>
                </div>
                <div class="card-body" style="padding: 0;">
                    <ul class="list-group list-group-flush">
                        @foreach ($ultimosMensajes as $mensaje)
                            <li class="list-group-item border bg-white text-1">{{ $mensaje->asunto }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @routes(['proveedor'])
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            $(document).on("click", `#btn_enviar_mensaje`, function(e) {
                e.preventDefault();
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: route("proveedor.modal_enviar_mensaje"),
                    dataType: "html",
                    success: function(resp_success) {
                        $(resp_success)
                            .modal()
                            .on("shown.bs.modal", function() {
                                $("[class='make-switch']").bootstrapSwitch("animate", true);
                                $(".select2").select2({
                                    dropdownParent: $("#modal_enviar_mensaje"),
                                });

                                agregarEscuchaCantidadCaracteres('asunto',
                                    'cantidad_caracteres_asunto');
                                agregarEscuchaCantidadCaracteres('mensaje',
                                    'cantidad_caracteres_mensaje');

                                let campoInput = $('#imagen');
                                $("#mostrar-ocultar-input").change(function() {
                                    if ($(this).is(':checked')) {
                                        campoInput.prop("required", true);
                                        campoInput.show();
                                    } else {
                                        campoInput.prop("required", false);
                                        campoInput.hide();
                                        campoInput.removeClass('is-invalid');
                                        $('imagen-error').remove();
                                    }
                                });
                            })
                            .on("hidden.bs.modal", function() {
                                $(this).remove();
                            });
                    },
                    error: function(respuesta) {
                        console.log(respuesta);
                    },
                });
            });
        });

        $(document).on("click", "#btn_enviar", function(e) {
            e.preventDefault();
            console.log("Enviar");

            if (!formValidate("#frm_enviar_mensaje")) return false;
            let formData = new FormData($("#frm_enviar_mensaje").get(0));
            let btnEnviar = $('#btn_enviar').attr('disabled', true);
            btnEnviar.text("Enviando...");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "POST",
                url: route("proveedor.guardar_mensaje"),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 400) {
                        btnEnviar.text("Enviar");
                        btnEnviar.attr('disabled', false);

                        let mensaje = "<ul>";
                        $.each(response.errors, function(key, err_value) {
                            mensaje += "<li>" + err_value + "</li>";
                        });

                        Swal.fire({
                            title: "No se puede continuar",
                            html: mensaje += "</ul>",
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "OK",
                        });
                    } else {
                        $("#modal_enviar_mensaje").modal("hide").on("hidden.bs.modal",
                            function() {
                                Swal.fire({
                                    title: "Proceso correcto!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "OK",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            });
                    }
                },
            });
        });

        function agregarEscuchaCantidadCaracteres(txtArea, txtCantidad) {
            $(`#${txtArea}`).on('input', function(e) {
                const longitudAct = e.target.value.length;
                document.querySelector(`#${txtCantidad}`).innerHTML = longitudAct;
            });
        }
    </script>
@endsection
