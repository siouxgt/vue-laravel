@extends('layouts.admin')

    @section('content')

	    <div class="row mx-3 mt-3 d-flex justify-content-center align-items-center">
	        <div class="col-xs-12 col-sm-12 col-md-12 col-lg mt-2">
	            <input class="form-control" ng-model="searchUserTerm" type="text" placeholder="Hacer busqueda por nombre de producto..." aria-label="default input example" id="buscador">
	        </div>

	        <div class="col-xs-4 col-sm-auto col-md-auto col-lg-auto mt-2">
	        	<button type="button" class="btn btn-outline-light" onclick="cmModal()">Contratos Marco</button>
	    	</div>

	        <div class="col-xs-4 col-sm-auto col-md-auto col-lg-auto mt-2">
	            <button class="btn btn-outline-secondary" id="btn_quitar_filtros" type="button" title="Quitar todos los filtros aplicados" value="todos">Quitar filtros</button>
	        </div>
	    </div>

	    <hr>

	    <h1 class="m-2 p-3 mt-1"> Productos </h1>
		<nav aria-label="breadcrumb">
		    <ol class="breadcrumb">
		        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
		        <li class="breadcrumb-item active">Productos</li>
		    </ol>
		</nav>
		<hr>
	    <div class="row ml-1 mr-1" id="productos">
			
		</div>

	@endsection
	@section('js')
		@routes(['productoAdmin'])
		<script src="{{ asset('asset/js/admin_producto.js') }}" type="text/javascript"></script>
	@endsection