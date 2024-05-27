@extends('layouts.admin')

	@section('content')
		
		<h1 class="m-2 guinda fw-bold p-3">Validación técnica</h1>
		<div class="row">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item">Catálogos</li>
					<li class="breadcrumb-item active" aria-current="page">Validación técnica </li>
				</ol>
			</nav>
		</div>	
		<hr>
		<div class="row elemtos">
			<div class="col-12 col-md-3 p-3 m-2 justify-content-center">
			</div>
			{{-- <div class="col-12 col-md-3 p-3 offset-md-4 justify-content-center">
				<button type="button" class="btn btn-white boton-1 btn-block" style="width: 80%; align-items: center;" id="validacion_modal"  data-toggle="modal" data-target="#staticBackdrop">
					+ Agregar Equipo
				</button>
			</div> --}}
		</div>
		<div class="container">
			<table class="table justify-content-md-center" id="tabla_validacion">
				<thead class="text-1">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Entidad</th>
						<th scope="col"> Dirección</th>
						<th scope="col">Estatus</th>
						<th scope="col" class="tab-cent">Ver más</th>
						<th scope="col" class="tab-cent">Editar</th>
					</tr>
				</thead>
			</table>
		</div>
	@endsection
	@section('js')
		@routes(['validacion', 'service'])
		<script src="{{ asset('asset/js/validacion_tecnica.js') }}" type="text/javascript"></script>
	@endsection