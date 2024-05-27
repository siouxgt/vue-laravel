<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .cdmx {
            width: 40%;
            height: auto;
        }
    </style>

</head>


<body>
    <div class="container">
        <header class="row mt-5">
            <div class="col-12">
                <img class="cdmx" src="{{ asset('asset/img/gobierno_cdmx.png') }}" />
            </div>
             <div class="col-12">
                <p class="text-right"><strong>Ciudad de México, {{ $prorroga->fecha_aceptacion->format('d/m/Y') }}.</strong></p>
            </div>
        </header>

        <div class="row mt-5">
            <div class="col-12">
                <p>
                    <strong>
                        {{ $prorroga->proveedor->nombre_legal . ' ' . $prorroga->proveedor->primer_apellido_legal . ' ' . $prorroga->proveedor->segundo_apellido_legal }}
                        <br>
                        REPRESENTANTE LEGAL DE<br>
                        {{ $prorroga->proveedor->nombre }}<br>
                        P R E S E N T E.
                    </strong>
                </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <p class="text-justify">
                    Refiriendo a la solicitud de prórroga que se remitió vía sistema el día <strong>{{ $prorroga->created_at->format('d/m/Y') }}</strong> para la extensión del plazo de entrega de lo solicitado y acordado en el Contrato Pedido <strong>{{ $prorroga->num_contrato_pedido }}</strong> debido a <strong>{{ $prorroga->descripcion}}</strong>, el personal de la Dirección General de Administración y Finanzas u Homóloga de <strong>{{ $prorroga->unidad_administrativa }}</strong> da por <strong>@if($prorroga->estatus == 1)ACEPTADA @else RECHAZADA @endif </strong> dicha solicitud. @if($prorroga->estatus == 1)Por tanto, mostramos conformidad con que la fecha de entrega sea el día <strong>{{ $prorroga->fecha_entrega_compromiso->format('d/m/Y') }} </strong> @endif 
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12" style="top: 5rem">
                <p class="text-center">A T E N T A M E N T E</p>
            </div>
        </div>

        <footer class="row">
            <div class="col-12" style="top: 300px">
                <p class="text-center">
                    <strong>
                        {{ $prorroga->nombre_firma }}<br>
                        {{ $prorroga->cargo_firma  }} <br>
                        {{ $prorroga->correo_firma }}
                    </strong>
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
