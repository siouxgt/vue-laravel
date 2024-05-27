@extends('layouts.admin')

	@section('content')
		
		<h1 class="m-2 guinda fw-bold p-3">Proveedores</h1>
		<div class="row">
			<nav aria-label="breadcrumb ">
				<ol class="breadcrumb gris1 text-decoration-none">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
					<li class="breadcrumb-item">Catálogos</li>
					<li class="breadcrumb-item active" aria-current="page">Proveedores</li>
				</ol>
			</nav>
		</div>	
		<hr>
		<div class="elemtos m-o row mb-2 justify-content-md-center">
			<div class="col-sm-12 col-md-9"></div>
			<div class="col-sm-12 col-md-3  float-end text-end">
				<button type="button" class="btn btn-white boton-1 btn-block " style="width: 80%; align-items: center;" id="proveedor_modal" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
					+ Agregar RFC
				</button>
			</div>
		</div>		
		<div class="container textoTabla">
				<table class="justify-content-md-center table align-middle" id="tabla_proveedor">
					<thead class="text-1">
						<tr>
							<th scope="col">#</th>
							<th scope="col">Nombre</th>
							<th scope="col"> RFC</th>
							<th scope="col">Estatus</th>
							<th scope="col" class="tab-cent">Ver más</th>
							<th scope="col" class="tab-cent">Editar</th>
						</tr>
					</thead>
				</table>
		</div>
		
	@endsection
	@section('js')
		@routes(['service','catProveedor'])
		<script src="{{ asset('asset/js/cat_proveedor.js') }}" type="text/javascript"></script>
	@endsection