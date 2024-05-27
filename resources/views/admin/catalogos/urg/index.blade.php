@extends('layouts.admin')

@section('content')

<h1 class="m-2 guinda fw-bold p-3">Unidad Responsable de Gasto (URG)</h1>
<div class="row">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#">Inicio</a></li>
			<li class="breadcrumb-item">Catálogos</li>
			<li class="breadcrumb-item active" aria-current="page">Unidades Responsables de Gasto (URG)</li>
		</ol>
	</nav>
</div>	
<hr>
<div class="row elemtos mb-4 justify-content-center">
	<div class="col-md justify-content-md-center">
	</div>
	<div class="col-md-3 p-3 offset-md-4 justify-content-center">
		<button type="button" class="btn btn-white boton-1 btn-block" style="width: 80%; align-items: center;" id="urg_modal">
			+ Agregar URG
		</button>
	</div>
</div>
<!-- <br> -->
<div class="container table-responsive">
	<table class="table justify-content-md-center nowrap" id="tabla_urg">
		<thead class="text-1">
			<tr>
				<th scope="col">#</th>
				<th scope="col">Clave</th>
				<th scope="col">Unidad Responsable de Gasto (URG)</th>
				<th scope="col">Fecha de Adhesión</th>
				<th scope="col">Estatus</th>
				<th scope="col" class="tab-cent">Acuerdo Adhesión</th>
				<th scope="col" class="tab-cent">Ver más</th>
				<th scope="col" class="tab-cent">Editar</th>
			</tr>
		</thead>
	</table>
</div>
@endsection
@section('js')
@routes(['urg','service'])
<script src="{{ asset('asset/js/urg.js') }}" type="text/javascript"></script>
@endsection
