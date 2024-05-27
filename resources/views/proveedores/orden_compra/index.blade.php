@extends('layouts.proveedores_ficha_productos')

@section('content')
    <h1 class="m-2 px-3">Órdenes de compra</h1>
    <p class="text-2 px-4">En esta página encontrarás las compras que has realizado en Contratos Marco. Para ver el detalle,
        da clic en los iconos.</p>

    <!----------CABMSCDMX-------->
    <div class="mt-4 mb-4">
        <div class="row mt-2 justify-content-center">
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalNuevas === 0) badge-gris-1 @else badge-secondary @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalNuevas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Nuevas</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalCanceladas === 0) badge-gris-1 @else badge-red-1 @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalCanceladas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Canceladas</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalRechazadas === 0) badge-gris-1 @else badge-red-1 @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalRechazadas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Rechazadas</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalConfirmadas === 0) badge-gris-1 @else badge-secondary @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalConfirmadas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Confirmadas</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalEntregadas === 0) badge-gris-1 @else badge-secondary @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalEntregadas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Entregadas</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalSustitucion === 0) badge-gris-1 @else badge-warning @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalSustitucion }}</span>
                <p class="text-1 ml-2 font-weight-bold">Sustitución</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalFacturadas === 0) badge-gris-1 @else badge-secondary @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalFacturadas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Facturadas</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalPagadas === 0) badge-gris-1 @else badge-secondary @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalPagadas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Pagadas</p>
            </div>
            <div class="col d-flex mt-2" style="max-width: 150px; min-width: 150px;">
                <span class="badge badge-pill @if ($totalEvaluadas === 0) badge-gris-1 @else badge-secondary @endif"
                    style='display:flex; justify-content: center; align-items: center;'>{{ $totalEvaluadas }}</span>
                <p class="text-1 ml-2 font-weight-bold">Evaluadas</p>
            </div>
        </div>
    </div>

    <hr class="mx-5">
    <!----------CABMSCDMX-------->

    <div class="row elemtos justify-content-around">
        <div class="col-12 col-lg-2 col-md-2 col-sm-8 justify-content-center">
            <p class="boton-11 rounded mt-1 mb-1">Total Órdenes de Compra:<span
                    class="text-9 font-weight-bold ml-1">{{ $totalOC }}</span></p>
        </div>
    </div>

    <div class="container-fluid p-4">

        <div class="table-responsive">
            <table class="table table-striped table-hover jtable_center nowrap" style="width:100%" id="tbl_ocp">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col" class="sortable tab-cent text-1">Id
                            orden</th>
                        <th scope="col" class="sortable tab-cent text-1">Fecha</th>
                        <th scope="col" class="sortable tab-cent text-1">Unidad Responsable de Gasto
                        </th>
                        <th scope="col" class="tab-cent text-1">CABMSCDMX</th>
                        <th scope="col" class="tab-cent text-1">Total compra</th>
                        <th scope="col" class="sortable tab-cent text-1">Fecha Entrega</th>
                        <th scope="col" class="sortable tab-cent text-1">Fin Contrato</th>
                        <th scope="col" class="sortable tab-cent text-1">Etapa</th>
                        <th scope="col" class="sortable tab-cent text-1">Estatus</th>
                        <th scope="col" class="tab-cent text-1">Pago</th>
                        <th scope="col" class="tab-cent text-1">Retraso</th>
                        <th scope="col" class="tab-cent text-1">Incidencias</th>
                        <th scope="col" class="tab-cent text-1">Ver más</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
@endsection
@section('js')
    @routes(['ocp'])
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            $(document).ready(function() {
                $.fn.dataTable.moment( 'DD/MM/YYYY' );
                let dataTable = $("#tbl_ocp").DataTable({
                    processing: true,
                    serverSide: false,
                    dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                        "<'row justify-content-md-center'<'col-sm-12't>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    language: {
                        url: url + "asset/datatables/Spanish.json",
                    },
                    ajax: {
                        url: route("orden_compra_proveedores.fetch_ocp"),
                        type: "GET",
                    },
                    columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: 0,
                        className: "text-center"
                    }, ],
                    order: [
                        [1, "asc"]
                    ],
                    columns: [{
                            data: "id_e",
                            defaultContent: ""
                        },
                        {
                            data: "id_orden", className: "text-center"
                        },
                        {
                            "className": "text-center",
                            "mRender": function(data, type, row) {
                                let aux = row.fecha.split('-');
                                let aux2 = aux[2].split(' ');
                                let fecha = new Date(aux[0], aux[1] - 1, aux2[0])
                                    .toLocaleDateString();
                                return fecha;
                            }
                        },
                        {
                            data: "urg"
                        },
                        {
                            data: "cantidad_cabms", className: "text-center"
                        },
                        {
                            "className": "text-center",
                            "mRender": function(data, type, row) {
                                return new Intl.NumberFormat("es-MX", {
                                    style: "currency",
                                    currency: "MXN"
                                }).format(row.total_compra);
                            },
                        },
                        {
                            className: "text-center",
                            data: "fecha_entrega_almacen",
                        },
                        { //Fecha de fin del contrato
                            className: "text-center",
                            data: "fecha_fin",
                        },
                        {
                            "className": "text-center",
                            "mRender": function(data, type, row) {
                                return `<span class="etapa px-3">${row.etapa}</span>`;
                            }
                        },
                        {
                            "className": "text-center",
                            "mRender": function(data, type, row) {
                                return `<span class="etapa-${row.css} px-3">${row.estatus}</span>`;
                            }
                        },
                        { //Columna que demuestra el estatus del pago
                            "className": "text-center",
                            "mRender": function(data, type, row) {
                                return `<span class="etapa-${row.estatus_pago.css} px-3">${row.estatus_pago.pago}</span>`;
                            }
                        },
                        { //Columna que demuestra el estatus de retraso
                            "className": "text-center",
                            "mRender": function(data, type, row) {
                                return `<span class="px-3">${row.estatus_pago.retraso}</span>`;
                            }
                        },
                        { //Columna que demuestra las incidencias
                            "className": "text-center",
                            "mRender": function(data, type, row) {
                                return `<span class="px-3">${row.total_incidencias}</span>`;
                            }
                        },
                        {
                            "className": "text-center",
                            "orderable": false,
                            "mRender": function(data, type, row) {
                                ///orden_compra_proveedores/ver_mas
                                return `<a class="btn btn-cdmx" href="${ route('orden_compra_proveedores.show', row.id_e) }"><i class="fa fa-eye fa-lg dorado"></i></a>`;
                            }
                        },
                    ],
                });

                dataTable
                    .on("order.dt search.dt", function() {
                        let i = 1;
                        dataTable
                            .cells(null, 0, {
                                search: "applied",
                                order: "applied"
                            })
                            .every(function(cell) {
                                this.data(i++);
                            });
                    })
                    .draw();
            });
        });
    </script>
@endsection
