<!DOCTYPE html>
<html lang="es">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link href="{{ asset('asset/css/tienda_urg.css') }}" rel="stylesheet">
        <style>
            body {
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
                justify-content: flex-start !important;
            }

            .justify-content-end {
                justify-content: flex-end !important;
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

            .encabezado {
                background-color: #f8f9fa !important;
                border-top: 3px solid #ececec;
                padding: 10px 0px 10px 5px;
                margin: 10px 0px 10px 0px;
                width: 100%;
            }

            .text {
                font-size: 12px;
                font-weight: 600;
                color: #98989a;
            }

            .text-red {
                font-size: 12px;
                color: #9c2440;
                font-weight: 600;
            }

            .text-1 {
                font-size: 1rem;
                font-weight: 600;
                color: #98989a;
            }

            table {
                border: 1px solid #dee2e6 !important;
            }

            table tr {
                border: 1px solid #dee2e6 !important;
            }

            .td1 {
                width: 200px;
                text-align: left;
            }

            .td3 {
                width: 100px;
                text-align: left;
            }

            .td2 {
                width: 800px;
                text-align: left;
            }

            b {
                color: #4c4b4b;
            }

            table th {
                color: #4c4b4b !important;   
            }

            .text-right {
                text-align: right!important;
            }

            .font-weight-bold {
                font-weight: 700!important;
            }
        </style>
    </head>

    <body>
        <div class="row">
            <div class="logos col-xs-3 justify-content-start">
                <img class="cdmx" src="{{ asset('asset/img/logoSAFtianguis.png') }}" />
            </div>
            <div class="col-xs-1"></div>
            <div class="col-xs-6 justify-content-end" align="right">
                <p class="text-recha">SECRETARIA DE ADMINISTRACIÓN Y FINANZAS DE LA CIUDAD DE MÉXICO</p>
                <p>DIRECCIÓN GENERAL DE ADMINISTRACIÓN Y FINANZAS</p>
                <p>DIRECCIÓN DE RECURSOS MATERIALES, ABASTECIMIENTOS Y SERVICIOS</p>
                <p>SUBDIRECCIÓN DE RECURSOS MATERIALES, ABASTECIMIENTOS Y SERVICIOS</p>
                <p>UNIDAD DEPARTAMENTAL DE COMPRAS Y CONTROL DE MATERIALES</p>
                <p>"MÉXICO TENOCHTITLAN, SIETE SIGLOS DE HISTORIA"</p>
            </div>
        </div>
        <div class="row">
            <p class="text-1 col-11  encabezado">SOLICITUD DE COMPRA ENVIADA</p>
        </div>
        <div class="row">
            <table class="border">
                <tr>
                    <td class="text bg-light td1">Fecha de compra</td>
                    <td class="text td2">{{ $solicitud->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">ID Orden de compra</td>
                    <td class="text td2">{{ $solicitud->orden_compra }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">ID Requisición</td>
                    <td class="text td2">{{ $solicitud->requisicion }}</td>
                </tr>
            </table>
        </div>
        <div class="row mt-3">
            <table class="border">
                <tr>
                    <td class="text bg-light td1">Enviar a nombre de</td>
                    <td class="text td2"><b>{{ $solicitud->urg }}</b></td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Responsable compra</td>
                    <td class="text td2">{{ $solicitud->responsable }}</td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Datos de contacto</td>
                    <td class="text td2">{{ $solicitud->correo ."; ". $solicitud->telefono ." Ext. ". $solicitud->extension }}</td>
                </tr>
            </table>
        </div>
        <div class="row mt-3">
            <table class="border">
                <tr>
                    <td class="text bg-light td1">Entregar en</td>
                    <td class="text td2"><b>{{ $solicitud->direccion_almacen }}</b></td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Responsable almacén</td>
                    <td class="text td2"><b>{{ $solicitud->responsable_almacen }}</b></td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Datos de contacto</td>
                    <td class="text td2"><b>{{ $solicitud->correo_almacen ."; ". $solicitud->telefono_almacen ." Ext. ". $solicitud->extension_almacen  }}</b></td>
                </tr>
                <tr>
                    <td class="text bg-light td1">Condiciones de entrega</td>
                    <td class="text td2">{{ $solicitud->condicion_entrega }}</td>
                </tr>
            </table>
        </div>
        @php 
            $totalCantidad = $subTotalGeneral = $ivaGeneral = $totalGeneral = 0;
        @endphp
        @foreach($solicitud->producto->producto as $key => $producto)
            <div class="row">
                <div class="col-11 ml-4 bg-light">
                    <p class="text-5 font-weight-bold ml-2 p-3">{{ $producto->proveedor}}</p>
                </div>
            </div>
            <div class="container-fluid p-2">
                <table class="table justify-content-md-center mt-2">
                    <thead>
                        <tr>
                            <th scope="col" class="tab-cent text font-weight-bold">PRODUCTO</th>
                            <th scope="col" class="text font-weight-bold">DESCRIPCIÓN</th>
                            <th scope="col" class="tab-cent text font-weight-bold">CABMSCDMX</th>
                            <th scope="col" class="tab-cent text font-weight-bold">UNIDAD MEDIDA</th>
                            <th scope="col" class="tab-cent text font-weight-bold">CANTIDAD</th>
                            <th scope="col" class="tab-cent text font-weight-bold">PRECIO UNITARIO</th>
                            <th scope="col" class="tab-cent text font-weight-bold">SUBTOTAL</th>
                            <th scope="col" class="tab-cent text font-weight-bold">16% I.V.A.</th>
                            <th scope="col" class="tab-cent text font-weight-bold">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $cantidad = $subTotalBien = $ivaBien = $totalBien = $subTotal = $iva = $total =  0;
                        @endphp
                        @foreach($producto->data as $bien)
                            <tr>
                                @php
                                    $cantidad += $bien->cantidad; 
                                    $subTotalBien = $bien->precio * $bien->cantidad;
                                    $ivaBien = ($bien->precio * $bien->cantidad) * .16;  
                                    $totalBien = $subTotalBien + $ivaBien;
                                    $subTotal += $subTotalBien; 
                                    $iva += $ivaBien; 
                                    $total += $totalBien;
                                    $subTotalGeneral += $subTotalBien;
                                    $ivaGeneral += $ivaBien;
                                    $totalGeneral += $totalBien;
                                    $totalCantidad += $cantidad;
                                @endphp
                                <td class="tab-cent col-1">
                                    <img src="{{ asset('storage/img-producto-pfp/'. $bien->imagen) }}" class="imag-carrito-1 tab-cent text-center" alt="Foto">
                                </td>
                                <td>
                                    <div class="col-12">
                                        <p class="text font-weight-bold"><b>{{ $bien->nombre }}</b></p>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <p class="text">
                                            {{ strtoupper($bien->marca) .', ' . strtoupper($bien->tamanio) .', '. strtoupper($bien->color) }}
                                        </p>
                                    </div>
                                </td>
                                <td class="tab-cent col-1 text">{{ $bien->cabms }}</td>
                                <td class="tab-cent col-1 text">{{ $bien->unidad_medida }}</td>
                                <td class="tab-cent col-1 text">{{ $bien->cantidad }}</td>
                                <td class="tab-cent col-1 text">${{ number_format($bien->precio,2) .' x '. $bien->unidad_medida}}</td>
                                <td class="tab-cent col-1 text">${{ number_format($subTotalBien,2) }} </td>
                                <td class="tab-cent col-1 text">${{ number_format($ivaBien,2) }}</td>
                                <td class="tab-cent col-1 text">${{ number_format($totalBien,2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="tab-cent text"></td>
                            <td></td>
                            <td class="tab-cent text"> </td>
                            <td class="tab-cent text"> </td>
                            <td class="tab-cent text"><b>{{ $cantidad }}</b></td>
                            <td class="tab-cent text"> </td>
                            <td class="font-weight-bold tab-cent text"><b>${{ number_format($subTotal, 2) }}</b></td>
                            <td class="font-weight-bold tab-cent text"><b>${{ number_format($iva, 2) }}</b></td>
                            <td class="font-weight-bold tab-cent text"><b>${{ number_format($total, 2) }}</b></td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        @endforeach
        <div class="container-fluid">
            <table class="table justify-content-md-center">
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="tab-cent text">{{ $totalCantidad}}</td>
                        <td>
                            <div class="mt-1 text text-right">SUBTOTAL</div>
                            <div class="mt-1 text text-right">16% I.V.A.</div>
                            <div class="mt-1 text text-right"><span class="font-weight-bold">TOTAL</span></div>
                        </td>
                        <td>
                            <div class="mt-1 text text-right"><b>${{ number_format($subTotalGeneral, 2) }}</b></div>
                            <div class="mt-1 text text-right"><b>${{ number_format($ivaGeneral, 2) }}</b></div>
                            <div class="mt-1 text text-right"><b><span class="font-weight-bold">${{ number_format($totalGeneral, 2) }}</span></b></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $fecha = date("d/m/y");
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(420, 550, "CONTRATO MARCO - SOLICITUD DE COMPRA ENVIADA  |  Página $PAGE_NUM de $PAGE_COUNT  | $fecha" ,$font, 10);
                ');
            }
        </script>
    </body>

</html>