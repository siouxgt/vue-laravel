@extends('layouts.admin')

	@section('content')
		<input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">
		<h1 class="m-2 guinda p-3"><strong>Productos</strong></h1>
		<div class="row">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item">Catálogos</li>
					<li class="breadcrumb-item active" aria-current="page">Productos</li>
				</ol>
			</nav>
		</div>	
		<hr>
		<div class="elemtos m-o row justify-content-center mb-4">
			<div class="col-sm-12 col-md-9">
			</div>
			<div class="col-sm-12 col-md-2">
				<a type="button" class="btn btn-white boton-1 btn-block"  href="{{ route('cat_producto.create') }}">
					+ Agregar Producto
				</a>
			</div>
			<div class="col-sm-12 col-md-1">
			</div>
		</div>
		<div class="container">
			<table class="table justify-content-md-center" id="tabla_producto">
				<thead class="text-1">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nombre del contrato</th>
						<th scope="col">Clave CABMS</th>
						<th scope="col">Descripción Clave CABMS</th>
						<th scope="col">No. Ficha</th>
						<th scope="col">Versión</th>
						<th scope="col">Estatus</th>
						<th scope="col" class="tab-cent">Ver más</th>
						<th scope="col" class="tab-cent">Editar</th>
					</tr>
				</thead>
			</table>
		</div>
	@endsection
	@section('js')
		@routes('catProducto')
		<script src="{{ asset('asset/js/cat_producto.js') }}" type="text/javascript"></script>
	@endsection