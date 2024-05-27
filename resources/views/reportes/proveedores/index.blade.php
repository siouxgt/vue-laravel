@extends('layouts.proveedores_ficha_productos')
@section('content')
    <div class="col-12">
        <h1 class="m-2 px-3">Reportes</h1>
        <div class="row col-12 col-md-12 d-flex text-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-1">
                    <li class="breadcrumb-item text-2"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item text-2"><a href="#">Reportes</a></li>
                    <li class="breadcrumb-item text-2"><a href="#">Reportes</a></li>
                </ol>
            </nav>
        </div>
    </div>

    <hr>

    <div class="row justify-content-md-center">
        <div class="col-12 mt-2">
            <p class="text-center text-14">Genera reportes de tu interés.</p>
            <p class="text-center text-1 mb-4">Utiliza los filtros para seleccionar la información a visualizar y exportar.
            </p>
            <hr>
        </div>

        <div class="col-12 col-lg-8">
            <form id="frm_reporte">
                @csrf
                <div class="row ml-3">
                    <div class="col-md-4 col-sm-12 form-inline">
                        <select class="custom-select my-1 mr-sm-2" id="tipo_reporte" name="tipo_reporte">
                            <option selected="" value="0">Tipo de reporte</option>
                            <option value="REPORTE DE ORDENES DE COMPRA GENERAL">REPORTE DE ORDENES DE COMPRA GENERAL</option>
                            <option value="DIRECTORIO DE UNIDADES COMPRADORAS">DIRECTORIO DE UNIDADES COMPRADORAS</option>
                            <option value="REPORTE DE ORDENES DE COMPRA COMPLETO">REPORTE DE ORDENES DE COMPRA COMPLETO</option>
                            <option value="REPORTE DE INCIDENCIAS DE LA URG">REPORTE DE INCIDENCIAS DE LA URG</option>
                            <option value="REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO">REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO</option>
                            <option value="REPORTE DE PRODUCTOS POR CONTRATO MARCO GENERAL">REPORTE DE PRODUCTOS POR CONTRATO MARCO GENERAL</option>
                            <option value="REPORTE DE ADHESIÓN DE URG EN CONTRATO MARCO">REPORTE DE ADHESIÓN DE URG EN CONTRATO MARCO</option>
                            <option value="ANALITICOS DE CONTRATO MARCO COMPLETO">ANALITICOS DE CONTRATO MARCO COMPLETO</option>
                            <option value="REPORTE DE CLAVES CABMS POR CONTRATO MARCO">REPORTE DE CLAVES CABMS POR CONTRATO MARCO</option>
                        </select>
                        @if ($errors->first('tipo_reporte'))
                            <p class="text-danger ml-1">{{ $errors->first('tipo_reporte') }}</p>
                        @endif
                    </div>
                    <div class="col-md-4 col-sm-12 form-inline">
                        <select class="custom-select my-1 mr-sm-2" id="contratos" name="contratos">
                            <option selected="" value="0">Contrato Marco</option>
                            @foreach ($contratos as $contrato)
                                <option value="{{ $contrato->id_e }}"> {{ $contrato->nombre_cm }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 form-inline">
                        <select class="custom-select my-1 mr-sm-2" id="urgs" name="urgs">
                            <option selected="" value="0">Unidades Responsable de Gastos</option>
                            @foreach ($urgs as $urg)
                                <option value="{{ $urg->id_e }}"> {{ strtoupper($urg->nombre) }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row ml-3">
                    <div class="col-md-4 col-sm-12 form-inline">
                        <select class="custom-select my-1 mr-sm-2" id="anios" name="anios">
                            <option selected="" value="0">Año</option>
                            @foreach ($anios as $dato)
                                <option value="{{ $dato->anio }}"> {{ $dato->anio }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 form-inline">
                        <select class="custom-select my-1 mr-sm-2" id="trimestres" name="trimestres">
                            <option selected="" value="0">Trimestre</option>
                            <option value="1">ENERO - MARZO</option>
                            <option value="2">ABRIL - JUNIO</option>
                            <option value="3">JULIO - SEPTIEMBRE</option>
                            <option value="4">OCTUBRE - DICIEMBRE</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 mt-2">
                        <div class="row form-group">
                            <div class="col-auto">
                                <label for="fecha_inicio" class="text-1">Desde</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="text-1">

                                <label for="fecha_fin" class="ml-1 text-1">Hasta</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="text-1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center ml-3 p-1 mt-3">
                    <div class="col-md-2 col-2 form-inline ">
                        <input class="btn text-center boton-12 rounded" type="button" value="Generar reporte"
                            id="btn_generar_reporte">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <div class="row justify-content-md-center">
        <div class="col-md-8 col-sm-12">

            <div class="table-responsive">
                <table class="table table-hover jtable_center nowrap" style="width:100%" id="tbl_reportes_generados">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col" class="sortable text-2">Reporte</th>
                            <th scope="col" class="sortable tab-cent text-2">Fecha de creación</th>
                            <th scope="col" class="sortable tab-cent text-2">Estatus</th>
                            <th scope="col" class="sortable tab-cent text-2">Ver</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @routes(['reporte_proveedor'])
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            let dataTable = $("#tbl_reportes_generados").DataTable({
                processing: true,
                serverSide: false,
                dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                    "<'row justify-content-md-center'<'col-sm-12't>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                language: {
                    url: url + "asset/datatables/Spanish.json",
                },
                ajax: {
                    url: route("reporte_proveedor.fetch_reportes"),
                    type: "GET",
                },
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                    className: "text-center"
                }, ],
                order: [],
                columns: [{
                        data: "id_e",
                        defaultContent: ""
                    },
                    {
                        data: "tipo"
                    },
                    {
                        className: "text-center",
                        data: "fecha_creacion"
                    },
                    {
                        className: "text-center",
                        data: "estatus",
                        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                'COMPLETO'
                            );
                        },
                    },
                    { //Ver más
                        className: "text-center",
                        data: "id_e",
                        fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                            $(nTd).html(
                                '<a class="btn btn-cdmx" href="' +
                                route("reporte_proveedor.show", oData.id_e) +
                                '"><i class="fa fa-eye fa-lg dorado"></i></a>'
                            );
                        },
                    },
                ],
            });

            dataTable.on("order.dt search.dt", function() {
                let i = 1;
                dataTable.cells(null, 0, {
                    search: "applied",
                    order: "applied"
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();

            const tipoReporte = document.querySelector("#tipo_reporte"),
                selAnio = document.querySelector("#anios"),
                selTrimestre = document.querySelector("#trimestres"),
                fechaInicio = document.querySelector("#fecha_inicio"),
                fechaFin = document.querySelector("#fecha_fin"),
                btnGenerar = $('#btn_generar_reporte');

            let porFechaTrimestre = false,
                porFechaRango = false,
                ultimo = 'trimestre',
                mensaje = '';

            selAnio.addEventListener("change", (event) => {
                if (selAnio.value == 0) {
                    porFechaTrimestre = false;
                    ultimo = '';
                    if (selTrimestre.value != 0) selTrimestre.selectedIndex = 0;
                } else {
                    porFechaTrimestre = true;
                    ultimo = 'trimestre';
                    limpiarFechasDate();
                }
                verificarTipoFecha();
            });

            selTrimestre.addEventListener("change", (event) => {
                limpiarFechasDate();
                if (selTrimestre.value == 0) {
                    porFechaTrimestre = false;
                    ultimo = '';
                } else {
                    porFechaTrimestre = true;
                    ultimo = 'trimestre';
                    if (selAnio.value == 0) selAnio.selectedIndex = 1;
                }
                verificarTipoFecha();
            });

            function limpiarFechasDate() {
                fechaInicio.value = '';
                fechaFin.value = '';
            }

            fechaInicio.addEventListener("change", (event) => {
                checarFechas();
            });

            fechaFin.addEventListener("change", (event) => {
                checarFechas();
            });

            function checarFechas() {
                let fi = Date.parse(fechaInicio.value),
                    ff = Date.parse(fechaFin.value);

                porFechaRango = true;
                ultimo = 'rango';
                verificarTipoFecha();

                if (!isNaN(fi) && !isNaN(ff)) {
                    if (ff < fi) {
                        fechaFin.value = '';
                        Swal.fire("¡Alerta!", 'La segunda fecha debe ser mayor o igual a la fecha inicial',
                            "warning");
                    }
                }
            }

            function verificarTipoFecha() {
                if (porFechaTrimestre == true && porFechaRango == true) {                    
                    if (ultimo == 'trimestre') {
                        porFechaRango = false;
                        limpiarFechasDate();
                    } else if (ultimo == 'rango') {
                        porFechaTrimestre = false;
                        selAnio.value = "0";
                        selTrimestre.value = "0";
                    }
                }
            }

            function checarTipoReporte() {
                if (tipoReporte.value != 0) {
                    return true;
                } else {
                    mensaje = "Selecciona el tipo de reporte a generar."
                    return false;
                }
            }

            function checarFechaRangos() {
                if (porFechaRango) {
                    if (fechaInicio.value == '' || fechaFin.value == '') {
                        mensaje =
                            'En este reporte es necesario que seleccione una <b>fecha de inicio</b> y una <b>fecha de fin</b>';
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            }

            $(document).on("click", `#btn_generar_reporte`, function(e) {
                e.preventDefault();
                generarReporte();
            });

            function generarReporte() {
                btnGenerar.attr('disabled', true);
                if (checarTipoReporte() && checarFechaRangos()) {
                    generar();
                } else {
                    btnGenerar.attr('disabled', false);
                    Swal.fire('No se puede continuar', mensaje, "error");
                }
            }

            function generar() {
                let formData = new FormData($("#frm_reporte").get(0));
                if(formData.get('tipo_reporte')){
                    if(formData.get('urgs') != '0'){
                        formData.set('tipo_reporte', 'REPORTE DE ORDENES DE COMPRA COMPLETO POR URG');
                    }
                }                

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    type: "POST",
                    url: route("reporte_proveedor.store"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(respuesta) {
                        if (respuesta.status == 400) {
                            btnGenerar.attr('disabled', false);

                            let mensaje = "<ul>";
                            $.each(respuesta.errors, function(key, err_value) {
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
                            $("#tbl_reportes_generados").DataTable().ajax.reload();
                            btnGenerar.attr('disabled', false);
                            Swal.fire('Proceso correcto!', respuesta.mensaje, "success");
                        }
                    },
                });
            }
        });
    </script>
    <style>
        table.dataTable thead>tr>th.sorting,
        table.dataTable thead>tr>th.sorting_asc,
        table.dataTable thead>tr>th.sorting_desc,
        table.dataTable thead>tr>th.sorting_asc_disabled,
        table.dataTable thead>tr>th.sorting_desc_disabled,
        table.dataTable thead>tr>td.sorting,
        table.dataTable thead>tr>td.sorting_asc,
        table.dataTable thead>tr>td.sorting_desc,
        table.dataTable thead>tr>td.sorting_asc_disabled,
        table.dataTable thead>tr>td.sorting_desc_disabled {
            cursor: pointer;
            position: relative;
            padding-right: 10px
        }
    </style>
@endsection
