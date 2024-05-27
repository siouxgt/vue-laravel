@extends('layouts.proveedores')

@section('content')
    <div class="row offset-10">
        <div class="col-1 col-md-3 col-lg-12 col-xl-12">
            <div class="text-center">
                <a href="{{ route('proveedor.logout') }}">
                    <img src="{{ asset('asset/images/salir_logout.png') }}" width="90px" alt="Salir" />
                </a>
            </div>            
        </div>
    </div>

    <section class="hd-container">
        <div class="inicio-icono">
            <div class="iconwrap">
                <img src="{{ asset('asset/images/registro_codigo.svg') }}" alt="" />
            </div>
        </div>

        <div>
            <h2 class="hd-container">Completa tu información</h2>
        </div>
        <div class="tx-paragraph">
            Se ha enviado un correo de confirmación a tu cuenta:
            <span class="resaltar">{{ $proveedor[0]->correo_tres }}</span>
            <br>
            Recuerda revisar tu bandeja de “no deseados”.
        </div>
    </section>

    <section class="ft-container">

        <div>
            <form action="{{ route('proveedor.comprobar_codigo') }}" method="POST" id="frm_m_escalamiento">
                @csrf
                @if (Session::has('respuesta'))
                    <div class="tx-paragraph">
                        <div class="alert alert-danger" role="alert">{{ Session::get('respuesta') }}</div>
                    </div>
                @endif
                <div class="row first-row  justify-content-center">
                    <div class="wrap">
                        <div>
                            <input class="num_oficina justify-content-center" type="text" required="required"
                                name="codigo" id="codigo" autocomplete="off" autofocus />
                            <label class="justify-content-center" for="name" required="required">Código enviado</label>
                        </div>
                        <br>
                        <br>
                        <div class="row justify-content-center">
                            <button type="submit" class="button">Confirmar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tx-paragraph-nota">
            <form action="{{ url('/proveedor/reenviar_cc') }}" method="GET">
                ¿No recibiste el correo de confirmación?
                <br>
                <button type="submit" class="button-blanco">Reenviar código</button>
            </form>

        </div>
        <div class="col-md-3 tx-paragraph-nota justify-content-center">
            @if (Session::has('mensaje'))
                <div class="alert alert-success">{{ Session::get('mensaje') }}</div>
            @endif
        </div>

    </section>
@endsection
@section('js')
    @routes('proveedor')
    <script>
        $(".alert").delay(4000).slideUp(200, function () {//Ocultar alerta de error despues de 4 segundos
            $(this).alert('close');
        });
    </script>
@endsection
