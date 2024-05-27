@extends('layouts.admin')

	@section('content')

		<h1 class="m-2 p-3">Usuario</h1>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Inicio</a></li>
				<li class="breadcrumb-item"><a href="{{ url('usuarios') }}">Usuarios</a></li>
				<li class="breadcrumb-item active" aria-current="page">Ver</li>
			</ol>
		</nav>
		<div class="separator"></div>
		
		<div class="container-fluid">
		<div class="row">

			<!-- Nav tabs -->
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item reg" role="presentation">
					<button class="nav-link" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
						<a href="javascript: void(0);" onclick="history.back();" class="back">
							<span>Regresar</span>
						</a>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link active hoverTab" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
						<span class="tabText">Datos</span>
					</button>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content justify-content-center">
				<div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
									<table>
										<tr>
											<th class="derecha">
												<strong>RFC</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->rfc }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>CURP</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->curp }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Nombre</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Cargo</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->cargo }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Email</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->email }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Telefono</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->telefono }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Extensión</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->extension }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>URG</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->urg->nombre }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Rol</strong>
											</th>
											<td class="izquierda">
												{{ $usuario->rol->rol }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Estatus</strong>
											</th>
											<td class="izquierda">
												@if( $usuario->estatus ) Activo @else Inactivo @endif
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@endsection