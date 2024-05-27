@extends('layouts.admin')

@section('content')
    @include('admin.contrato-marco.submenu')
    <div class="row">
        <div class="botones col-sm-6 offset-md-2">
            <a class="btn m-2 boton-2" href="javascript: void(0)" onclick="expediente(0);" role="button">Convocatoria pública</a>
            <a class="btn m-2 boton-2" href="javascript: void(0)" onclick="expediente(1);" role="button">Convocatoria restringida</a>
            <a class="btn m-2 boton-2" href="javascript: void(0)" onclick="expediente(2);" role="button">Convocatoria directa</a>
        </div>
        <div class="text-right col-sm-3 float-end">
            <h2 class="agregar"><a href="{{ route('expedientes_contrato.create') }}"><i class="fa-solid fa-circle-plus text-gold"></i> Agregar Procedimiento</a></h2>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row m-2" id="contenedor_exp">
            @foreach ($expedientes as $expediente)
                <article class="col-12 col-md-4 mt-3">
                    <div class="sombra border rounded p-3">
                        <div>
                            @if($expediente->fecha($expediente->id,$expediente->metodo)[0]->diffInDays(now()) < 90)
                                <p class="porLiberar">Nuevo</p>
                            @endif

                        </div>
                        <!-- botonesConfigurarConvenio -->
                        <div class="row justify-content-end m-2">
                            <div class="btn-group bg-light float-end col-sm-2">
                                <button type="button" class="btn btn-white  boton-3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="fa-solid fa-ellipsis-vertical text-gold"></i></span>
                                </button>
                                <div class="dropdown-menu bg-light">
                                    <div class="card" style="width: 18rem;">
                                        <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                            <li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio Marco</strong></li>
                                            <li class="list-group-item bg-light border-bottom"><a href="{{ route('expedientes_contrato.edit',['expedientes_contrato' => $expediente->id_e]) }}"><i class="fa-solid fa-pen-to-square gris"></i> Editar</a></li>
                                            {{-- <li class="list-group-item bg-light border-bottom"><a href="#">Eliminar</a></li>
                                            <li class="list-group-item bg-light border-bottom"><a href="#">Duplicar</a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- botonesConfigurarConvenio -->
                        <div class="row border-dark justify-content-center etiquetaNuevo">
                            <h4 class="text-gold">{{ $expediente->metodo }}</h4>
                        </div>
                        <div class="row mx-2">
                            <div class="col-sm-4">
                                    <span>
                                        @if( $expediente->imagen)
                                            <img src="{{ asset('storage/img-expedientes/'.$expediente->imagen)}}" class="perfil-3" alt="{{ $expediente->imagen }}">
                                        @else    
                                            <h2 class="perfil-3"><?php print(strtoupper(substr($expediente->metodo, 0,1).substr($expediente->metodo, 13,1))); ?></h2>
                                        @endif
                                    </span>
                            </div>
                            <div class="col-sm-8">
                                <a href="{{ route('expedientes_contrato.edit', ['expedientes_contrato' => $expediente->id_e]) }}"><p class="m-1 text-1"><h4>Número procedimiento: <br> {{ $expediente->num_procedimiento }}</h4></p></a>
                            </div>
                        </div>
                        <div class="container">
                            <div class="form-group">
                                <div class="row espacio">
                                    <div class="col-sm-4">
                                        @if($expediente->liberado)
                                            <p class="porLiberar-green">Vigente</p>
                                        @else
                                            <p class="porLiberar-yelow">Por Liberar</p>
                                        @endif 
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-2 text-end">{{ $expediente->porcentaje}}%</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="progress">
                                        <div class="@if($expediente->porcentaje < 100) progress-bar-2 @else progress-bar-1 @endif" role="progressbar" style="width: {{ $expediente->porcentaje}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                {{--     <span>
                                        <h2 class="perfil-2">{{ substr($expediente->user->nombre, 0,1) }}{{ substr($expediente->user->primer_apellido, 0,1) }}</h2>
                                    </span> --}}
                                </div>
                                <div class="col-sm-8">
                                    <p class="text-2 text-end">Ultima Edición: {{ $expediente->fecha($expediente->id,$expediente->metodo)[1]->diffForHumans(now()) }}</p>
                                </div>
                            </div>
                        
                    </div>
                </article>
                               
            @endforeach
        </div>
    </div>
    @php 
        $login = Auth::check();
    @endphp
@endsection
@section('js')
    @routes(['submenu','expedientesContrato'])
    <script src="{{ asset('asset/js/expediente_filtro.js') }}" type="text/javascript"></script>
@endsection