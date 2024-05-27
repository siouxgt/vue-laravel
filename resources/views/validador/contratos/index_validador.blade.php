@extends('layouts.validador')
    @section('content')

        <div class="row">
            <div class="col-12 col-lg-6">
                <h1 class="m-2 p-3">Contratos Marco</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb"> 
                        <li class="breadcrumb-item"><a href="{{ route('validador_tecnico.index') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Contratos Marco</li>
                    </ol>
                </nav>
            </div>
            <div class="separator"></div>
        </div>
        <div class="container contenedorCM" id="contenedorCM">
            @if($contratosVigentes)
                <div class="row m-2">
                    <div class="col-12 col-sm-12">
                        <h2 class="display-4 titulo-1">Contratos vigentes</h2>
                    </div>
                </div>
            
                <div class="row m-2">
                    @foreach($contratosVigentes as $habilitados)
                        <article class="col-12 col-md-4 mt-3">
                            <div class="sombra p-1">
                                <div>
                                    @if(\Carbon\Carbon::parse($habilitados->created_at)->diffInDays(now()) < 90)
                                        <p class="porLiberar">Nuevo</p>
                                    @endif
                                </div>
                                <a href="{{ route('contrato_validador.show', ['contrato' => $habilitados->id_e]) }}">
                                    <div class="row justify-content-center">
                                        <div>
                                            @if( $habilitados->imagen)
                                                <img src="{{ asset('storage/img-contrato/'.$habilitados->imagen)}}" class="perfil-3" alt="{{ $habilitados->imagen }}">    
                                            @else    
                                                <h2 class="perfil-3"><?php print(strtoupper(substr($habilitados->nombre_cm, 0,1))); ?></h2>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row border-dark justify-content-center ">
                                        <p class="m-1 text-1"><h4>{{ $habilitados->nombre_cm }}</h4></p>
                                    </div>
                                </a>
                                <hr>
                                <div class="container">
                                    <div class="row footCard">
                                        <div class="col-12 col-sm-12">
                                            <p class="text-2 text-right-1">Ultima Edición: {{\Carbon\Carbon::parse($habilitados->updated_at)->diffForHumans(now())}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <hr>
            @endif
        </div>

    @endsection