<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Correo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 20px;
        }

        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
        }

        /* Clearfix (clear floats) */
        .row::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 500px) {
            .column {
                width: 100%;
            }
        }

        .top {
            height: 4.0rem;
            background: #fff;
            border-bottom: 1px solid #DEE2E6;
            align-items: left;
            padding: 0rem 0rem;
            margin-bottom: 20px;
        }

        .cdmx {
            width: 200px;
            height: auto;
            float: left;
            padding-left: 20px;
        }

        .saf {
            width: 140px;
            height: auto;
            float: left;
            padding-left: 0px;
        }

        .tianguis {
            width: 90px;
            height: auto;
            float: left;
            padding: 5px 0 0 15px;
        }

        .content-box {
            font-size: 0.9rem;
            color: #6F7271;
            line-height: 1.5;
            overflow-wrap: break-word;
        }

        .titulo1 {
            font-size: 1.3rem;
            color: #9f2241;
            font-weight: 400;
            line-height: 2.0;
        }

        h3.subtitulo-gris {
            color: #6F7271;
            font-size: 1.0rem;
            font-weight: bold;
            line-height: 3.0;
        }
    </style>
</head>

<body>
    <header>
        <div class="row top col-12 col-md-6">
            <div class="column">
                <img src="https://s3.amazonaws.com/cdmxassets/themes/base/assets/images/logos/Logo_CDMX_alt.png" alt="CDMX" class="cdmx" />
            </div>
            <div class="column">
                <img src="https://s3.amazonaws.com/cdmxassets/themes/base/assets/images/logos/Logo_Dependencia_alt.png" alt="SAF" class="saf" />
            </div>
            <div class="column">
                <img src="https://www.tianguisdigital.cdmx.gob.mx/public/images/logo-lg.svg" alt="Tianguis Digital" class="tianguis" />
            </div>
        </div>
    </header>
    <section class="content-box col-12 col-md-6">
        <h1 class="titulo1 d-flex align-items-end text-uppercase text-center">Registro a Contratos Marco</h1>
        <h3 class="subtitulo-gris text-uppercase">Hola, {{ $mailData['name'] }}.</h3>

        <p>
            Te damos la bienvenida a Contratos Marco de la Administración Pública de la Ciudad de México.
        </p>
        <p>
            Para completar tu registro ingresa el siguiente código: <strong>{{ $mailData['code'] }}</strong>
        </p>
        <p>
            Para acceder a tu cuenta, utiliza el Registro Federal de Contribuyentes (R.F.C.) de la persona física o moral que realizó el registro y la contraseña será la misma que se utiliza para acceder al Padrón de Proveedores
        </p>
        <p>
            Si tiene dudas o comentarios, puedes contactarnos al siguiente correo electrónico <a href="mailto:mesadeservicio@finanzas.cdmx.gob.mx" style="color:#BC955C; font-weight: bold;">mesadeservicio@finanzas.cdmx.gob.mx</a>
        </p>
    </section>
    <section class="content-box col-12 col-md-6 font-weight-bold" style="margin: 50px 0px;">
        <p>Atentamente,</p>
        <p>
            Dirección General de Recursos Materiales y Servicios Generales
            <br>
            Secretaría de Administración y Finanzas
            <br>
            Gobierno de la Ciudad de México
        </p>
    </section>
    <footer class="content-box col-12 col-md-6 text-center" style="padding-top:12px; background-color: #10312B; border-bottom:10px solid #235B4E; color: #fff; font-size: 0.8rem">
        <p>Viaducto Río de la Piedad, número 515, PB
            Granjas México, Alcaldía Iztacalco, 08400, CDMX.
        </p>
    </footer>
</body>

</html>