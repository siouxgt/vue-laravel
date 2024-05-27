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
                    <p class="text-14 ">Datos de Facturación</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-sm-12">
                        <div class="progress-1">
                            <div class="progress-bar" role="progressbar" style="width: 80%"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-11">4 de 5</p>
                </div>
                
                <div class="text-center">
                    <div class="botones">
                       <a class="btn m-2 boton-2"  href="javascript: void(0);" onclick="facturacionModal()"><span><i class="fa-solid fa-plus"></i></span>Editar datos</a>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Número de contrato</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->contrato_pedido }}</strong>
                </div>

                 <div class="text-center mt-3">
                    <p class="text-2">Dependencia</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->area_requiriente }}</strong>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Centro gestor</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->urg->nombre }}</strong>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Razón social</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong id="razon_social">{{ $contrato->razon_social_fiscal }}</strong>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">RFC</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong id="rfc_fiscal">{{ $contrato->rfc_fiscal }}</strong></p>
                </div>
                
                <div class="text-center mt-3">
                    <p class="text-2">Domicilio fiscal</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong id="domicilio_fiscal">{{ $contrato->domicilio_fiscal}}</strong></p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Método de pago</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->metodo_pago }}</strong></p>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Forma de pago</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong>{{ $contrato->forma_pago}}</strong>
                </div>

                <div class="text-center mt-3">
                    <p class="text-2">Uso del CFDI</p>
                </div>
                <div class="text-center mb-4">
                    <p class="text-1 px-5"><strong id="uso_cfdi">{{ $contrato->uso_cfdi}}</strong>
                </div>

               <div class="row mb-4 mt-5">
                   <div class="col-6">
                      <a class="btn btn-outline-light-v mt-3 mr-2 float-right" href="javascript: void(0);" onclick="history.back();">
                       <i class="fa-solid fa-arrow-left text-9"></i> Atras</a>
                   </div>
                   <div class="col-6">
                       <div class="botones">
                           <a class="btn boton-2 mt-3" href="{{ route('orden_compra_urg.alta_contrato_5') }}">Confirmar y continuar</a>
                       </div>
                   </div>
               </div>
        </section>

    @endsection
    @section('js')
    @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection