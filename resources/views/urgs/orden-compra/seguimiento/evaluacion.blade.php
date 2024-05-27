@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <p class="text-1 text-center mt-4">Evalúa tu experiencia de compra y al proveedor. La evaluación de los productos es opcional.</p>

                <hr>
                <form action="{{ route('orden_compra_urg.evaluacion_save') }}" method="POST">
                    @csrf
                    <div class="col text-center mb-3">
                        <p class="text-14">1. ¿Qué calificación general le darías al proveedor?</p>
                        <div class="col-sm-4 col-md-12 col-gl-12 mt-2">
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaG"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaG"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaG"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaG"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaG"></i>
                            <input type="hidden" name="calificacion_general" id="estrellaG">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col ml-3">
                            <p class="text-1 ml-5">Comunicación</p>
                        </div>
                        <div class="col">
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaC"></i></a>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaC"></i></a>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaC"></i></a>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaC"></i></a>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaC"></i></a>
                            <input type="hidden" name="calificacion_comunicacion" id="estrellaC">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col ml-3">
                            <p class="text-1 ml-5">Calidad/Precio</p>
                        </div>
                        <div class="col">
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaCP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaCP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaCP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaCP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaCP"></i>
                            <input type="hidden" name="calificacion_calidad" id="estrellaCP">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col ml-3">
                            <p class="text-1 ml-5">Tiempo de entrega</p>
                        </div>
                        <div class="col">
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaT"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaT"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaT"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaT"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaT"></i>
                            <input type="hidden" name="calificacion_tiempo" id="estrellaT">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col ml-3">
                            <p class="text-1 ml-5">Mercancía en buen estado</p>
                        </div>
                        <div class="col">
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaM"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaM"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaM"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaM"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaM"></i>
                            <input type="hidden" name="calificacion_mercancia" id="estrellaM">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col ml-3">
                            <p class="text-1 ml-5">Facturas correctas</p>
                        </div>
                        <div class="col">
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaF"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaF"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaF"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaF"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaF"></i>
                            <input type="hidden" name="calificacion_factura" id="estrellaF">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col ml-3">
                            <p class="text-1 ml-5">Proceso de compra</p>
                          </div>
                          <div class="col">
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaP"></i>
                            <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaP"></i>
                            <input type="hidden" name="calificacion_proceso" id="estrellaP">
                          </div>
                    </div>
                    <br>
                    <div class="col mb-5">
                        <div class="form-group mx-2">
                            <label for="opinion"><p class="text-1">Cuál es tu opinión en una frase (opcional)</p></label>
                            <textarea class="form-control" id="opinion" placeholder="Escribe aquí un opinión" rows="3" name="opinion" onkeydown="caracteres(this,'con_opi_proveedor')"></textarea>
                        </div>
                        <p class="float-right text-2" id="con_opi_proveedor">0/1000 palabras</p>
                    </div>

                    <div class="col mb-5">
                        <div class="form-group mx-2">
                            <label for="opinion"><p class="text-1">Añade un comentario (obligatorio)</p></label>
                            <textarea class="form-control" id="comentario" placeholder="Escribe aquí tu comentario" rows="3" required name="comentario_proveedor" onkeydown="caracteres(this,'con_comen_proveedor')"></textarea>
                        </div>
                        <p class="float-right text-2" id="con_comen_proveedor">0/1000 palabras</p>
                    </div>

                    <hr>

                    <p class="text-14 text-center mt-4">2. Considerando factores como CALIDAD, PRECIO, Y UTILIDAD DEL PRODUCTO, <br> del 1 al 5, ¿Cómo calificarías el producto? (opcional)</p>

                    @foreach($productos as $producto)
                        <div class="m-4 p-2 border">
                            <div class="row mt-2">
                                <div class="col-3">
                                    <img src="{{ asset('storage/img-producto-pfp/'.$producto->foto_uno) }}" class="float-right" style="width: 30%; height: auto;">
                                </div>
                                <div class="col-6 text-center">
                                    <p class="text-2"><strong>{{ $producto->nombre}}</strong></p>
                                    <p class="text-2">{{ $producto->marca}}, {{ $producto->tamanio }}, {{ $producto->color }}</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-gl-12 mt-2 text-center">
                                <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="1estrellaP{{$producto->id_e}}"></i>
                                <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="2estrellaP{{$producto->id_e}}"></i>
                                <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="3estrellaP{{$producto->id_e}}"></i>
                                <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="4estrellaP{{$producto->id_e}}"></i>
                                <i class="fa-solid fa-star estrella" onclick="calificar(this)" id="5estrellaP{{$producto->id_e}}"></i>
                                <input type="hidden" name="producto[{{$producto->id_e}}]" id="estrellaP{{$producto->id_e}}">
                            </div>
                            <div class="col mb-5">
                                <div class="form-group mx-2">
                                    <label for="opinion"><p class="text-1">Añade un comentario (opcional)</p></label>
                                    <textarea class="form-control" name="comentario[{{$producto->id_e}}]" id="opinion" placeholder="Escribe aquí tu comentario"rows="3" onkeydown="caracteres(this,'con_comen_producto_{{ $producto->id_e }}')"></textarea>
                                </div>
                                <p class="float-right text-2" id="con_comen_producto_{{ $producto->id_e }}">0/1000 palabras</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="text-center mt-3 mb-4">
                        <button type="submit" class="btn boton-verde">Enviar</button>
                    </div>
                </form>
            </div>    
        </section>

    @endsection
    @section('js')
        @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection