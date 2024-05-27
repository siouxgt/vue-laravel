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
         table {
            border: 1px solid #dee2e6 !important;
            width: 100%;
            font-size: 10px;
        }

        table tr td{
            border: 1px solid #dee2e6 !important;
            font-size: 10px;
        }

        table tr th{
            border: 1px solid #dee2e6 !important;
            color: #4c4b4b !important;
            font-size: 10px;
        }
         .text-center{
            text-align: center !important;
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
                <p class="text-right"><strong>Ciudad de México, {{ $sustitucion->created_at->format('d/m/Y') }}.</strong></p>
            </div>
        </header>

        <div class="row mt-5">
            <div class="col-12">
                <p>
                    <strong>
                        {{ $sustitucion->proveedor->nombre_legal . ' ' . $sustitucion->proveedor->primer_apellido_legal . ' ' . $sustitucion->proveedor->segundo_apellido_legal }}
                        <br>
                        REPRESENTANTE LEGAL DE<br>
                        {{ $sustitucion->proveedor->nombre }}<br>
                        P R E S E N T E.
                    </strong>
                </p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <p class="text-justify">
                    En relación con la Orden de Compra <strong>{{ $sustitucion->ordencompra->orden_compra}}</strong> correspondiente al Contrato Pedido <strong>{{ $contrato->contrato_pedido }}</strong> cuya fecha de entrega fue el día <strong>{{ $envio->fecha_entrega_aceptada->format('d/m/Y') }}</strong>, por medio de la presente, nos dirigimos a usted para comunicarle que debido a <strong>{{ $sustitucion->motivo }}</strong> requerimos se realice la sustitución de los siguientes bienes antes de los 5 días hábiles siguientes a la recepción de la presente solicitud, de acuerdo con lo establecido en los lineamientos de la plataforma Tienda Digital "CDMX Compra". 
                </p>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <table>
                    <thead>
                        <th>NO.</th>
                        <th>PARTIDA</th>
                        <th>DESCRIPCION DE LOS BIENES Y/O SERVICIO</th>
                        <th>MARCA Y/O MODELO</th>
                        <th>CANTIDAD</th>
                        <th>UNIDAD DE MEDIA</th>
                        <th>PRECIO UNITARIO</th>
                    </thead>
                    <tbody>
                        @foreach($bienes as $key => $bien)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ substr($bien->cabms,0,4) }}</td>
                                <td>{{ $bien->descripcion_producto }}</td>
                                <td>{{ $bien->marca }} / {{ $bien->modelo}}</td>
                                <td>{{ $bien->cantidad }}</td>
                                <td>{{ $bien->medida }}</td>
                                <td>${{ number_format($bien->precio) }}</td> 
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td colspan="3" rowspan="3" class="text-center">{{ strtoupper($totalLetra) }} PESOS {{$decimal}}/100 M.N.</td>
                            <td colspan="2">SUBTOTAL</td>
                            <td>${{ number_format($subtotal,2) }}</td>
                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2">I.V.A</td>
                                <td>${{ number_format($subtotal * .16,2) }}</td>    
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2">TOTAL</td>
                                <td>${{ number_format(($subtotal * .16) + $subtotal,2) }}</td>    
                            </tr>
                        </tr>                       
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-5">
                <p class="text-center">A T E N T A M E N T E</p>
            </div>
        </div>

        <footer class="row">
            <div class="col-12 mt-4" >
                <p class="text-center">
                    <strong>
                        {{ $sustitucion->urg->nombre }}<br>
                        {{ $sustitucion->usuario->nombre }} {{ $sustitucion->usuario->primer_apellido }} {{ $sustitucion->usuario->segundo_apellido }}<br>
                        {{ $sustitucion->usuario->cargo }} <br>
                    </strong>
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
