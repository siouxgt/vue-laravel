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

<div class="inicio-icono">
    <div class="iconwrap">
        <img src="{{ asset('asset/images/registro_exitoso.svg') }}" alt="" />
    </div>
</div>

<section class="hd-container">
    <div>
        <h2 class="hd-container">¡Listo! Tus datos han sido actualizados</h2>
    </div>
    <div class="tx-paragraph">
        Conoce nuestros manuales de apoyo
        <a href="#" class="resaltar">www.infografias.com</a>
    </div>
</section>
<section class="ft-container">
    <form action="{{ route('proveedor.aip') }}">
        <div>
            <button class="button" id="btnRegistroExitoso">Continuar</button>
        </div>
    </form>
</section>

<div class="clear">&nbsp;</div>
@endsection
@section('js')
@routes('proveedor')
@endsection