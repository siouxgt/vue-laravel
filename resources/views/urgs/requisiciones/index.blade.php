@extends('layouts.urg')

    @section('content')
        <h1 class="m-2 p-3 mt-3">Requisiciones</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">En esta página encontrarás las requisiciones autorizadas en el sistema de requisiciones para usar en los Contratos Marco.</li>
            </ol>
        </nav>
        <div class="separator mb-3"></div>

        <div class="row elemtos mb-3">
            <div class="col-11 col-md-10 d-flex justify-content-center">
                <h4 class="text-1 m-3"><span class="badge badge-secondary">{{ $contador->disponible }}</span>  Disponibles</h4>
                <h4 class="text-1 m-3"><span class="badge badge-warning">{{ $contador->adjudicada }}</span>  Adjudicadas</h4>
            </div>
            <div class="col-1 col-md-1 d-flex">
                <button type="button" class="btn boton-2 ml-2 border" onclick="obtenerRequisicion()">Obtener requisiciones</button>
            </div>
        </div>

        <div>
            <table class="table justify-content-md-center" id="tabla_requisicion">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID Requisición</th>
                        <th scope="col">Objeto de la requisición</th>
                        <th scope="col">Monto autorizado</th>
                        <th scope="col">Monto adjudicado</th>
                        <th scope="col">Monto disponible</th>
                        <th scope="col">Estatus</th>
                        <th scope="col" class="tab-cent">Ver</th>
                        <th scope="col" class="tab-cent">Cotización</th>
                        <th scope="col" class="tab-cent">Compras</th>
                    </tr>
                </thead>
            </table>
        </div>


    @endsection
    @section('js')
        @routes(['requisiciones', 'carritoCompra'])
        <script src="{{ asset('asset/js/requisicion.js') }}" type="text/javascript"></script>
    @endsection