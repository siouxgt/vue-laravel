@extends('layouts.proveedores')

@section('content')
<div class="row">
        <div class="col-6 col-sm-9 col-lg-10"></div>
        <div class="col-6 col-sm-3 col-lg-2">
            <div class="text-center">
                <a href="{{ route('proveedor.logout') }}">
                    <img src="{{ asset('asset/images/salir_logout.png') }}" width="90px" alt="Salir" />
                </a>
            </div>            
        </div>
</div>

<div class="inicio-icono">
    <div class="iconwrap">
        <img src="{{ asset('asset/images/registro_inicio.svg') }}" alt="" />
    </div>
</div>

<section class="hd-container">
    <div>
        <h2 class="hd-container">Confirma y completa tu perfil</h2>
    </div>
    <div class="tx-paragraph">
        La información que se solicita a continuación podrá ser consultada por las Unidades Responsables de Gasto (URG) compradoras para que exista un canal de comunicación directo.
    </div>
</section>
<section class="ft-container">
    <div>
        <form action="{{ route('proveedor.abrir_me') }}">        
            <input type="submit" value="Empezar" class="button">
        </form>
    </div>
</section>

<div class="clear">&nbsp;</div>
@endsection
@section('js')
@routes('proveedor')
@endsection