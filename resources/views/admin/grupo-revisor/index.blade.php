@extends('layouts.admin')

@section('content')
    <input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">
    @include('admin.contrato-marco.submenu')
    <div class="row m-2">
        <div class="text-end col-12 col-md-4 offset-md-6">
            <a href="{{ route('grupo_revisor.create') }}"><p class="text-gold"><i class="fa-solid fa-circle-plus text-gold"></i> Agregar mesa de trabajo</p></a>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row m-2">
            @foreach ($grupos as $grupo)
               
                <article class="col-12 col-md-4 mt-3">
                    <div class="sombra p-1">
                        <!-- botonesConfigurarConvenio -->
                        <div class="row justify-content-end m-2">
                            <div class="btn-group dropright float-end col-sm-2 bg-light">
                                <button type="button" class="btn btn-white dropdown-toggle dropdown-toggle-split boton-3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="fa-solid fa-ellipsis-vertical text-gold"></i></span>
                                </button>
                                <div class="dropdown-menu bg-light">
                                    <div class="card" style="width: 18rem;">
                                        <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                            <li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio Marco</strong></li>
                                            <li class="list-group-item bg-light border-bottom"><a href="{{ route('grupo_revisor.edit', ['grupo_revisor' => $grupo->id_e ]) }}"><i class="fa-solid fa-pen-to-square gris"></i>Editar</a></li>
                                           {{--  <li class="list-group-item bg-light border-bottom"><a href="#">Eliminar</a></li>
                                            <li class="list-group-item bg-light border-bottom"><a href="#">Duplicar</a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- botonesConfigurarConvenio -->
                        <div class="row border-dark justify-content-center etiquetaNuevo mt-2">
                            <h4 class="text-gold text-center">Convocatoria No.</h4>
                        </div>
                        <div class="row m-2">
                            <div class="col-4 ">
                                <div class="col-12 col-sm-12">
                                    <span>
                                       
                                        <h2 class="perfil-3">C</h2>
                                        
                                    </span>
                                </div>
                            </div>
                            <div class="col-8 ">
                                <a href="{{ route('grupo_revisor.edit', ['grupo_revisor' => $grupo->id_e]) }}"><p class="m-1 text-1"><h4>{{ $grupo->convocatoria }}</h4></p></a>
                            </div>
                        </div>
                        <hr>
                            <div class="row align-items-center">
                                <div class="col-sm-6 col-md-4">
                                   {{--  <span>
                                        <h2 class="perfil-2">{{ substr($grupo->user->nombre, 0,1) }}{{ substr($grupo->user->primer_apellido, 0,1) }}</h2>
                                    </span>
                                </div> --}}
                                <div class="col-sm-6 col-md-8">
                                    <p class="text-2 text-right-1">Ultima Edición: {{ $grupo->updated_at->diffForHumans(now()) }}</p>
                                </div>
                            </div>
                    </div>
                </article>
                               
            @endforeach
        </div>
    </div>

@endsection
@section('js')
    @routes(['submenu'])
@endsection