<!doctype html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> {{-- produccion --}} 
	<title>Acceso a proveedores</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
	<link href="{{ asset('asset/css/bootstrap-switch.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/proveedores_b.css') }}" rel="stylesheet">
	<script src="{{ asset('asset/js/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('asset/js/datetime-moment.js') }}" type="text/javascript"></script>
</head>

<body>

	<header class="top">
		<div class="logos">
			<img class="" src="{{ asset('asset/img/logoSAFtianguis.png') }}" alt="" />
		</div>
		<div class="lang">
			<span href="" class="HD-titulo">Contrato Marco</span>
		</div>
	</header>

	<main class="container-fluid mt-5">
		@yield('content')
	</main>

	<!-- footer -->
	<footer>
		<!-- Footer -->
		<section class="ft-leyenda">
			<ul class="ft-leyenda-list">
				<li>
					<img src="{{ asset('asset/images/lg_cdmx_footer.svg') }}" alt="" />
				</li>
				<li>
					Diseñado y operado por la Secretaría de Administración y Finanzas
					<br>
					Cualquier duda y/o problema relacionado con el sitio, favor de contactarnos a través de <a href="mailto:mesadeservicio@finanzas.cdmx.gob.mx">mesadeservicio@finanzas.cdmx.gob.mx</a>
					<br>
					Se brindará atención telefónica de Lunes a Viernes en el teléfono <strong>(55) 5723 6505 ext. 5026, 5004, 5070</strong>
				</li>
			</ul>
		</section>

		<!-- Footer legal -->
		<section class="ft-legal">
			<ul class="ft-legal-list">
				<li><a href="#">Términos y condiciones</a></li>
				<li><a href="#">Política de privacidad</a></li>
				<li>2022 Gobierno de la CDMX</li>
			</ul>
		</section>
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
		var url = "{{ URL::asset('') }}";
	</script>
	@yield('js')
	@yield('js2')
</body>

</html>