@extends('layouts.proveedores_ficha_productos')

@section('content')
    <h1 class="m-2 p-3">Contratos</h1>
    <p class="text-2 px-4">En esta página encontrarás los contratos que has firmado</p>
    <div class="separator"></div>
    <div class="row mt-2 mb-3 ml-3 mr-3 justify-content-center">
        <div class="col-12 col-md-12 col-lg-3 mt-1">
            <p class="text-1 ml-2 font-weight-bold text-center">
                <span class="badge badge-pill badge-gris-1" id="total-contratos">0</span>
                Total Contratos
            </p>
        </div>
    </div>
    <div class="separator"></div>
    <div class="container-flex mt-3 ml-3 mr-3">
        <div class="table-responsive">
            <table class="table table-hover jtable_center nowrap" style="width:100%" id="tbl_contratos">
                <thead>
                    <tr>
                        <th scope="col" class="text-1">#</th>
                        <th scope="col" class="text-1">Id orden</th>
                        <th scope="col" class="text-1">Alta contrato</th>
                        <th scope="col" class="text-1">URG</th>
                        <th scope="col" class="text-1 tab-cent">eFirma Proveedor</th>
                        <th scope="col" class="text-1 tab-cent">eFirma DGA</th>
                        <th scope="col" class="text-1 tab-cent">eFirma Adq./compras</th>
                        <th scope="col" class="text-1 tab-cent">eFirma Finanzas</th>
                        <th scope="col" class="text-1 tab-cent">eFirma A. Requiriente</th>
                        <th scope="col" class="text-1">Contrato</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('js')
    @routes('ocp')
    <script defer>
        document.addEventListener("DOMContentLoaded", () => {

            let dataTable = $('#tbl_contratos').DataTable({
                processing: true,
                serverSide: false,
                dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                    "<'row justify-content-md-center'<'col-sm-12't>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                language: {
                    "url": url + "asset/datatables/Spanish.json"
                },
                ajax: {
                    "url": route('orden_compra_proveedores.fetch_contratos'),
                    "type": "GET"
                },
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0,
                    className: "text-center"
                }],
                order: [
                    [1, 'asc']
                ],
                columns: [{
                        data: 'id',
                        className: "text-center",
                        defaultContent: ''
                    },
                    {
                        data: 'orden_compra', className: "text-center"
                    },
                    {
                        data: 'fecha_alta_contrato', className: "text-center"
                    },
                    {
                        data: 'urg'
                    },
                    {
                        "orderable": false,
                        "className": "text-center",
                        "mRender": function(data, type, row) {
                            let proveedor = "";
                            if (row.proveedor) {
                                proveedor = '<i class="green fa-solid fa-check fa-lg"></i>';
                            }
                            return proveedor;
                        }
                    },
                    {
                        "orderable": false,
                        "className": "text-center",
                        "mRender": function(data, type, row) {
                            let titular = "";
                            if (row.titular) {
                                titular = '<i class="green fa-solid fa-check fa-lg"></i>';
                            }
                            return titular;
                        }
                    },
                    {
                        "orderable": false,
                        "className": "text-center",
                        "mRender": function(data, type, row) {
                            let adquisiciones = "";
                            if (row.adquisiciones) {
                                adquisiciones = '<i class="green fa-solid fa-check fa-lg"></i>';
                            }
                            return adquisiciones;
                        }
                    },
                    {
                        "orderable": false,
                        "className": "text-center",
                        "mRender": function(data, type, row) {
                            let financiera = "";
                            if (row.financiera) {
                                financiera = '<i class="green fa-solid fa-check fa-lg"></i>';
                            }
                            return financiera;
                        }
                    },
                    {
                        "orderable": false,
                        "className": "text-center",
                        "mRender": function(data, type, row) {
                            let requiriente = "";
                            if (row.requiriente) {
                                requiriente = '<i class="green fa-solid fa-check fa-lg"></i>';
                            }
                            return requiriente;
                        }
                    },
                    {
                        "orderable": false,
                        "className": "text-center",
                        "mRender": function(data, type, row) {
                            return `<a href="${url}storage/contrato-pedido/contrato_pedido_${row.contrato_pedido}.pdf" class="mx-4" target="_blank"><i class="fa-solid fa-file-signature text-gold"></i></a>`;
                        }
                    },
                ]
            });

            dataTable.on('order.dt search.dt', function() {
                let i = 1;
                dataTable.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();

            dataTable.on("draw", function() {
                document.getElementById("total-contratos").innerText = dataTable.rows().count();;
                console.log("Hola a todo el mubndo", dataTable.rows().count())
            })

        });
    </script>
@endsection
