@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')
       <section class="justify-content-md-center">
           
            <div class="col-md-12 col-sm-12 align-self-center border rounded">
                <div class="d-flex justify-content-center align-items-center border mt-3">
                    <embed src="{{ asset('storage/contrato-pedido/contrato_pedido_'.$contrato->contrato_pedido.'.pdf#toolbar=0&navpanes=0') }}" type="application/pdf" width="50%" height="700px" />
                </div>

               <div class="row mb-4 mt-5">
                   <div class="col-6">
                        <a class="btn btn-outline-light-v mt-3 mr-2 float-right" href="javascript: void(0);" onclick="history.back();">
                        <i class="fa-solid fa-arrow-left text-9"></i> Atras</a>
                   </div>
                   <div class="col-6">
                       <div class="botones">
                           <a class="btn boton-2 mt-3" href="{{ route('orden_compra_urg.firmar_contrato') }}">Firmar contrato</a>
                       </div>
                   </div>
               </div>
           </div>
    
        </section>

    @endsection
    @section('js')
    @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection