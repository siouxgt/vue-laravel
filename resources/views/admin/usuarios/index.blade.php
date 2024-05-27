@extends('layouts.admin')

	@section('content')
		
		<h1 class="m-2 p-3">Usuarios</h1>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Inicio</a></li>
				<li class="breadcrumb-item active" aria-current="page">Usuarios</li>
			</ol>
		</nav>
		<div class="separator"></div>
		<div class="container">
			<table class="table justify-content-md-center" id="tabla_usuarios">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nombre</th>
						<th scope="col">RFC</th>
						<th scope="col">URG</th>
						<th scope="col">Rol</th>
						<th scope="col" class="tab-cent">Ver más</th>
						<th scope="col" class="tab-cent">Editar</th>
					</tr>
				</thead>
			</table>
		</div>
	@endsection
	@section('js')
		@routes(['usuarios'])
		<script src="{{ asset('asset/js/usuarios.js') }}" type="text/javascript"></script>
	@endsection