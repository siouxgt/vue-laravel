@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

       <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 border rounded text-center">
               <input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">

                <div class="col text-center">
                    <p class="text-1 mt-4 m-2">Firma el contrato usando tu eFirma</p>
                </div>
                <hr>

                <form action="{{ route('orden_compra_urg.efirma_save') }}" method="POST" enctype="multipart/form-data" id="frm_firma">
                    @csrf
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-6 m-4 p-3 border rounded text-center">
                            <p class="text-1"><strong>Archivo .cer</strong></p>
                            <input type="file" id="archivo_cer" name="archivo_cer" class="ocultar" accept=".cer" required />
                            <div class="rounded punteado m-3 p-4 integrar_cursor text-1" id="drop_cer">
                                
                            </div>
                            <p class="text-1" id="nombre_cer" required></p>
                        </div>

                        <div class="col-6 m-4 p-3 border rounded text-center">
                            <p class="text-1"><strong>Archivo .key</strong></p>
                            <input type="file" id="archivo_key" name="archivo_key"  class="ocultar"  accept=".key" required>
                            <div class="rounded punteado m-3 p-4 integrar_cursor text-1" id="drop_key">
                               
                            </div>
                             <p class="text-1" id="nombre_key"></p>
                        </div>
                            
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="contrasena"><p class="text-1 ml-4">Contraseña</p></label>
                                <input type="password" id="contrasena" name="contrasena" class="form-control mx-sm-3" required>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row mb-4">
                    <div class="col-6">
                        <a class="btn btn-outline-light-v mt-3 mr-2 float-right" href="javascript: void(0);" onclick="history.back();">
                        <i class="fa-solid fa-arrow-left text-9"></i> Atras</a>
                   </div>
                    <div class="col-6">
                        <div class="botones">
                            <button onclick="firmar();" class="btn boton-2 mt-3"></i>Firmar contrato</button>
                        </div>
                    </div>
                </div>
            </div>    
        </section>

    @endsection
    @section('js')
    @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
        <script src="{{ asset('asset/js/drag_drop.js') }}" type="text/javascript"></script>
    @endsection 