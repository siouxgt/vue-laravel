@extends('layouts.urg')
    @section('content')

    <div class="separator mb-3 mt-5"></div>

    <div class="row">
        <div class="col-lg-7 col-md-12 col-sm-12 ml-3">
            <h1 class="mb-2">CONFIRMACIÓN DE ORDEN DE COMPRA</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-md-12 col-sm-12 ml-3 mb-3">
            <form action="{{ route('solucitud_compra.store') }}" id="frm_confirmar" method="POST">
                @csrf
                <div class=" bg-light border rounded bg-light mb-4">
                    <div>
                        <p class="text-1 font-weight-bold ml-3 mt-3">1. Información de la Unidad Responsable de Gasto</p>
                    </div>
                    <div class="badge-light m-4">
                        <label for="text" class="text-1">Enviar a nombre de:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend ">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-building text-1"></i></span>
                            </div>
                            <input class="form-control" type="text" value="{{ auth()->user()->urg->ccg}} - {{ auth()->user()->urg->nombre }}" name="ccg" readonly>
                        </div>
                    </div>
                    <div class="badge-light m-4">
                        <label for="text" class="text-1">Responsable de la compra:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user text-1"></i></span>
                            </div>
                            <input class="form-control code" type="text" value="{{auth()->user()->nombre . ' ' . auth()->user()->primer_apellido . ' ' . auth()->user()->segundo_apellido}}" name="responsable" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="badge-light ml-4 col-auto col-md-3">
                            <label for="text" class="text-1">Teléfono:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone text-1"></i></span>
                                </div>
                                <input class="form-control" type="text" value="{{ auth()->user()->telefono }}" name="telefono" readonly>
                            </div>
                        </div>
                        <div class="badge-light ml-4 col-auto col-md-3">
                            <label for="text" class="text-1">Extensión</label>
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" value="{{ auth()->user()->extension }}" name="extension" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="badge-light ml-2 col-6">
                        <label for="text" class="text-1">Correo electrónico:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope text-1"></i></span>
                            </div>
                            <input class="form-control" type="text" value="{{ auth()->user()->email }}" name="correo" readonly>
                        </div>
                    </div>
                </div>

        
                <div class=" bg-light border rounded mb-4 mt-4">
                    <div>
                        <p class="text-1 font-weight-bold ml-3 mt-3">2. Información de entrega</p>
                    </div>
                    <div class="input-group mb-3 mt-3 col-auto">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="direccion"><i class="fa-solid fa-location-dot text-1"></i></label>
                        </div>
                        <select class="custom-select text-2" id="direccion" name="direccion">
                            <option value="">Seleccione una dirección</option>
                            @foreach($direcciones['almacenes'] as $direccion)
                                <option value="{{ $direccion['direccion'] }}" data="{{ $direccion['responsable'] }}">{{ $direccion['direccion'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="badge-light m-1 col-6">
                        <label for="text" class="text-1">Responsable del almacén:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user text-1"></i></span>
                            </div>
                            <input type="text" class="form-control" id="responsable_almacen" name="responsable_almacen" placeholder="NOMBRE DEL RESPONSABLE DE ALMACEN" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="badge-light ml-4 col-auto col-md-3">
                            <label for="text" class="text-1">Teléfono:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone text-1"></i></span>
                                </div>
                                <input type="number" class="form-control" id="telefono_almacen" name="telefono_almacen">
                            </div>
                        </div>
                        <div class="badge-light ml-4 col-auto col-md-3">
                            <label for="text" class="text-1">Extensión</label>
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="extension_almacen" name="extension_almacen">
                            </div>
                        </div>
                    </div>
                    <div class="badge-light ml-2 col-6">
                        <label for="text" class="text-1">Correo electrónico:</label>
                        <div class="input-group mb-3" style="height: 30px;">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-regular fa-envelope text-1"></i></span>
                            </div>
                            <input type="email" class="form-control" id="correo_almacen" name="correo_almacen" placeholder="ejemplo@ejemplo.com">
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="text" class="text-1 ml-4">Condiciones de entrega</label>
                        <div class="col-12">
                            <textarea class="form-control mb-4 ml-1" id="condiciones_entrega" name="condiciones_entrega" placeholder="Menciona las condiciones en las que se tiene que realizar la entrega."></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="productos" name="productos">
            </form>

            <input type="hidden" id="cantidad_req" value="{{count($datos_carrito)}}">

            @php $numeracion = 0; @endphp
            @for($i = 0; $i < count($datos_carrito); $i++)<!---->
                <div class="row col-12 border rounded bg-light ml-0">
                
                    <div class="row m-2">
                        <p class="text-recha font-weight-bold">ID REQUISICIÓN: {{$datos_carrito[$i]["nombre_requisicion"]}}</p>
                    </div>
                    @for($j = 0; $j < count($datos_carrito[$i]['proveedores']); $j++)<!---->
                        <div class="col-12 bg-white border rounded ml-1 p-2 mb-4">
                            <p class="text-1"><strong>PROVEEDOR: {{$datos_carrito[$i]['proveedores'][$j]['nombre_proveedor']}}</strong></p>
                            @for($k = 0; $k < count($datos_carrito[$i]['proveedores'][$j]['datos']); $k++)<!---->
                                <input type="hidden" id="id_de_producto_{{$numeracion}}" value="{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['carrito_compra_id']}}">
                                <hr>
                                <p class="text-2">{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['cabms']}} - {{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['nombre_corto']}}</p>
                                <div class="row mt-2 d-flex align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ asset('storage/img-producto-pfp/'. $datos_carrito[0]['proveedores'][$j]['datos'][$k]['foto_uno']) }}" class="imag-carrito-1 ml-3" alt="Foto">
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-2">{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['marca']}}</p>
                                        <p class="text-1 font-weight-bold">{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['nombre_producto']}}</p>
                                        <p class="text-2">Tamaño: {{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['tamanio']}}</p>
                                        <p class="text-2 mt-3">Color: {{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['color']}}</p>
                                    </div>                                
                                    <div class="col-md-2">
                                        <p class="text-1">{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['cantidad_producto']}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="text-1">${{ number_format($datos_carrito[$i]['proveedores'][$j]['datos'][$k]['precio_unitario'], 2) }} x 1 {{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['medida']}}}</p>
                                    </div>
                                </div>
                                @php $numeracion++; @endphp
                            @endfor
                        </div>
                    @endfor                    
                </div>
            @endfor
            <input type="hidden" id="cantidad_elementos" value="{{$numeracion}}">
        </div>

        <div class="card col-lg-4 col-md-12 col-sm-12 bg-white ml-3 px-3">
            <h5 class="card-header border">
                <p class="text-1 font-weight-bold m-2">Desglose de precios</p>
            </h5>
            <div class="card-body-4">
                <ul class="list-group list-group-flush bg-white border">
                    @for($j = 0; $j < count($datos_carrito[0]['proveedores']); $j++)<!---->
                        <li class="list-group-item bg-white mt-2">
                            <p class="text-2 font-weight-bold">{{ $datos_carrito[0]['proveedores'][$j]['nombre_proveedor'] }}</p>
                        </li>
                        <li class="list-group-item bg-white">
                            <p class="text-1 float-right">Subtotal: <span class="font-weight-bold">${{ number_format($datos_carrito[0]['proveedores'][$j]['subtotal_proveedor'], 2) }}</span></p>
                        </li>
                        <li class="list-group-item bg-white">
                            <p class="text-1 float-right">IVA al 16%: <span class="font-weight-bold">${{ number_format($datos_carrito[0]['proveedores'][$j]['iva_proveedor'], 2) }}</span></p>
                        </li>
                        <li class="list-group-item bg-white">
                            <p class="text-1 float-right">Total: <span class="font-weight-bold">${{ number_format($datos_carrito[0]['proveedores'][$j]['total_proveedor'], 2) }}</span></p>
                        </li>
                    @endfor
                    <span class="border-bottom"></span>
                    <li class="list-group-item bg-light border-bottom">
                        <div class="row">
                            <div class="col-md-12 col-lg-4 col-sm-6">
                                <p class="text-1 font-weight-bold">Subtotal:</p>
                            </div>
                            <div class="col-md-12 col-lg-8 col-sm-6 float-right">
                                <p class="text-1 text-right font-weight-bold ml-5">${{ number_format($datos_carrito[0]['subtotal_general'], 2) }}</p>
                            </div>
                        </div>
                        <div class="row mt-3 ">
                            <div class="col-md-12 col-lg-4 col-sm-6">
                                <p class="text-1 font-weight-bold">16% I.V.A.</p>
                            </div>
                            <div class="col-md-12 col-lg-8 col-sm-6 float-right">
                                <p class="text-1 text-right font-weight-bold ml-5">${{ number_format($datos_carrito[0]['iva_general'], 2) }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 col-lg-4 col-sm-6">
                                <p class="text-1 font-weight-bold">TOTAL</p>
                            </div>
                            <div class="col-md-12 col-lg-8 col-sm-6 float-right">
                                <p class="text-rojo text-right font-weight-bold ml-5">${{ number_format($datos_carrito[0]['total_general'], 2) }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="row d-flex align-items-center mt-3">
                <div class="col-lg-2 col-md-2 col-sm-2">
                    <input class="form-check-input text-center ml-3" type="checkbox" id="chk_confirmacion">
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9">
                    <p class="text-1 font-weight-bold">Confirmación de terminos y condiciones.</p>
                    <p class="text-1 mt-1">Confirmo que he leído y aceptado los términos y condiciones.</p>
                </div>
            </div>
            <div class="mb-4">
                <div class="row mt-3 rounded m-4 bac-red text-center">
                    <div class="col-12 m-2 text-center">
                        <a href="javascript: void(0)" id="btn_finalizar_compra">
                            <p class="text-carrito">Finalizar compra</p>
                        </a>
                    </div>
                </div>
                <a href="{{ route('carrito_compra.index') }}" id="btn_editar_carrito">
                    <p class="mt-2 text-gold text-center">Editar carrito</p>
                </a>
            </div>
        </div>
    </div>

    @endsection
    @section('js')
        @routes(['solicitudCompra', 'tiendaUrg'])
        <script src="{{ asset('asset/js/carrito_compra_confirmacion.js') }}" type="text/javascript"></script>
    @endsection