@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <div class="col text-center">
                    <p class="text-1  m-2">Revisa los siguientes datos. Para problemas técnicos, contacta al administrador.</p>
                </div>
                <br>
                 <div class="row justify-content-center mb-3">
                    <button type="button" class="btn bg-white d-flex align-items-center" id="problemas_tecnicos">
                        <i class="fa-solid fa-message text-10"></i>
                        <p class="text-mensaje">Problemas técnicos</p>
                    </button>
                </div>

                <div class="text-center mb-2">
                    <p class="text-14 ">Datos de Entrega</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-sm-12">
                        <div class="progress-1">
                            <div class="progress-bar" role="progressbar" style="width: 60%"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-11">3 de 5</p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Fecha de entrega</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $fecha->fecha_entrega->format('d/m/Y') }}</strong></p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Horario de entrega</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>09:00 a 15:00</strong></p>
                </div>
               
               
                <div class="text-center">
                    <p class="text-1 px-5"><strong>Responsable Almacén</strong></p>
                </div>

                @if($contrato->ccg)
                    <div class="text-center">
                        <div class="botones">
                           <a class="btn m-2 boton-2"  href="javascript: void(0);" onclick="almacenModalEditar()"><span><i class="fa-solid fa-plus"></i></span>Editar persona</a>
                        </div>
                    </div>
                    <div class="text-center mt-1" id="almacen">
                        <p class="text-2 mt-2">Clave Centro Gestor</p>
                        <p class="text-1"><strong id="ccg_almacen">{{ $contrato->ccg }}</strong></p>

                        <p class="text-2 mt-3">Responsable de Almacén</p>
                        <p class="text-1"><strong id="responsable_almacen">{{ $contrato->responsable_almacen }}</strong></p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto_almacen">Responsable de almacen</strong></p>

                        <p class="text-2 mt-3">Domicilio</p>
                        <p class="text-1"><strong id="domicilio_almacen">{{ $contrato->direccion_almacen }}</strong></p>

                        <p class="text-2 mt-3">Teléfono</p>
                        <p class="text-1"><strong id="telefono_almacen">{{ $contrato->telefono_almacen }}</strong></p>
                    </div>
                @else
                    <div class="text-center">
                        <div class="botones">
                           <a class="btn m-2 boton-2" href="javascript: void(0);" onclick="almacenModal()"><span><i class="fa-solid fa-plus"></i></span>Agregar persona</a>
                        </div>
                    </div>
                    <div class="text-center mt-1 ocultar" id="almacen">
                        <p class="text-2 mt-2">Clave Centro Gestor</p>
                        <p class="text-1"><strong id="ccg_almacen"></strong> </p>

                        <p class="text-2 mt-3">Responsable de Almacén</p>
                        <p class="text-1"><strong id="responsable_almacen"></strong></p>

                        <p class="text-2 mt-3">Puesto</p>
                        <p class="text-1"><strong id="puesto_almacen">Responsable de almacen</strong></p>

                        <p class="text-2 mt-3">Domicilio</p>
                        <p class="text-1"><strong id="domicilio_almacen"></strong></p>

                        <p class="text-2 mt-3">Teléfono</p>
                        <p class="text-1"><strong id="telefono_almacen"></strong></p>
                    </div>
                @endif 


                <div class="row mb-4 mt-5">
                    <div class="col-6">
                       <a class="btn btn-outline-light-v mt-3 mr-2 float-right" href="javascript: void(0);" onclick="history.back();">
                        <i class="fa-solid fa-arrow-left text-9"></i> Atras</a>
                    </div>
                    <div class="col-6">
                        <div class="botones">
                            <a class="btn boton-2 mt-3" href="{{ route('orden_compra_urg.alta_contrato_4') }}">
                                Confirmar y continuar</a>
                        </div>
                    </div>
                </div>
        </section>

    @endsection
    @section('js')
    @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection