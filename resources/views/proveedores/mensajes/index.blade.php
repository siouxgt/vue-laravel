@extends('layouts.proveedores_ficha_productos')
@section('content')
    <div class="row mx-2 mt-3">
        <div class="col-12">
            <h1 class="ml-3">Mensajes</h1>
            <p class="text-1 ml-4">En esta página encontrarás los mensajes de tus compradores, administrador y sistema.
            </p>
        </div>
    </div>

    <hr>

    <div class="row mx-3 justify-content-sm-end btn-filtros">
        <div class="col-12 col-sm-auto mt-2">
            <button type="button" class="col-12 btn bg-white btn-mensaje-green border font-weight-bold"
                id="btn-filtro-todos"><i class="fa-solid fa-inbox btn-mensaje-green"></i>
                Todos</button>
        </div>
        <div class="col-12 col-sm-auto mt-2">
            <button type="button" class="col-12 btn bg-white btn-mensaje-gray border" id="btn-filtro-enviados"><i
                    class="fa-sharp fa-solid fa-paper-plane btn-mensaje-gray"></i> Enviados</button>
        </div>
        <div class="col-12 col-sm-auto mt-2">
            <button type="button" class="col-12 btn bg-white btn-mensaje-gray border" id="btn-filtro-archivados"><i
                    class="fa-solid fa-box-archive btn-mensaje-gray"></i>
                Archivados</button>
        </div>
        <div class="col-12 col-sm-auto mt-2">
            <button type="button" class="col-12 btn bg-white btn-mensaje-gray border" id="btn-filtro-eliminados"><i
                    class="fa-regular fa-rectangle-xmark btn-mensaje-gray"></i> Eliminados</button>
        </div>
    </div>

    <hr>

    <div class="row mx-3">
        <div class="col-12 col-sm-6">
            <button type="button" class="btn bg-white " data-container="body" data-toggle="popover" data-placement="top"
                data-content="Todos">
                <input type="checkbox" class="form-check-input bac-green" id="check-todos" data-toggle="tooltip"
                    data-placement="top" title="Todos">
            </button>
            <button type="button" class="btn bg-white" data-toggle="tooltip" data-placement="top"
                title="Destacar / No destacar" id="btn-destacar">
                <span class="fa-solid fa-star gold"></span>
            </button>
            <button type="button" class="btn bg-white" data-toggle="tooltip" data-placement="top" title="Archivar"
                id="btn-archivar">
                <span class="fa-solid fa-box-archive gold"></span>
            </button>
            <button type="button" class="btn bg-white" data-toggle="tooltip" data-placement="top" title="Eliminar"
                id="btn-borrar">
                <span class="fa-regular fa-rectangle-xmark gold"></span>
            </button>
        </div>
        <div class="col-12 col-sm-6">
            <div class="row justify-content-center justify-content-md-end">
                <div class="col-6 col-sm-auto">
                    <p class="text-10" id="sin-leer">Sin leer : {{ $sinLeer->sin_leer }}</p>
                </div>
                <div class="col-6 col-sm-auto pr-0">
                    <select class="custom-select" style="width:10rem" id="sel-mostrar">
                        <option value="" selected disabled>Mostrar</option>
                        <option value="">Todos</option>
                        <option value="destacado">Destacados</option>
                        <option value="no-leido">No leídos</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <style>
        .mensaje-titulo {
            background-color: #f2f1f1;
            color: #000000;
        }

        .jtable_c tbody td {
            text-align: left !important;
            vertical-align: auto !important;
        }

        .jtable_c td,
        .jtable_c th {
            padding: .75rem;
            vertical-align: top;
            border-top: 0.1rem solid #f4f4f4;
        }

        .fondo>tbody>tr:hover {
            background-color: #ffffff;
        }

        table.dataTable tbody tr.selected>* {
            box-shadow: inset 0 0 0 9999px rgba(230, 228, 251, 0.9);
            color: #6f7271;
        }
    </style>
    <div class="row mx-3 mt-3 justify-content-center">
        <div class="table-responsive ml-2">
            <table class="table jtable_center nowrap" style="width:100%" id="tbl_mensajes_proveedor">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Fecha</th>
                        <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Remitente</th>
                        <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Asunto</th>
                        <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Origen</th>
                        <th scope="col"></th>
                        <th scope="col" class="sortable tab-cent text-2 font-weight-bold"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
    @routes(['incidencia_proveedor'])
    <script src="{{ asset('asset/js/mensajes_proveedor.js') }}" type="text/javascript"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip('enable');
    </script>
@endsection
