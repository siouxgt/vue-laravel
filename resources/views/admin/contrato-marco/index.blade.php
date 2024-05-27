@extends('layouts.admin')

@section('content')
    <div class="row px-4">
        <div class="col-12 col-lg-6">
            <h1 class="m-2 guinda fw-bold p-3">Contratos Marco</h1>
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Contratos Marco</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-12 col-lg-4 offset-lg-2">
            <div><br /></div>
            <a class="btn boton-2 m-2" type="button" href="javascript: void(0)" role="button"
                onclick="agregarCuadrosContratoMarco('vigentes');">Vigentes</a>
            <a class="btn boton-2 m-2" type="button" href="javascript: void(0)" role="button"
                onclick="agregarCuadrosContratoMarco('xliberar');">Por liberar</a>
            <a class="btn boton-2 m-2" type="button" href="javascript: void(0)" role="button"
                onclick="agregarCuadrosContratoMarco('xvencer');">Por vencer</a>
            <a class="btn boton-2 m-2" type="button" href="javascript: void(0)" role="button"
                onclick="agregarCuadrosContratoMarco('vencido');">Vencidos</a>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row">
            <div class="col-6 col-sm-6">
                {{-- <h2 class="display-4 titulo-1" id="tituloACM">Vigentes</h2> --}}
            </div>
            <div class="col-6 col-sm-12 text-end mt-2 align-middle">
                <h2 class="agregar"><a href=" {{ url('contrato/create') }} " class="agregar">
                        <i class="fa-solid fa-circle-plus text-gold"></i> Agregar Contrato Marco</a>
                </h2>
            </div>
        </div>
    </div>
    <div class="container contenedorCM" id="contenedorCM">

        @if ($vigentes)
            <div class="row m-2">
                <div class="col-6 col-sm-6">
                    <p class="titulo-1 fw-bolder">Vigentes</p>
                </div>
            </div>

            <div class="row m-2">
                @foreach ($vigentes as $vigente)
                    <article class="col-12 col-md-4 mt-3">
                        <div class="border rounded p-2 shadow-sm">
                            <div class="mt-2 ml-2">
                                @if (\Carbon\Carbon::parse($vigente->created_at)->diffInDays(now()) < 90)
                                    <p class="porLiberar">Nuevo</p>
                                @endif
                            </div>
                            <!-- botonesConfigurarConvenio -->
                            <div class="row justify-content-end m-2">
                                <div class="btn-group bg-gris-inactivo col-2">
                                    <button type="button" class="btn btn-white boton-3"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span>
                                            <i class="fa-solid fa-ellipsis-vertical text-gold"></i>
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu bg-light">
                                        <div class="card" style="width: 18rem;">
                                            <ul class="list-group list-group-flush list-unstyled text-decoration-none">
                                                <li class="list-group-item-2 dropdown-header bg-light border-bottom">
                                                    <strong>Configurar Convenio
                                                        Marco</strong>
                                                </li>
                                                <li class="list-group-item bg-light border-bottom gris1 "><a
                                                        href="{{ route('contrato.edit', ['contrato' => $vigente->id_e]) }}"
                                                        class="text-decoration-none"><i
                                                            class="fa-solid fa-pen-to-square gris text-decoration-none"></i>
                                                        Editar</a></li>
                                            </ul>
                                        </div>
                                    </ul>
                                    {{-- <button type="button" class="btn btn-white dropdown-toggle boton-3"	data-toggle="dropdown" aria-expanded="false">
											<span>
												<i class="fa-solid fa-ellipsis-vertical text-gold"></i>
											</span>
										</button>
										<div class="dropdown-menu bg-light">
											<div class="card" style="width: 18rem;">
												<ul class="list-group list-group-flush list-unstyled bg-light text-2">
													<li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio
															Marco</strong></li>
													<li class="list-group-item bg-light border-bottom"><a href="{{ route('contrato.edit', ['contrato' => $vigente->id_e]) }}"><i class="fa-solid fa-pen-to-square gris"></i> Editar</a></li>
												</ul>
											</div>
										</div> --}}
                                </div>
                            </div>
                            <!-- botonesConfigurarConvenio -->
                            <div class="row border-dark text-center">
                                <a href="{{ route('contrato.edit', ['contrato' => $vigente->id_e]) }}">
                                    <p class="m-1 text-1">
                                        <h4>{{ $vigente->nombre_cm }}</h4>
                                    </p>
                                </a>
                            </div>
                            <div class="row p-3">
                                <div class="col-3">
                                    @if ($vigente->imagen)
                                        <img src="{{ asset('storage/img-contrato/' . $vigente->imagen) }}" class="perfil-3"
                                            alt="{{ $vigente->imagen }}">
                                    @else
                                        <h2 class="perfil-3">{{ strtoupper(substr($vigente->nombre_cm, 0, 1)) }}</h2>
                                    @endif
                                </div>
                                <div class="col-9">
                                    <p class="m-1 text-2">Proveedores: {{ $vigente->proveedores }}</p>
                                    <p class="m-1 text-2">Productos: {{ $vigente->productos }}</p>
                                </div>
                            </div>


                            <div class="row mt-3">
                                <div class="col-6">
                                    <p class="text-2">Vigente</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-2 text-end">{{ $vigente->porcentaje }}%</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar-1" role="progressbar"
                                        style="width: {{ $vigente->porcentaje }}%;" aria-valuenow="100" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>


                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <span>
                                        <h2 class="perfil-2">{{ $vigente->usercreo }}</h2>
                                    </span>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-2 text-end">Ultima Edición:
                                        {{ \Carbon\Carbon::parse($vigente->updated_at)->diffForHumans(now()) }}</p>
                                </div>
                            </div>

                        </div>
                    </article>
                @endforeach
            </div>
            <hr>
        @endif
        @if ($porLiberar)
            <div class="row m-2">
                <div class="col-6 col-sm-6">
                    <p class="titulo-1 fw-bolder fs-4">Por liberar</p>
                </div>
            </div>
            <div class="row m-2">
                @foreach ($porLiberar as $liberar)
                    <article class="col-12 col-md-4 mt-3">
                        <div class="border rounded p-2 shadow-sm">
                            <!-- botonesConfigurarConvenio -->
                            <div class="row justify-content-end m-2">
                                <div class="btn-group bg-gris-inactivo col-2">
                                    <button type="button"
                                        class="btn btn-white boton-3"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span>
                                            <i class="fa-solid fa-ellipsis-vertical text-gold"></i>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu bg-light">
                                        <div class="card" style="width: 18rem;">
                                            <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                                <li class="list-group-item-2 dropdown-header bg-light  border-bottom">
                                                    <strong>Configurar Convenio
                                                        Marco</strong>
                                                </li>
                                                <li class="list-group-item bg-light border-bottom"><a
                                                        href="{{ route('contrato.edit', ['contrato' => $liberar->id_e]) }}"><i
                                                            class="fa-solid fa-pen-to-square gris"></i>Editar</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- botonesConfigurarConvenio -->
                            <div class="row border-dark text-center">
                                <a href="{{ route('contrato.edit', ['contrato' => $liberar->id_e]) }}">
                                    <p class="m-1 text-1">
                                        <h4>{{ $liberar->nombre_cm }}</h4>
                                    </p>
                                </a>
                            </div>
                            <div class="row p-3">
                                <div class="col-3">
                                    @if ($liberar->imagen)
                                        <img src="{{ asset('storage/img-contrato/' . $liberar->imagen) }}" class="perfil-3"
                                            alt="{{ $liberar->imagen }}">
                                    @else
                                        <h2 class="perfil-3">{{ strtoupper(substr($liberar->nombre_cm, 0, 1)) }}</h2>
                                    @endif
                                </div>
                                <div class="col-9">
                                    <p class="m-1 text-2">Proveedores: {{ $liberar->proveedores }}</p>
                                    <p class="m-1 text-2">Productos: {{ $liberar->productos }}</p>
                                </div>
                            </div>

                            <div class="row espacio mt-3">
                                <div class="col-4 porLiberar-yelow">
                                    <p class="text-3">liberar</p>
                                </div>
                                <div class="col-12">
                                    <p class="text-1 text-end">{{ $liberar->porcentaje }}%</p>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="progress">
                                        <div class="progress-bar-2" role="progressbar"
                                            style="width: {{ $liberar->porcentaje }}%;" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>

                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3">
                                    <span>
                                        <h2 class="perfil-2">{{ $liberar->usercreo }}</h2>
                                    </span>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-2 text-end">Ultima Edición:
                                        {{ \Carbon\Carbon::parse($liberar->updated_at)->diffForHumans(now()) }}</p>
                                </div>
                            </div>

                        </div>
                    </article>
                @endforeach
            </div>
            <hr>
        @endif
        @if ($porVencer)
            <div class="row m-2">
                <div class="col-6 col-sm-6">
                    <p class="titulo-1 fw-bolder fs-4">Por vencer</p>
                </div>
            </div>
            <div class="row m-2">
                @foreach ($porVencer as $vencer)
                    <article class="col-12 col-md-4 mt-3">
                        <div class="border rounded p-2 shadow-sm">
                            <!-- botonesConfigurarConvenio -->
                            <div class="row justify-content-end m-2">
                                <div class="bg-gris-inactivo col-2">
                                    <button type="button"
                                        class="btn btn-sm dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span>
                                            <i class="fa-solid fa-ellipsis-vertical text-gold"></i>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu bg-light">
                                        <div class="card" style="width: 18rem;">
                                            <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                                <li class="list-group-item-2 dropdown-header bg-light  border-bottom">
                                                    <strong>Configurar Convenio
                                                        Marco</strong>
                                                </li>
                                                <li class="list-group-item bg-light border-bottom"><a
                                                        href="{{ route('contrato.edit', ['contrato' => $vencer->id_e]) }}"><i
                                                            class="fa-solid fa-pen-to-square gris"></i>Editar</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-dark justify-content-center ">
                                <a href="{{ route('contrato.edit', ['contrato' => $vencer->id_e]) }}">
                                    <p class="m-1 text-1">
                                        <h4>{{ $vencer->nombre_cm }}</h4>
                                    </p>
                                </a>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    @if ($vencer->imagen)
                                        <img src="{{ asset('storage/img-contrato/' . $vencer->imagen) }}" class="perfil-3"
                                            alt="{{ $vencer->imagen }}">
                                    @else
                                        <h2 class="perfil-3">{{ strtoupper(substr($vencer->nombre_cm, 0, 1)) }}</h2>
                                    @endif
                                </div>
                                <div class="col-9">
                                    <p class="m-1 text-2">Proveedores: {{ $vencer->proveedores }}</p>
                                    <p class="m-1 text-2">Productos: {{ $vencer->productos }}</p>
                                </div>
                            </div>
                            <div class="container">
                                <div class="form-group">
                                    <div class="row espacio">
                                        <div class="col-6 porLiberar-red">
                                            <p class="text-4">Por Vencer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row footCard">
                                    <div class="col-12 col-sm-12">
                                        <span>
                                            <h2 class="perfil-2">{{ $vencer->usercreo }}</h2>
                                        </span>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <p class="text-2 text-right-1">Ultima Edición:
                                            {{ \Carbon\Carbon::parse($vencer->updated_at)->diffForHumans(now()) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            <hr>
        @endif

        @if ($vencidos)
            <div class="row m-2">
                <div class="col-6 col-sm-6">
                    <p class="titulo-1 fw-bolder fs-4">Vencidos</p>
                </div>
            </div>
            <div class="row m-2">
                @foreach ($vencidos as $vencido)
                    <article class="col-12 col-md-4 mt-3">
                        <div class="border rounded p-2 shadow-sm">
                            <!-- botonesConfigurarConvenio -->
                            <div class="row justify-content-end m-2">
                                <div class="bg-gris-inactivo col-2">
                                    <button type="button"
                                        class="btn btn-sm dropdown-toggle dropdown-toggle-split text-end"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span>
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </span>
                                    </button>
                                    <div class="dropdown-menu bg-light">
                                        <div class="card" style="width: 18rem;">
                                            <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                                <li class="list-group-item-2 dropdown-header bg-light  border-bottom">
                                                    <strong>Configurar Convenio
                                                        Marco</strong>
                                                </li>
                                                <li class="list-group-item bg-light border-bottom"><a
                                                        href="{{ route('contrato.edit', ['contrato' => $vencido->id_e]) }}"><i
                                                            class="fa-solid fa-pen-to-square gris"></i> Editar</a></li>
                                                {{-- <li class="list-group-item bg-light border-bottom"><a href="#">Eliminar</a></li>
													<li class="list-group-item bg-light border-bottom"><a href="#">Duplicar</a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- botonesConfigurarConvenio -->
                            <div class="row border-dark justify-content-center ">
                                <a href="{{ route('contrato.edit', ['contrato' => $vencido->id_e]) }}">
                                    <p class="m-1 text-1">
                                        <h4>{{ $vencido->nombre_cm }}</h4>
                                    </p>
                                </a>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    @if ($vencido->imagen)
                                        <img src="{{ asset('storage/img-contrato/' . $vencido->imagen) }}" class="perfil-3"
                                            alt="{{ $vencido->imagen }}">
                                    @else
                                        <h2 class="perfil-3">{{ strtoupper(substr($vencido->nombre_cm, 0, 1)) }}</h2>
                                    @endif
                                </div>
                                <div class="col-9">
                                    <p class="m-1 text-2">Proveedores: {{ $vencido->proveedores }}</p>
                                    <p class="m-1 text-2">Productos: {{ $vencido->productos }}</p>
                                </div>
                            </div>
                            <div class="container">
                                <div class="form-group">
                                    <div class="row espacio">
                                        <div class="col-6 porLiberar-gold">
                                            <p class="text-4">Vencido</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row footCard">
                                    <div class="col-12 col-sm-12">
                                        <span>
                                            <h2 class="perfil-2">{{ $vencido->usercreo }}</h2>
                                        </span>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <p class="text-2 text-right-1">Ultima Edición:
                                            {{ \Carbon\Carbon::parse($vencido->updated_at)->diffForHumans(now()) }}</p>
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

@section('js')
    @routes(['contratosMarco'])
    <script src="{{ asset('asset/js/agregar-contrato-marco.js') }}" type="text/javascript"></script>
@endsection
