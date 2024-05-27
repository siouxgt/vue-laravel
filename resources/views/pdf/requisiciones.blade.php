<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="{{ asset('asset/css/tienda_urg.css') }}" rel="stylesheet">
        <style>
            body{
                font-size: 10px;
            }
            .cdmx {
                width: 40%;
                height: auto;
            }
            .logos {
                display: flex;
            }
            .justify-content-start {
                justify-content: flex-start!important;
            }
            .justify-content-end {
                justify-content: flex-end!important;
            }
            .text-recha {
                color: #9c2440;
                font-weight: 600;
            }
            .col-md-2 {
                flex: 0 0 16.666667%;
                max-width: 16.666667%;
            }
            .col-md-3 {
                flex: 0 0 25%;
                max-width: 50%;
            }
            .encabezado{
                background-color: #f8f9fa!important;
                border-top: 3px solid #ececec;
                padding: 10px 0px 10px 5px;
                margin: 10px 0px 10px 0px;
                width: 100%;
            }
            .text{
                font-size: 12px;
                font-weight: 600;
                color: #98989a;
            }
            .text-red{
                font-size: 12px;
                color: #9c2440;
                font-weight: 600;
            }
            .text-1{
                font-size: 1rem;
                font-weight: 600;
                color: #98989a;
            }
            table{
                border: 1px solid #dee2e6!important;
            }
            table td{
                border: 1px solid #dee2e6!important;
            }
            .td1{
                width: 200px;
                text-align: left;
            }
            .td3{
                width: 100px;
                text-align: left;
            }
            .td2{
                width: 800px;
                text-align: left;
            }
           .fa-check::before {
             content: "\f00c"; }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="logos col-xs-3 justify-content-start">
                <img class="cdmx" src="{{ asset('asset/img/logoSAFtianguis.png') }}" />
            </div>
            <dic class="col-xs-1"></dic>
            <div class="col-xs-6 justify-content-end" align="right">
                <p class="text-recha">SECRETARIA DE ADMINISTRACIÓN Y FINANZAS DE LA CIUDAD DE MÉXICO</p>
                <p>DIRECCIÓN GENERAL DE ADMINISTRACIÓN Y FINANZAS</p>
                <p>DIRECCIÓN DE RECURSOS MATERIALES, ABASTECIMIENTOS Y SERVICIOS</p>
                <p>SUBDIRECCIÓN DE RECURSOS MATERIALES, ABASTECIMIENTOS Y SERVICIOS</p>
                <p>UNIDAD DEPARTAMENTAL DE COMPRAS Y CONTROL DE MATERIALES</p>
                <p>"GOBIERNO CON ACENTO SOCIAL"</p>
            </div>
        </div>
        <div class="row encabezado">
            <p class="text-1 col-xs-12">COTIZACIÓN   |   {{ $requisicion->urg->nombre }}</p>
        </div>
       <div class="row">
            <table class="border">
                <tr>
                    <td class="text bg-light td1">ID Requisición</td>
                    <td class="text td2">{{ $requisicion->requisicion}}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Objeto de requisición</td>
                    <td class="text td2">{{ $requisicion->objeto_requisicion }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Fecha autorización</td>
                    <td class="text td2">{{ \Carbon\Carbon::parse($requisicion->fecha_autorizacion)->format('d/m/Y') }}</td>
                </tr>
            </table>  
        </div>  
        <div class="row mt-3">
            <table class="border">
                <tr>
                    <td class="text bg-light td1">Monto autorizado</td>
                    <td class="text td2">{{ number_format($requisicion->monto_autorizado,2) }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Monto por confirmar</td>
                    <td class="text td2">$-{{ number_format($requisicion->monto_por_confirmar,2) }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Monto adjudicado</td>
                    <td class="text td2">$-{{ number_format($requisicion->monto_adjudicado,2) }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Monto pagado</td>
                    <td class="text td2">$-{{ number_format($requisicion->monto_pagado,2) }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Monto disponible</td>
                    <td class="text-red td2">${{ number_format($requisicion->monto_disponible,2) }}</td>
                </tr>
            </table>
        </div>
        <div class="row mt-3">
            <table class="border">
                @php($total = 0)
                @foreach($requisicion->clave_partida->clave_partida as $clave_partida)
                <tr>
                    <td class="text bg-light td1">Claves presupuestarias</td>
                    <td>{{ $clave_partida->clave_presupuestaria }}</td>
                    <td class="text bg-light td1">Partida presupuestal</td>
                    <td class="td3">{{ $clave_partida->partida}}</td>
                    <td class="text bg-light td1">Valor estimado</td>
                    <td>${{ number_format($clave_partida->valor_estimado,2) }}</td>
                </tr>
                    @php($total += $clave_partida->valor_estimado)
                @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td>Total</td>
                    <td>${{ number_format($total,2) }}</td>
                </tr>
            </table>
        </div>

        <div class="row d-flex justify-content-center col-12">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="ml-3 mt-3 mr-3">
                    
                   <div class="col-12">
                       <p class="text">
                           <strong>Los bienes y servicios disponibles de esta requisición para Contrato Marco son:</strong>
                       </p>
                   </div>

                   <div class="col-12 mt-5">
                    <input type="hidden" id="requisicion_id" value="{{ $requisicion->id_e}}">
                       <table class="table justify-content-md-center">

                            <thead class="bg-light">
                                <tr>
                                    <th class="text" scope="col">#</th>
                                    <th class="text" scope="col">CABMSCDMX</th>
                                    <th class="text" scope="col">Bien y/o servicio</th>
                                    <th class="text" scope="col">Especificación</th>
                                    <th class="text" scope="col">Unidad de medida</th>
                                    <th class="text" scope="col">Cantidad</th>
                                    <th class="text" scope="col">Cotizar</th>
                                    <th class="text" scope="col">PMR</th>
                                    <th class="text" scope="col">Subtotal PMR</th>
                                    <th class="text" scope="col">IVA PMR</th>
                                    <th class="text" scope="col">Total PMR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalCantidad = 0;
                                    $totalSub = 0;
                                    $totalIva = 0;
                                    $totalTotal = 0;
                                ?>
                                @foreach($bienes as $key => $bien)
                                <tr>
                                    <td class="text">{{ $key+1}}</td>
                                    <td class="text">{{ $bien->cabms }}</td>
                                    <td class="text">{{ $bien->descripcion }}</td>
                                    <td class="text">{{ $bien->especificacion }}</td>
                                    <td class="text">{{ $bien->unidad_medida }}</td>
                                    <td class="text">{{ $bien->cantidad }}</td>
                                    <td class="text">@if($bien->cotizado) Si @endif</td>
                                    <td class="text">${{ number_format($bien->precio_maximo, 2); }}</td>
                                    <td class="text">${{ number_format($bien->subtotal, 2) }}</td>
                                    <td class="text">${{ number_format($bien->iva, 2) }}</td>
                                    <td class="text">${{ number_format($bien->total, 2) }}</td>
                                </tr>
                                    <?php
                                        $totalCantidad += $bien->cantidad;
                                        $totalSub += floatval($bien->subtotal);
                                        $totalIva += floatval($bien->iva);
                                        $totalTotal += floatval($bien->total);
                                    ?>
                                @endforeach
                                <tr>
                                    <td colspan="4"></td>
                                    <td class="text">Totales:</td>
                                    <td class="text">{{ $totalCantidad}}</td>
                                    <td class="text"></td>
                                    <td></td>
                                    <td class="text">${{ number_format($totalSub, 2) }}</td>
                                    <td class="text">${{ number_format($totalIva, 2) }}</td>
                                    <td class="text">${{ number_format($totalTotal, 2) }}</td>
                                </tr>
                                    
                            </tbody>
                        </table>
                   </div>

                </div>
            </div>
        </div>
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $fecha = date("d/m/y");
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(500, 550, "CONTRATO MARCO - REQUISICIONES  |  Página $PAGE_NUM de $PAGE_COUNT  | $fecha" ,$font, 10);
                ');
            }
        </script>
    </body>
</html>