@extends('layouts.admin')

	@section('content')

	<h1 class="m-2 guinda fw-bold p-3">Validación técnica</h1>
	<div class="row">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Inicio</a></li>
				<li class="breadcrumb-item">Catálogos</li>
				<li class="breadcrumb-item"><a href="{{ url('validacion') }}">Validación técnica</a></li>
				<li class="breadcrumb-item active" aria-current="page">Ver</li>
			</ol>
		</nav>
	</div>	
		<div class="separator"></div>
		
		<div class="row">	
			<!-- Nav tabs -->
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item reg font-weight-bold" role="presentation">
					<a onclick="history.back()">
						<button class="nav-link" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
						<a href="javascript: void(0);" onclick="history.back();" class="back">
							<span>Regresar</span>
						</a>
					</button>
					</a>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Catálogo</button>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div style="overflow-x: auto;" class="px-5 mx-2">
									<table>
										<tr>
											<th class="derecha">
												<strong>Entidad</strong>
											</th>
											<td class="izquierda">
												{{ $validacion->urg->nombre }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Dirección</strong>
											</th>
											<td class="izquierda">
												{{ $validacion->direccion }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Siglas</strong>
											</th>
											<td class="izquierda">
												{{ $validacion->siglas }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Estatus</strong>
											</th>
											<td class="izquierda">
												@if( $validacion->estatus ) Activo @else Inactivo @endif
											</td>
										</tr>
									</table>
									<hr>
									<table>
										@foreach( $responsables as $responsable)
											<tr>
												<th class="derecha">
													<strong>Responsable</strong>
												</th>
												<td class="izquierda">
													{{ $responsable->nombre }}
												</td>
											</tr>
											<tr>
												<th class="derecha">
													<strong>Cargo</strong>
												</th>
												<td class="izquierda">
													{{ $responsable->cargo }}
												</td>
											</tr>
											<tr>
												<th class="derecha">
													<strong>Permiso</strong>
												</th>
												<td class="izquierda">
													{{ $responsable->rol }}
												</td>
											</tr>
											<tr><td>&nbsp;</td></tr>
										@endforeach

									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endsection