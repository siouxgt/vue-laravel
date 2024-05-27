@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        @if ($id_contrato_marco != null)
            {{-- SI se va a editar se accede aqui --}}
            @include('admin.contrato-marco.submenu')
        @else
            <h1 class="m-2 guinda fw-bold p-3">Alta Contratos Marco</h1>
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('contrato.index') }}">Contratos Marco</a></li>
                    </ol>
                </nav>
            </div>
            <hr>
            <div class="row">
                <p class="fs-4 titulo-1 mb-5" id="punto-encuentro">{{ strtoupper(session()->get('nombreCm')) }}</p>
            </div>
        @endif
        {{-- <div class="row">
            <article class="col-sm-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="cuadros rounded">
                        <div class="card" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="text-gold text-center pt-4 border-bottom p-3"><strong>Alta Contrato</strong></li>
                                <li class="list-group-item-1 border-bottom">
                                    <ul class="list-unstyled p-2">
                                        <li>Del <strong></strong><a href="javascript: void(0)" class="float-end"><i
                                                    class="fa-solid fa-calendar-plus"></i></a></li>
                                        <li>Al <strong></strong></li>
                                    </ul>
                                </li>
                                <li class="list-group-item-1 iconosFut p-3">
                                    <a href="javascript: void(0)" class="text-leaft"><i
                                            class="fa-solid fa-pen-to-square fa-lg" aria-hidden="true"></i></a>
                                    <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-file-pdf fa-lg"
                                            aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="indicador-count-card fa-solid fa-check text-center"></p>
                    </div>
                </div>
            </article>

            <article class="col-sm-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="sombra cuadros">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="text-gold text-center pt-4 border-bottom p-3"><strong>Grupo Revisor</strong></li>

                                <li class="list-group-item-2 border-bottom">
                                    <ul class="list-unstyled p-2">
                                        <li>Del <strong></strong><a href="javascript: void(0)" class="float-end"><i
                                                    class="fa-solid fa-calendar-plus"></i></a></li>
                                        <li>Al <strong></strong></li>
                                    </ul>
                                </li>
                                <li class="list-group-item-3 iconosFut p-3 ">
                                    <a href="javascript: void(0)" class="text-leaft"><i
                                            class="fa-solid fa-circle-plus fa-lg" aria-hidden="true"></i></a>
                                    <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-file-pdf fa-lg"
                                            aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="indicador-count-card-2 fa-solid fa-check text-center"></p>
                    </div>
                </div>
            </article>

            <article class="col-sm-12 col-md-4 col-lg-2 mt-3">
                <div>
                    <div class="sombra cuadros">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="text-gold text-center pt-4 border-bottom p-3"><strong>Creación
                                        Expediente</strong></li>
                                <li class="list-group-item-2 border-bottom">
                                    <ul class="list-unstyled p-2">
                                        <li>Del <strong></strong>
                                            <a href="javascript: void(0)" class="float-end">
                                                <i class="fa-solid fa-calendar-plus"></i>
                                            </a>
                                        </li>
                                        <li>Al <strong></strong></li>
                                    </ul>
                                </li>
                                <li class="list-group-item-3 iconosFut p-3 ">
                                    <a href="javascript: void(0)" class="text-leaft">
                                        <i class="fa-solid fa-circle-plus fa-lg" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="indicador-count-card-2 fa-solid fa-check text-center"></p>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">

                <div class="sombra cuadros">
                    <div class="card-2" style="width:100%;">
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="text-gold text-center pt-4 border-bottom p-3"><strong>Habilitar
                                    Proveedores</strong>
                            </li>

                            <li class="list-group-item-2 border-bottom">
                                <ul class="list-unstyled p-2">
                                    <li>Del <strong></strong><a href="javascript: void(0)" class="float-end"><i
                                                class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong></strong></li>
                                </ul>
                            </li>
                            <li class="list-group-item-3 iconosFut p-3 ">
                                <a href="javascript: void(0)" class="text-leaft"><i class="fa-solid fa-pen-to-square fa-lg"
                                        aria-hidden="true"></i></a>
                                <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-file-pdf fa-lg"
                                        aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="indicador-count-card-2 fa-solid fa-check text-center"></p>
                </div>
            </article>
            <article class="col-sm-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="sombra cuadros">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="text-gold text-center pt-4 border-bottom p-3"><strong>Habilitar
                                        Productos</strong></li>

                                <li class="list-group-item-2 border-bottom">
                                    <ul class="list-unstyled p-2">
                                        <li>Del <strong></strong><a href="javascript: void(0)" class="float-end"><i
                                                    class="fa-solid fa-calendar-plus"></i></a></li>
                                        <li>Al <strong></strong></li>
                                    </ul>
                                </li>
                                <li class="list-group-item-3 iconosFut p-3 ">
                                    <a href="javascript: void(0)" class="text-leaft"><i
                                            class="fa-solid fa-pen-to-square fa-lg" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="indicador-count-card-2 fa-solid fa-check text-center"></p>
                    </div>
                </div>
            </article>
            <article class="col-sm-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="sombra cuadros">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="text-gold text-center pt-4 border-bottom p-3"><strong>Habilitar
                                        URGs</strong>
                                </li>

                                <li class="list-group-item-2 border-bottom ">
                                    <ul class="list-unstyled p-2">
                                        <li>Del <strong></strong><a href="javascript: void(0)" class="float-end"><i
                                                    class="fa-solid fa-calendar-plus"></i></a></li>
                                        <li>Al <strong></strong></li>
                                    </ul>
                                </li>
                                <li class="list-group-item-3 iconosFut  p-3 ">
                                    <a href="javascript: void(0)" class="text-leaft"><i
                                            class="fa-solid fa-circle-plus fa-lg" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="indicador-count-card-2 fa-solid fa-check text-center"></p>
                    </div>
                </div>
            </article>

        </div> --}}
    </div>

    <!-- datos generales y anexos -->
    <div class="container" id="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @if ($id_contrato_marco != null)
                    {{-- Zona de modificacion --}}
                    <a href="javascript: void(0)"
                        onclick="window.open('{{ route('contrato.edit', $id_contrato_marco) }}', '_self')"
                        class="nav-link " id="nav-home-tab" type="button" role="tab" data-bs-toggle="tab"
                        data-bs-targett="#nav-home" aria-controls="nav-home" aria-selected="false">
                        <h4 class="inactivo text-1">Datos generales</h4>
                    </a>
                @else
                    <a href="javascript: void(0)" onclick="window.open('{{ route('contrato.create') }}', '_self')"
                        class="nav-link " id="nav-home-tab" type="button" role="tab" data-bs-toggle="tab"
                        data-bs-target="#nav-home" aria-controls="nav-home" aria-selected="false">
                        <h4 class="inactivo text-1">Datos generales</h4>
                    </a>
                @endif
                <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                    type="button" role="tab" aria-controls="nav-profile" aria-selected="true">
                    <h4 class="text-activo">Anexos</h4>
                </button>
            </div>
        </nav>

        <div class="tab-content border" id="nav-tabContent">
            <!-- Anexos -->
            <input type="hidden" id="id_contrato_marco" name="id_contrato_marco" value="{{ $id_contrato_marco }}">
            <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <br>
                <h6 class="titl-1 ml-3">1. Adjuntar documentos</h6>
                <div class="row mz-2">
                    <div class="col-12 m-2 d-flex">
                        <p class="mx-3">Escanea y adjunta los siguientes documentos en formato PDF no mayor a 30MB. Se
                            requerirán la versión original y pública</p>
                        <a href="javascript: void(0)" data-bs-container="body" data-bs-toggle="popover"
                            data-bs-placement="right"
                            data-bs-content="Los documentos que deberás adjuntar son: Estudios de viabilidad del Contrato Marco, Estudio de demanda, Estudio de mercado (opcional), Oficio de inicio de Contrato Marco, Modelo de Contrato Marco, Términos generales de Contrato Marco, Términos específicos del Contrato Marco, Creación del Contrato Marco.">
                            <span class="material-symbols-outlined">
                                <i class="fa-sharp fa-solid fa-circle-info text-gold"></i>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 d-flex justify-content-end mt-3">
                        <button type="button" id="modalAnexos"
                            class="btn btn-white boton-1 btn-block col-12 col-md-3 p-1" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <i class="fa-solid fa-upload"></i>Adjuntar
                        </button>

                    </div>
                </div>

                <br>

                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-hover nowrap jtable_center" style="width:100%"
                            id="tabla_anexos_contrato">
                            <thead>
                                <tr>
                                    <th scope="col">Número</th>
                                    <th scope="col">Nombre del documento</th>
                                    <th scope="col" class="tab-cent">Original</th>
                                    <th scope="col" class="tab-cent">Público</th>
                                    <th scope="col" class="tab-cent">Editar</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="form-row col-12 mt-3 modal-footer">
                    <button class="btn m-2 boton-1" id="btn-continuar-anexo"
                        onclick="window.open('{{ url('grupo_revisor') }}', '_self')">Continuar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- datos generales y anexos -->
@endsection
@section('js')
    @routes(['contratosMarco', 'anexosContrato', 'expedientesContrato'])
    <script src="{{ asset('asset/js/anexo-contrato.js') }}" type="text/javascript"></script>
    <script>
        var $sortable = $('.sortable');

        $sortable.on('click', function() {

            var $this = $(this);
            var asc = $this.hasClass('asc');
            var desc = $this.hasClass('desc');
            $sortable.removeClass('asc').removeClass('desc');
            if (desc || (!asc && !desc)) {
                $this.addClass('asc');
            } else {
                $this.addClass('desc');
            }

        });
    </script>
    {{-- ---------este abre el popover------------ --}}
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>
@endsection
