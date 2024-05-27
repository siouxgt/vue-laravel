@extends('layouts.proveedores_ficha_productos')

@section('content')

<div class="separator mb-3 mt-5"></div>
<h1 class="m-2 p-3 mt-1 ml-5">ORDEN DE COMPRA CONFIRMADA</h1>

<div class="row ml-5 mb-4">
    <div class="row col-12 ml-1">
        <div class="col-4 col-md-2">
            <p class="text-1">FECHA DE COMPRA:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ Carbon\Carbon::parse($datosOrdenCompra[0]->fecha_compra)->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="row col-12 ml-1 mt-2">
        <div class="col-4 col-md-2">
            <p class="text-1">FECHA DE ENTREGA:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ Carbon\Carbon::parse($datosFechaEntrega[0]->fecha_entrega)->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="row col-12 ml-1 mt-2">
        <div class="col-4 col-md-2">
            <p class="text-1">ID ORDEN DE COMPRA:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ $datosOrdenCompra[0]->orden_compra }}</p>
        </div>
    </div>

    <div class="row col-12 ml-1 mt-2">
        <div class="col-4 col-md-2">
            <p class="text-1">ID REQUISICIÓN:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ $datosOrdenCompra[0]->requisicion }}</p>
        </div>
    </div>
</div>

<hr>

<div class="row ml-5 mb-4">
    <div class="row col-12 ml-1">
        <div class="col-4 col-md-2">
            <p class="text-1">ENVIAR A NOMBRE DE:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ $datosOrdenCompra[0]->urg }}</p>
        </div>
    </div>
    <div class="row col-12 ml-1 mt-4">
        <div class="col-4 col-md-2">
            <p class="text-1">RESPONSABLE COMPRA:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ $datosOrdenCompra[0]->responsable }}</p>
        </div>
    </div>
    <div class="row col-12 ml-1 mt-4">
        <div class="col-4 col-md-2">
            <p class="text-1">DATOS DE CONTACTO:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ $datosOrdenCompra[0]->correo ."; ". $datosOrdenCompra[0]->telefono ." Ext. ". $datosOrdenCompra[0]->extension }}</p>
        </div>
    </div>
</div>

<hr>

<div class="row ml-5 mb-4">
    <div class="row col-12 ml-1 mt-4">
        <div class="col-4 col-md-2">
            <p class="text-1">ENTREGAR EN:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ strtoupper($datosOrdenCompra[0]->direccion_almacen) }}</p>
        </div>
    </div>
    <div class="row col-12 ml-1 mt-4">
        <div class="col-4 col-md-2">
            <p class="text-1">RESPONSABLE ALMACÉN:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ strtoupper($datosOrdenCompra[0]->responsable_almacen) }}</p>
        </div>
    </div>
    <div class="row col-12 ml-1 mt-4">
        <div class="col-4 col-md-2">
            <p class="text-1">DATOS DE CONTACTO:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ $datosOrdenCompra[0]->correo_almacen ."; ". $datosOrdenCompra[0]->telefono_almacen ." Ext. ". $datosOrdenCompra[0]->extension_almacen  }}</p>
        </div>
    </div>
    <div class="row col-12 ml-1 mt-4">
        <div class="col-4 col-md-2">
            <p class="text-1">CONDICIONES DE ENTREGA:</p>
        </div>
        <div class="col-8 col-md-10">
            <p class="text-1 font-weight-bold">{{ $datosOrdenCompra[0]->condicion_entrega }}</p>
        </div>
    </div>
</div>

<div class="row bg-light">
    <p class="text-1 font-weight-bold ml-5 p-3">{{ $datosOrdenCompra[0]->urg }}</p>
</div>

<div class="row p-5">
<div class="table-responsive">
    <table class="table justify-content-md-center text-1">
        <thead>
            <tr>
                <th scope="col" class="tab-cent text-1 font-weight-bold">PRODUCTO</th>
                <th scope="col" class=" text-1 font-weight-bold">DESCRIPCIÓN</th>
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
                $posicionFotos = ['foto_uno', 'foto_dos', 'foto_tres', 'foto_cuatro', 'foto_cinco', 'foto_seis']; 
                $foto = '';
                $cantidadFinal = 0;
                $subtotalFinal = 0;
                $ivaFinal = 0;
                $totalFinal = 0;
            @endphp
            @for($i = 0; $i < count($productosConfirmados); $i++)
                @php 
                    $subtotalFinal += $productosConfirmados[$i]->subtotal; 
                    $cantidadFinal += $productosConfirmados[$i]->cantidad;
                @endphp
                <tr>
                    <td class="tab-cent col-1">
                        @foreach($posicionFotos as $archivo)
                            @if($productosConfirmados[$i]->$archivo != null)
                                @php 
                                    $foto = $productosConfirmados[$i]->$archivo;
                                    break;
                                @endphp
                            @endif
                        @endforeach       
                        <img src="{{ asset('storage/img-producto-pfp/' . $foto) }}" class="imag-carrito-1 tab-cent text-center" alt="caja de carton">                 
                    </td>
                    <td class="col-3">
                        <div class="col-12">
                            <p class="text-1 font-weight-bold">{{ strtoupper($productosConfirmados[$i]->nombre) }}</p>
                        </div>
                        <div class="col-12 mt-3">
                            <p class="text-1">{{ strtoupper($productosConfirmados[$i]->descripcion_producto) }}</p>
                        </div>
                    </td>
                    <td scope="col" class="tab-cent text-1">{{ $productosConfirmados[$i]->cabms }}</td>
                    <td scope="col" class="tab-cent text-1">{{ strtoupper($productosConfirmados[$i]->medida) }}</td>
                    <td scope="col" class="tab-cent text-1">{{ $productosConfirmados[$i]->cantidad }}</td>
                    <td scope="col" class="tab-cent text-1">${{ number_format($productosConfirmados[$i]->precio, 2) }} x 1 {{ $productosConfirmados[$i]->medida }}</td>
                    <td scope="col" class="tab-cent text-1">${{ number_format($productosConfirmados[$i]->subtotal, 2) }}</td>
                    <td scope="col" class="tab-cent text-1">${{ number_format($productosConfirmados[$i]->iva, 2) }}</td>
                    <td scope="col" class="tab-cent text-1">${{ number_format($productosConfirmados[$i]->total, 2) }}</td>
                </tr>
            @endfor
            @php
                $ivaFinal = ($subtotalFinal * .16);
                $totalFinal = $subtotalFinal + $ivaFinal;
            @endphp

            <tr>
                <td scope="col" class="tab-cent text-1"></td>
                <td scope="col"></td>
                <td scope="col" class="tab-cent"> </td>
                <td scope="col" class="tab-cent"> </td>
                <td scope="col" class="tab-cent text-1">{{ $cantidadFinal }}</td>
                <td scope="col" class="tab-cent"> </td>
                <td scope="col" class="font-weight-bold tab-cent text-1">${{ number_format($subtotalFinal, 2) }}</td>
                <td scope="col" class="font-weight-bold tab-cent text-1">${{ number_format($ivaFinal, 2) }}</td>
                <td scope="col" class="font-weight-bold tab-cent text-1">${{ number_format($totalFinal, 2) }}</td>
            </tr>

            <tr>
                <td class="tab-cent"></td>
                <td></td>
                <td class="tab-cent"> </td>
                <td class="tab-cent"> </td>
                <td class="tab-cent"></td>
                <td class="tab-cent"> </td>
                <td class="font-weight-bold text-right"></td>
                <td class="font-weight-bold text-right">
                    <div class="mt-3 tab-cent text-1">SUBTOTAL</div>
                    <div class="mt-3 tab-cent text-1">16% I.V.A.</div>
                    <div class="mt-3 tab-cent text-1"><span class="text-recha font-weight-bold">TOTAL</span></div>
                </td>
                <td class="font-weight-bold text-right">
                    <div class="mt-3 tab-cent text-1">${{ number_format($subtotalFinal, 2) }}</div>
                    <div class="mt-3 tab-cent text-1">${{ number_format($ivaFinal, 2) }}</div>
                    <div class="mt-3 tab-cent text-1"><span class="text-recha font-weight-bold">${{ number_format($totalFinal, 2) }}</span></div>
                </td>
            </tr>

        </tbody>
    </table>
</div>
</div>

<div class="row float-right mt-3 mx-5">
    <div class="col-6 col-md-6">
        <button type="button" onclick="history.back()" class="btn btn-white boton-7 border" style="font-size: medium;">
            <span>Regresar</span>
        </button>
    </div>
    <div class="col-6 col-md-6">
        <a class="btn btn-white boton-2" style="font-size: medium;" href="{{ route('orden_compra_proveedores.export_orden_confirmada') }}">Descargar Acuse</a>
    </div>
</div>
@endsection

@section('js')
@routes(['ocp'])

@endsection