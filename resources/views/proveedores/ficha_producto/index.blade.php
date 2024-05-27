@extends('layouts.proveedores_ficha_productos')

@section('content')

<div class="row">
    <div class="col">
        <h1 class="m-2 p-3">Catálogo de productos</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">En esta página puedes observar los catálogos de productos en los que puedes participar.</a></li>
            </ol>
        </nav>
        <hr>
    </div>
</div>

<div class="row justify-content-center mt-5">
    <div class="col-11">
        <div class="table-responsive">
            <table class="table table-hover nowrap jtable_center" style="width:100%;" id="tbl_pfp">
                <thead class="bg-light">
                    <tr>
                        <th scope="col" class="text-1">#</th>
                        <th scope="col" class="sortable text-1">Contrato Marco</th>
                        <th scope="col" class="sortable text-1">CABMS</th>
                        <th scope="col" class="sortable text-1">Descripción de CABMS</th>
                        <th scope="col" class="tab-cent text-1">Versión</th>
                        <th scope="col" class="tab-cent text-1">Productos agregados</th>
                        <th scope="col" class="tab-cent text-1">Ver Productos</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection
@section('js')
@routes(['proveedor_fichap'])
<script>
    $(document).ready(function() {
        let dataTable = $("#tbl_pfp").DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                url: url + "asset/datatables/Spanish.json",
            },
            ajax: {
                url: route("proveedor_fp.fetchpfp"),
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
                    "className": "text-center",
                    "mRender": function(data, type, row) {
                        return row.nombre_cm.charAt(0).toUpperCase() + row.nombre_cm.slice(1).toLowerCase();
                    }
                },
                {
                    data: "cabms", className: "text-center"
                },
                {
                    data: "descripcion"
                },
                {
                    data: "version", className: "text-center"
                },
                { //Columna para mostrar la cantidad de productos dados de alta
                    data: "cuenta_producto", className: "text-center"
                },
                {
                    //Agregar producto
                    className: "text-center",
                    data: "id_e",
                    fnCreatedCell: function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html(
                            '<a class="btn btn-cdmx" style="display:flex; justify-content: center; align-items: center; text-align:center; height: 2rem;" href="' +
                            route("proveedor_fp.abrir_index", sData) +
                            '"><i class="fa fa-eye fa-lg dorado"></i></a>'
                        );
                    },
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
</script>
@endsection