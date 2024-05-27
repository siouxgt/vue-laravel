@extends('layouts.admin')
    @section('content')

        <div class="separator mb-3 mt-5 col-11 ml-5"></div>
        <h1 class="m-2 p-3 mt-1 ml-5">SOLICITUD DE COMPRA ENVIADA</h1>

        <div class="row ml-5 mb-4">
            <div class="row col-12 ml-1">
                <div class="col-4 col-md-2">
                    <p class="text-1">FECHA DE COMPRA:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <div class="row col-12 ml-1 mt-4">
                <div class="col-4 col-md-2">
                    <p class="text-1">ID ORDEN DE COMPRA:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->orden_compra }}</p>
                </div>
            </div>

            <div class="row col-12 ml-1 mt-4">
                <div class="col-4 col-md-2">
                    <p class="text-1">ID REQUISICIÓN:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->requisicion }}</p>
                </div>
            </div>
        </div>

        <div class="separator mb-4 col-11 ml-5"></div>

        <div class="row ml-5 mb-4">
            <div class="row col-12 ml-1">
                <div class="col-4 col-md-2">
                    <p class="text-1">ENVIAR A NOMBRE DE:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->urg}}</p>
                </div>
            </div>

            <div class="row col-12 ml-1 mt-4">
                <div class="col-4 col-md-2">
                    <p class="text-1">RESPONSABLE COMPRA:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold"> {{ $solicitud->responsable }}</p>
                </div>
            </div>

            <div class="row col-12 ml-1 mt-4">
                <div class="col-4 col-md-2">
                    <p class="text-1">DATOS DE CONTACTO:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->correo . ', ' . $solicitud->telefono . ', Ext. ' . $solicitud->extension }}</p>
                </div>
            </div>
        </div>

        <div class="separator mb-4 col-11 ml-5"></div>

        <div class="row ml-5 mb-4">
            <div class="row col-12 ml-1">
                <div class="col-4 col-md-2">
                    <p class="text-1">ENTREGAR EN:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->direccion_almacen }}</p>
                </div>
            </div>

            <div class="row col-12 ml-1 mt-4">
                <div class="col-4 col-md-2">
                    <p class="text-1">RESPONSABLE ALMACÉN:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->responsable_almacen }}</p>
                </div>
            </div>

            <div class="row col-12 ml-1 mt-4">
                <div class="col-4 col-md-2">
                    <p class="text-1">DATOS DE CONTACTO:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->correo_almacen.', '.$solicitud->telefono_almacen.', EXt. '.$solicitud->extension_almacen}}</p>
                </div>
            </div>

            <div class="row col-12 ml-1 mt-4">
                <div class="col-4 col-md-2">
                    <p class="text-1">CONDICIONES DE ENTREGA:</p>
                </div>
                <div class="col-8 col-md-10">
                    <p class="text-1 font-weight-bold">{{ $solicitud->condicion_entrega }}</p>
                </div>
            </div>
        </div>

        <div class="separator mb-4 col-11 ml-5"></div>
        @php
            $subTotalGeneral = $ivaGeneral = $totalGeneral = 0;
        @endphp
        @foreach($solicitud->producto->producto as $key => $producto)
            <div class="row">
                <div class="col-11 ml-5 bg-light">
                    <p class="text-5 font-weight-bold ml-5 p-3">{{ $producto->proveedor}}</p>
                </div>
            </div>
            <div class="container-fluid p-5">
                <table class="table justify-content-md-center text-1 mt-4">
                    <thead>
                        <tr>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">PRODUCTO</th>
                            <th scope="col" class="text-1 font-weight-bold">DESCRIPCIÓN</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">CABMSCDMX</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">UNIDAD MEDIDA</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">CANTIDAD</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">PRECIO UNITARIO</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">SUBTOTAL</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">16% I.V.A.</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">TOTAL</th>
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
                            @endphp
                            <td class="tab-cent col-1">
                                <img src="{{ asset('storage/img-producto-pfp/'. $bien->imagen) }}" class="imag-carrito-1 tab-cent text-center" alt="Foto">
                            </td>
                            <td>
                                <div class="col-12">
                                    <p class="text-1 font-weight-bold">{{ $bien->nombre }}</p>
                                </div>
                                <div class="col-12 mt-3">
                                    <p class="text-1">
                                        {{ strtoupper($bien->marca) .', ' . strtoupper($bien->tamanio) .', '. strtoupper($bien->color) }}
                                    </p>
                                </div>
                            </td>
                            <td class="tab-cent col-1 text-1">{{ $bien->cabms }}</td>
                            <td class="tab-cent col-1 text-1">{{ $bien->unidad_medida }}</td>
                            <td class="tab-cent col-1 text-1">{{ $bien->cantidad }}</td>
                            <td class="tab-cent col-1 text-1">${{ number_format($bien->precio,2) .' x '. $bien->unidad_medida}}</td>
                            <td class="tab-cent col-1 text-1">${{ number_format($subTotalBien,2) }}</td>
                            <td class="tab-cent col-1 text-1">${{ number_format($ivaBien,2) }}</td>
                            <td class="tab-cent col-1 text-1">${{ number_format($totalBien,2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                           <td class="tab-cent text-1"></td>
                           <td></td>
                           <td class="tab-cent text-1"> </td>
                           <td class="tab-cent text-1"> </td>
                           <td class="tab-cent text-1">{{ $cantidad }}</td>
                           <td class="tab-cent text-1"> </td>
                           <td class="font-weight-bold tab-cent text-1">${{ number_format($subTotal, 2) }}</td>
                           <td class="font-weight-bold tab-cent text-1">${{ number_format($iva, 2) }}</td>
                           <td class="font-weight-bold tab-cent text-1">${{ number_format($total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>    
            </div>
        @endforeach
        <div class="container-fluid">
            <table class="table justify-content-md-center text-1 mt-4">
                <tbody>
                    <tr>
                        <td class="tab-cent"></td>
                        <td></td>
                        <td class="tab-cent"></td>
                        <td class="tab-cent"></td>
                        <td class="tab-cent"></td>
                        <td class="tab-cent"></td>
                        <td class="font-weight-bold text-right"></td>
                        <td class="font-weight-bold text-right">
                            <div class="mt-3 text-1">SUBTOTAL</div>
                            <div class="mt-3 text-1">16% I.V.A.</div>
                            <div class="mt-3 text-1"><span class="text-recha font-weight-bold">TOTAL</span></div>
                        </td>
                        <td class="font-weight-bold text-right">
                            <div class="mt-3 text-1">${{ number_format($subTotalGeneral, 2) }}</div>
                            <div class="mt-3 text-1">${{ number_format($ivaGeneral, 2) }}</div>
                            <div class="mt-3 text-1"><span class="text-recha font-weight-bold">${{ number_format($totalGeneral, 2) }}</span></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row float-right mt-3">
            <div class="col-6 col-md-6">
                <a href="javascript: void(0);" onclick="history.back()" class="btn btn-white boton-7 border">
                    <span id="text-seguir">Regresar</span>
                </a>
            </div>
            <div class="col-6 col-md-6">
                <form action="{{ route('solicitud_compra.export') }}" method="POST">
                @csrf
                    <input type="hidden" value="{{ $solicitud->id_e }}" name="solicitud">
                    <button type="submit" id="btn_descargar_acuse" class="btn btn-white boton-2">
                        <span>Descargar Acuse</span>
                    </button>
                </form>
            </div>
        </div>

    @endsection