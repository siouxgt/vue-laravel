<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('asset/img/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&display=swap" rel="stylesheet">

    <title>Acceso a Proveedores</title>
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        h1 {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 3.6rem;
            font-weight: 900;
            color: #235B4E;
        }

        .texto_1 {
            font-size: 1.2rem;
            color: #235B4E;
        }

        .form-check .olvidaste {
            color: #235B4E;
        }

        .form-check .olvidaste :hover {
            color: #BC955C;
            text-decoration: none;
            border: #916e3a;
        }

        .form-group .btn {
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            color: #fff;
            background-color: #235B4E;
        }

        .btn:hover {
            background-color: #BC955C;
            border: 0;
        }

        .cuenta a {
            color: #235B4E;
            font-size: 1.1rem;
            font-weight: 500;
        }

        footer {
            background-color: #f8f4ed;
            margin-top: 2rem;
        }

        footer p {
            color: #235B4E;
        }

        footer a {
            color: #9F2241;
            font-weight: 800;
        }

        .tu {
            color: #9F2241;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .tu:hover {
            color: #BC955C;
            font-size: 1.5rem;
            font-weight: 800;
        }


        .redondo {
            background-color: #851330;
            border-radius: 30px;
            box-shadow: 0px 3px 5px #98989A;
            background-image: url("/asset/images/bg_espigas_vino.png");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: top right;
        }

        .redondo a {
            font-size: 1.9rem;
            font-weight: 700;
        }

        @media (min-width: 768px) {
            .logo {
                align-items: center;
                width: 50%;
            }
        }

        @media (min-width: 576px) {
            .logo {
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="container-fluid">
            <div class="row col-12">
                <img src="{{ asset('asset/img/logoSAFtianguis.png') }}" alt="Logo" class="logo p-5 m-1">
            </div>
        </div>
        
    </header>
    <div class=" container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-7 col-xl-8 bg-white">
                        <img src="{{ asset('asset/images/proveedores_fondo_bienvenida.png') }}" class="img-fluid" alt="Ilustración">
                    </div>
                    <div class="col-12 col-sm-6 col-lg-5 col-xl-4 bg-white text-center">
                        <h1>¡Hola Proveedor!</h1>
                        <p class="texto_1 pb-3">Has llegado al espacio donde podrás realizar ventas y dar seguimiento a los Contrato Marco con el
                            Gobierno de la Ciudad de México</p>

                        <form action="{{ url('/proveedor/checar_perfil') }}" method="POST" enctype="multipart/form-data" id="frm_acceso_proveedor">
                            @csrf
                            <div class="row">
                                <div class="col-sm-1">

                                </div>
                                <div class="col-sm-10">
                                    @if(Session::has('mensaje'))
                                    <div class="alert alert-danger">{{Session::get('mensaje')}}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row text-secondary">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="rfc" name="rfc" value="{{old('rfc')}}" required autofocus autocomplete="off" placeholder="Introduce tu RFC">
                                    @if($errors->first('rfc'))
                                    <p class="text-danger">{{$errors->first('rfc')}}</p>
                                    @endif
                                </div>
                            </div>                           
                            <div class="form-group row text-secondary">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" name="password" required placeholder="Introduce tu contraseña">
                                    @if($errors->first('password'))
                                    <p class="text-danger">{{$errors->first('password')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-secondary">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="recordar_credencial" name="recordar_credencial">
                                        <label class="form-check-label" for="recordar_credencial" title="Tu RFC y contraseña serán recordadas.">
                                            Recordar credenciales
                                        </label>
                                        <a href="https://tianguisdigital.finanzas.cdmx.gob.mx/restablecer-password" target="_blank" class="olvidaste m-3" title="Se te redirigirá a tianguis digital para recuperar tu contraseña.">¿Olvidaste tu contraseña?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <input type="submit" value="Ingresar" class="btn">
                                </div>

                            </div>
                            <div class="form-group row">
                                <div class=" col-12 text-secondary">
                                    <p>¿Aún no tienes cuenta en el Padrón de Proveedores?</p>
                                </div>
                                <div class="cuenta col-12">
                                    <a href="https://tianguisdigital.finanzas.cdmx.gob.mx/" target="_blank" title="Ir a tianguis digital para darte de alta.">Crear cuenta</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="pt-2 mb-4">
                <div class="container-fluid bg-#DDC9A3 text-center ">
                    <div class="row align-items-center p-2 m-1 ">
                        <div class="col-12 col-md-6 ">
                            <p class="h4 ">
                                Si eres Unidad Responsable del Gasto (<strong>URG</strong>) o <strong>Administrador</strong> ingresa desde
                                <a href="#" target="_blank" class="tu">tu acceso único</a>
                            </p>
                        </div>
                        <div class="redondo col-12 col-md-6 bg-#9F2241 text-color-white mb-4">
                            <a href="http://10.1.129.92/acceso_unico/public/" class="text-white pz-4">Conoce más este proyecto</a>
                        </div>
                    </div>
                </div>
            </footer>

            <script src="{{ asset('asset/js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/popper.min.js') }}" type="text/javascript"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <script src="{{ asset('asset/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/select2.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/jquery.validate.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/datatables.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
            <script src="{{ asset('asset/js/main.js') }}" type="text/javascript"></script>
            <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
            <script type="text/javascript">
                var url = "{{ URL::asset('') }}";
            </script>
            @routes(['proveedor'])
</body>

</html>