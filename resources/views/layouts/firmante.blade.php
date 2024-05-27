<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --> --}}
	<title>Contrato Marco Firmante</title>
	<link rel="icon" href="{{ asset('asset/img/favicon.ico') }}">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
	<link href="{{ asset('asset/css/bootstrap-switch.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/tienda_urg.css') }}" rel="stylesheet">
	<script src="{{ asset('asset/js/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/datetime-moment.js') }}" type="text/javascript"></script>
</head>

<body>
	<header class="top">
		<div class="row">
			<div class="logos col-12 col-sm-12 col-lg-6 justify-content-start">
				<img class="cdmx" src="{{ asset('asset/img/logoSAFtianguis.png') }}" alt="Logo" />
			</div>
			<div class="iconos col-12 col-sm-12 col-lg-6 justify-content-end">
				<div class="Hd-alerta">
					<span>
						<div class="alerta-mensajes">
							<ul class="alerta-mensajes">
								<li><img class="Hd-alerta" src="{{ asset('asset/iconos/alert_on.svg') }}" alt="" />
									<ul>
										<li class="abre-modal" id="tareas"><i class="fa fa-check-circle alerta-icono " aria-hidden="true"></i>Tareas<span>12</span>
										</li>
										<li class="abre-modal" id="mensajes"><i class="fa fa-comment alerta-icono" aria-hidden="true"></i>Mensajes<span>3</span></li>
									</ul>

								</li>
							</ul>
						</div>
						<p>7</p>
					</span>
				</div>

				<div class="dropdown">
					<span>
						<h2 class="perfil">{{ substr(auth()->user()->nombre,0,1) . substr(auth()->user()->primer_apellido,0,1) }}</h2>
					</span>
					<div class="dropdown-content alerta-mensajes">
						<ul class="id">
							<li><a href="{{ route('users.logout') }}"><img src="{{ asset('asset/img/btnFlechaDer_Mesa de trabajo 1.svg') }}" alt="salir" class="abre-modal m-2" style="width:40%"></a></li>
							<li><img src="{{ asset('asset/img/id_guinda_Mesa de trabajo 1.svg') }}" alt="ID" class="abre-modal m-2" style="width:40%"></li>
							<li><img src="{{ asset('asset/img/saberMas_Mesa de trabajo 1.svg') }}" alt="Saber más" class="abre-modal m-2" style="width:40%"></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<div class="nav nav-item"><a href="{{ route('firmante.index') }}" class="{{ Route::is(['firmante.index']) ? 'nav-active': 'underline' }}">Inicio</a></div>
				<div class="dropdown">
					<a href="javascript: void(0)" class="{{ Route::is(['orden_compra.*','orden_compra_urg.*']) ? 'nav-active': 'underline' }}">Órdenes de compra <i class="fa fa-angle-down gris" aria-hidden="true"></i></a>
					<div class="dropdown-content">
						<li class="dropdown">
							<a href="{{ url('orden_compra') }}" class="dropdown">Órdenes de compra
								<div style="float: right"><i class="fa fa-angle-right" aria-hidden="true"></i>
								</div>
							</a>
						</li>
						<li class="dropdown nav-item">
							<a href="javascript: void(0)" class="dropdown">Contratos
								<div style="float: right"><i class="fa fa-angle-right" aria-hidden="true"></i>
								</div>
							</a>
						</li>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<main class="container-fluid mt-3">
		@yield('content')
	</main>

	<div class="row" id="div_carrito_compras">
	</div>

	<!-- footer -->
	<footer>
		<!-- Footer -->
		<div class="row ft-leyenda">
			<ul class="ft-leyenda-list text-decoration-none">
				<li>
					<img src="{{ asset('asset/images/lg_cdmx_footer.svg') }}" alt="" />
				</li>
				<li>
					Diseñado y operado por la Secretaría de Administración y Finanzas
					<br>
					Cualquier duda y/o problema relacionado con el sitio, favor de contactarnos a través de <a href="mailto:mesadeservicio@finanzas.cdmx.gob.mx">mesadeservicio@finanzas.cdmx.gob.mx</a>
					<br>
					Se brindará atención telefónica de Lunes a Viernes en el teléfono <strong>(55) 5723 6505 ext. 5026, 5004, 5070</strong>
					<br>
					Horario de atención de 09:00 A 17:00 hrs.
				</li>
			</ul>
		</div>

		<!-- Footer legal -->
		<div class="row ft-legal">
			<ul class="ft-legal-list text-decoration-none">
				<li><a href="javascript: void(0)">Términos y condiciones</a></li>
				<li><a href="javascript: void(0)">Política de privacidad</a></li>
				<li>2022 Gobierno de la CDMX</li>
			</ul>
		</div>

	</footer>
	<!-- footer -->


	<script src="{{ asset('asset/js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/popper.min.js') }}" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<script src="{{ asset('asset/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/select2.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/jquery.validate.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/datetime-moment.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/main.js') }}" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
	<script type="text/javascript">
		const url = "{{ URL::asset('') }}"
	</script>

	@yield('js')
	@yield('js2')
	@yield('js3')
</body>

</html>