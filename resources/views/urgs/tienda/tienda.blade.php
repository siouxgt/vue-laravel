@extends('layouts.urg')

@section('content')
<div class="row mx-3 mt-3 d-flex justify-content-center align-items-center">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg mt-2">
        <!-- <form class="mb-2 ml-4 mt-2"> -->
        <input class="form-control" ng-model="searchUserTerm" type="text" placeholder="Hacer busqueda por nombre de producto..." aria-label="default input example" id="buscador">
        <!-- </form> -->
    </div>

    <div class="col-xs-4 col-sm-auto col-md-auto col-lg-auto mt-2">
        <div class="dropdown-1 boton-9">
            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                <i class="fa-solid fa-sliders"></i>Filtros
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item text-1 " href="javascript: void(0)">
                        <strong>TAMAÑO</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-submenu">
                        <div id="filtroTamanios">

                        </div>
                    </ul>
                </li>

                <li>
                    <a class="dropdown-item text-1 " href="javascript: void(0)">
                        <strong>ENTREGA</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-submenu">
                        <div id="filtroTiempo">

                        </div>
                    </ul>
                </li>

            </ul>
        </div>
    </div>

    <div class="col-xs-4 col-sm-auto col-md-auto col-lg-auto mt-2">
        <input type="hidden" value="{{ $cabms }}" name="bienes" id="bienes">
        <button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal" id="btn_cabms">Claves CABMSCDMX</button>
    </div>

    <div class="col-xs-4 col-sm-auto col-md-auto col-lg-auto mt-2">
        <select class="custom-select" id="ordenarPor">
            <option selected>Ordernar por:</option>
            <option value="todos" title="Se quitara todo filtro que se haya aplicado.">Todos</option>
            <option value="nuevos" title="Se mostrarán los productos más recientes dados de alta.">Nuevos</option>
            <option value="bajo" title="Se ordenara y se mostrará primero el precio más bajo.">Precio más bajo</option>
            <option value="alto" title="Se ordenara y se mostrará primero el precio más alto.">Precio más alto</option>
            <option value="estrellas">Mejor calificados</option>
        </select>
    </div>

    <div class="col-xs-4 col-sm-auto col-md-auto col-lg-auto mt-2">
        <button class="btn btn-outline-secondary" id="btn_quitar_filtros" type="button" title="Quitar todos los filtros aplicados" value="todos">Quitar filtros</button>
    </div>
</div>

<hr>

<h1 class="m-2 p-3 mt-1" id="producto_mostrado"></h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
        <li class="breadcrumb-item"><a href="#">Contratos Marco</a></li>
        <li class="breadcrumb-item active" aria-current="page" id="producto_mostrado_lista"></li>
    </ol>
</nav>

<h2 class="titel-2 m-2 p-3" id="total_resultados"></h2>

<div class="row ml-1 mr-1" id="divProductos">
</div>

@endsection
@section('js')
@routes(['tiendaUrg', 'carritoCompra', 'pfu'])
<script src="{{ asset('asset/js/tienda_urg_filtros_interno.js') }}" type="text/javascript"></script>
@endsection