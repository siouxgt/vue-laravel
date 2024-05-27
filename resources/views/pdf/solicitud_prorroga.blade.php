<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <header class="row mt-5">
            <div class="col-12">
                <p class="text-right"><strong>Ciudad de México, {{ $fecha }}.</strong></p>
            </div>
        </header>

        <div class="row mt-5">
            <div class="col-12">
                <p>
                    <strong>
                        {{ $consultaTitular[0]->nombre . ' ' . $consultaTitular[0]->primer_apellido . ' ' . $consultaTitular[0]->segundo_apellido }}
                        <br>
                        DIRECTOR(a) GENERAL DE ADMINISTRACIÓN<br>
                        Y FINANZAS U HOMÓLOGO(a) DE {{ $consultaTitular[0]->puesto }}<br>
                        P R E S E N T E.
                    </strong>
                </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <p class="text-justify">
                    En relación con la Orden de Compra <b>{{ $contrato->orden_compra }}</b> correspondiente al Contrato Pedido
                    <b>{{ $contrato->contrato_pedido }}</b> cuya fecha de entrega quedó establecida para el día
                    <b>{{ Carbon\Carbon::parse($fechas[0]->fecha_entrega)->format('d/m/Y') }}</b>, por medio de la
                    presente, nos dirigimos a usted para comunicarle que por este motivo:
                    <b>{{ $consultaProrroga[0]->descripcion }}</b>,
                    no será posible entregar lo solicitado en la fecha acordada.
                    Derivado de lo anterior, solicitamos que nos otorgue una prórroga de
                    <b>{{ $consultaProrroga[0]->dias_solicitados }}</b> día(s), proponiendo
                    como la nueva fecha de entrega el día
                    <b>{{ Carbon\Carbon::parse($consultaProrroga[0]->fecha_entrega_compromiso)->format('d/m/Y') }}</b>.
                </p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <p class="text-justify">
                    Sin otro particular, agradecemos su atención y dejamos adjuntos los datos de registro como
                    proveedores en Contrato Marco, para cualquier aclaración
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
                        {{ $consultaProveedor[0]->nombre . ' ' . $consultaProveedor[0]->primer_apellido . ' ' . $consultaProveedor[0]->segundo_apellido }}<br>
                        REPRESENTANTE LEGAL DE {{ $consultaProveedor[0]->correo }}<br>
                        {{ $consultaProveedor[0]->correo }}
                    </strong>
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
