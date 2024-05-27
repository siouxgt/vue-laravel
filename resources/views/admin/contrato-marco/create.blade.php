@extends('layouts.admin')

@section('content')
    <h1 class="m-2 guinda fw-bold p-3">Alta Contratos Marco</h1>
    <div class="row">
        <nav aria-label="breadcrumb ml-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('contrato.index') }}">Contratos Marco</a></li>
            </ol>
        </nav>
    </div>   
   <hr>

    <div class="container-fluid">
        <div class="row">
            <!-- Alta Contrato -->
            <article class="col-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="border shadow-sm">
                        <div class="card bg-verde" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="dorado text-center pt-4 border-bottom p-3"><strong>Alta Contrato</strong></li>
                                <li class="list-group-item-1 border-bottom">
                                    <ul class="list-unstyled p-2 white">
                                        <li>Del </strong><a href="javascript: void(0)" class="float-end"><i
                                                    class="fa-solid fa-calendar-plus white"></i></a></li>
                                        <li>Al </strong></li>
                                    </ul>
                                </li>
                                <li class="list-group-item-1 iconosFut p-3 ">
                                    <a href="javascript: void(0)" class="text-leaft "><i
                                            class="fa-solid fa-pen-to-square fa-lg" aria-hidden="true"></i></a>
                                    <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-file-pdf fa-lg white"
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
            <!-- Alta Contrato -->
            <!-- Grupo Revisor -->
            <article class="col-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="border shadow-sm">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Grupo Revisor</strong></li>

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
                        <p class="indicador-count-card fa-solid fa-check text-center"></p>
                    </div>
            </article>
            <!-- Grupo Revisor -->
            <!-- Creación Expediente -->
            <article class="col-12 col-md-4 col-lg-2 mt-3">
                <div>
                    <div class="border shadow-sm">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Creación
                                        Expediente</strong></li>
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
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="indicador-count-card fa-solid fa-check text-center"></p>
                    </div>
            </article>
            <!-- Creación Expediente -->
            <!-- Habilitar Proveedores -->
            <article class="col-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">

                <div class="border shadow-sm">
                    <div class="card-2" style="width:100%;">
                        <ul class="list-group list-group-flush list-unstyled align-middle">
                            <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Habilitar Proveedores</strong>
                            </li>

                            <li class="list-group-item-2 border-bottom">
                                <ul class="list-unstyled p-2">
                                    <li>Del <strong></strong><a href="javascript: void(0)" class="float-end"><i
                                                class="fa-solid fa-calendar-plus"></i></a></li>
                                    <li>Al <strong></strong></li>
                                </ul>
                            </li>
                            <li class="list-group-item-3 iconosFut p-3 ">
                                <a href="javascript: void(0)" class="float-end"><i class="fa-solid fa-pen-to-square fa-lg"
                                        aria-hidden="true"></i></a>
                                <a href="javascript: void(0)" class="float-right"><i class="fa-solid fa-file-pdf fa-lg"
                                        aria-hidden="true"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <p class="indicador-count-card fa-solid fa-check text-center"></p>
                </div>
            </article>
            <!-- Habilitar Proveedores -->
            <!-- Habilitar Productoso -->
            <article class="col-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="border shadow-sm">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Habilitar
                                        Productos</strong></li>

                                <li class="list-group-item-2 border-bottom">
                                    <ul class="list-unstyled p-2">
                                        <li>Del <strong></strong><a href="javascript: void(0)" class="float-end"><i
                                                    class="fa-solid fa-calendar-plus"></i></a></li>
                                        <li>Al <strong></strong></li>
                                    </ul>
                                </li>
                                <li class="list-group-item-3 iconosFut p-3 ">
                                    <a href="javascript: void(0)" class="float-end"><i
                                            class="fa-solid fa-pen-to-square fa-lg" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <p class="indicador-count-card fa-solid fa-check text-center"></p>
                    </div>
            </article>
            <!--  Habilitar Productoso -->
            <!-- Habilitar URGs -->
            <article class="col-12 col-md-4 col-lg-2 mt-3 d-none d-sm-none d-md-block">
                <div>
                    <div class="border shadow-sm">
                        <div class="card-2" style="width:100%;">
                            <ul class="list-group list-group-flush list-unstyled align-middle">
                                <li class="dorado text-center pt-4 border-bottom p-3 text-truncate"><strong>Habilitar URGs</strong>
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
                        <p class="indicador-count-card fa-solid fa-check text-center"></p>
                    </div>
            </article>
            <!-- Alta Contrato -->
        </div>
    </div>

    

    <!-- datos generales y anexos -->
    <div class="container" id="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                    type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <h4 class="text-activo">Datos generales</h4>
                </button>
                <a href="javascript: void(0)" onclick="window.open('{{ route('anexos_contrato.index') }}', '_self')"
                    type="button" class="nav-link" id="nav-profile-tab" role="tab" data-bs-toggle="tab"
                    data-bs-target="#nav-profile" aria-controls="nav-profile" aria-selected="true">
                    <h4 class="inactivo text-1">Anexos</h4>
                </a>
            </div>
        </nav>

        <div class="tab-content border" id="nav-tabContent">
            <!-- datos generales -->
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <br>
                <h6 class="mx-3 titl-1">1. Contrato Marco</h6>
                <p class="mx-3">Para esta captura requerirás el documento “Contrato Marco”. Los campos marcados con
                    asterisco (<span class="asterisco_obligatorio">*</span>) son obligatorios.</p>
                <hr>
            
                <form id="frm_datos_generales" enctype="multipart/form-data">
                    <div class="form-group m-3">
                        <div class="row mz-2 my-3">
                            <div class="col-sm-12 col-md-3 mz-2 text-1">
                                <label for="id_contrato">ID</label>
                                <input type="number" class="form-control text-1 id_contrato" name="id_contrato" placeholder=" " aria-label=" " disabled
                                    id="id_contrato" value="{{ $ultimo_id }}" readonly="readonly" required>
                            </div>
                            <div class="col-sm-12 col-md-3 form-group text-1">
                                <label for="f_creacion">Fecha creación</label>
                                <input type="text" class="form-control text-1" name="f_creacion" id="f_creacion" placeholder=" " aria-label=" " disabled
                                    value="{{ $fecha_actual }}" readonly="readonly" required >
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="imagen" class="text-1">Imagen<span
                                        class="asterisco_obligatorio">*</span></label>
                                <input type="file" class="form-control text-1" id="imagen"
                                    aria-describedby="inputGroupFileAddon03" aria-label="Upload"
                                    accept="image/png, image/jpeg, image/jpg" name="imagen" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="gold" for="numero_cm">Número de contrato</label>
                                        <input type="text" class="form-control text-1" name="numero_cm"
                                            id="numero_cm" readonly="readonly" required>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12 col-md-4 mz-2">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="gold" for="nombre_cm">Nombre del contrato<span
                                                class="asterisco_obligatorio">*</span></label>
                                        <input class="form-control text-1" type="text" name="nombre_cm"
                                            id="nombre_cm" required>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label for="f_inicio">Fecha inicio<span class="asterisco_obligatorio">*</span></label>
                                    <div class="input-group">
                                        <input type="date" class="form-control text-1" name="f_inicio" id="f_inicio"
                                            min="{{ $fecha_inicio }}" max="{{ $fecha_inicio }}"
                                            value="{{ $fecha_inicio }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label for="f_fin">Fecha fin<span class="asterisco_obligatorio">*</span></label>
                                    <div class="input-group ">
                                        <input type="date" class="form-control text-1" name="f_fin" id="f_fin"
                                            min="{{ $fecha_fin }}" max="{{ $fecha_fin }}"
                                            value="{{ $fecha_fin }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 text-1">
                                <br>
                                <label for="objetivo">Objeto del contrato<span
                                        class="asterisco_obligatorio">*</span></label>
                                <div class="form-group">
                                    <textarea class="form-control text-1 text-uppercase" id="objetivo" name="objetivo" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <h6 class="mx-3 titl-1">2. Responsables</h6>
                    <p class="mx-3">Entidad y Persona responsable del “Contrato Marco”.</p>
                    <hr>

                    <div class="row my-3 mx-2">
                        @php
                            $tipoUrg = [
                                'Dependencia',
                                'Órgano desconcentrado',
                                'Administración paraestatal',
                                'Alcaldía',
                                'Organismo autónomo',
                            ];
                        @endphp
                        <div class="form-group col-sm-12 col-md-6 text-1">
                            <label for="entidad_administradora">Entidad administradora<span
                                    class="asterisco_obligatorio">*</span></label>
                            <select id="entidad_administradora" name="entidad_administradora" class="form-select text-1"
                                required>
                                <option disabled="" selected="" value="0">Seleccione</option>
                                @foreach ($entidad_adm as $entidad)
                                    <option value="{{ $entidad->id_e }}" data="{{ $entidad->direccion }}">
                                        {{ $tipoUrg[$entidad->tipo - 1] . ' - ' . $entidad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <div class="form-group text-1">
                                <label for="domicilio_ea">Domicilio de la entidad administradora<span
                                        class="asterisco_obligatorio">*</span></label>
                                <input type="text" id="domicilio_ea" class="form-control text-1" readonly required required placeholder=" " aria-label=" " disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-2 my-3 losresponsables" id="losresponsables">
                        <div class="form-group col-sm-12 col-md-6 text-1" id="lista_responsables">
                            <label for="responsable_sel">Responsable<span class="asterisco_obligatorio">*</span></label>
                            <select id="responsable_sel" name="responsable_sel"
                                class="form-select text-1 responsable_sel" required>
                                <option value="0" disabled="" selected="">Seleccione</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 text-1">
                            <label for="cargo">Cargo<span class="asterisco_obligatorio">*</span></label>
                            <input type="text" id="cargo" name="cargo" class="form-control text-1"
                                readonly="readonly" required required placeholder=" " aria-label=" " disabled>
                        </div>
                    </div>

                    <br>
                    <h6 class="mx-3 titl-1">3. Selección de bienes / servicios</h6>
                    <p class="mx-3">Capítulo y Partida de este Contrato Marco</p>
                    <hr>

                    <div id="contenedor" class="parentDivCP">
                        <div class="row mx-3 text-1 parentDiv">
                            <div class="form-group col-12 col-md-6">
                                <label for="capitulo">Capítulo<span class="asterisco_obligatorio">*</span></label>
                                <select class="form-control text-1" id="capitulo0" name="capitulo[0]" required>
                                    <option value="0" disabled="" selected="">Seleccione</option>
                                    <option value="1">1000 SERVICIOS PERSONALES</option>
                                    <option value="2">2000 MATERIALES Y SUMINISTROS</option>
                                    <option value="3">3000 SERVICIOS GENERALES</option>
                                    <option value="4">4000 TRANSFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS
                                    </option>
                                    <option value="5">5000 BIENES MUEBLES, INMUEBLES E INTANGIBLES</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label for="partida">Partida<span class="asterisco_obligatorio">*</span></label>
                                <select class="form-control text-1 optionsPartida" id="partida" name="partida[0]"
                                    required>
                                </select>
                            </div>
                            <div class="form-row col-12 mt-2 modal-footer">
                                <button type="button" class="btn boton-1" id="btn-agregar-cp">Agregar</button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="mx-3 gold">¿Este Contrato Marco comprende bienes y/o servicios de lineamientos de compras
                        verdes?</h6>
                    <div class="custom-control form-check form-switch mx-4">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" id="compras_verdes" name="compras_verdes">
                            <span class="slider1 round"></span>
                        </label>
                    </div>
                    <br>

                    <div class="row mx-3" id="parentDivValTec">
                        <h6 class="gold">Validación técnica de este Contrato Marco</h6>
                        <div class="col-sm-12 col-md-6">
                            <div class="custom-control cform-check form-switch">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" id="val_tec" name="val_tec" class="val_tec">
                                    <span class="slider1 round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 text-1">
                            <label for="validaciones_seleccionadas">Dirección</label>
                            <select class="form-control text-1" id="validaciones_seleccionadas"
                                name="validaciones_seleccionadas[]" multiple="multiple" disabled>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 mt-3 text-1">
                            <label for="sector">¿Este Contrato Marco es para un sector especifico?</label>
                            <select class="form-control" id="sector" name="sector[]" multiple="multiple">
                                <option value="general">General</option>
                                <option value="mipymes">MIPYMES</option>
                                <option value="campesinos">Campesinos</option>
                                <option value="cooperativas">Cooperativas</option>
                                <option value="elpm">Empresas lideradas por mujeres</option>
                                <option value="sr">Grupos rurales</option>
                                <option value="proa">Productor agricola</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row col-sm-12 mt-3  mb-3 modal-footer">
                        <button type="submit" class="btn boton-1 mr-2" id="btn-guardar-contrato">Guardar y
                            continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- datos generales y anexos -->
@endsection
@section('js')
    @routes(['contratosMarco', 'anexosContrato', 'expedientesContrato'])
    <script src="{{ asset('asset/js/alta-contrato.js') }}" type="text/javascript"></script>
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
@endsection
