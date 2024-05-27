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
                    <p class="text-14 ">Datos del Proveedor</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-sm-12">
                        <div class="progress-1">
                            <div class="progress-bar" role="progressbar" style="width: 40%"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-11">2 de 5</p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Proveedor</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->nombre_proveedor }}</strong></p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">RFC</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->rfc_proveedor }}</strong></p>
                </div>
                
                
                <div class="text-center mt-3">
                    <p class="text-2">Representante legal</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->representante_proveedor }}</strong></p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Domicilio</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->domicilio_proveedor }}</strong></p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Teléfono</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->telefono_proveedor }}</strong></p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Correo electrónico</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->proveedor->correo_legal }}</strong></p>
                </div>


                <div class="row mb-4 mt-5">
                    <div class="col-6">
                       <a class="btn btn-outline-light-v mt-3 mr-2 float-right" href="{{ route('orden_compra_urg.alta_contrato_1') }}">
                        <i class="fa-solid fa-arrow-left text-9"></i> Atras</a>
                    </div>
                    <div class="col-6">
                        <div class="botones">
                            <a class="btn boton-2 mt-3" href="{{ route('orden_compra_urg.alta_contrato_3') }}">
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