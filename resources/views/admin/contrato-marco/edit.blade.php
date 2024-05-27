@extends('layouts.admin')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    @include('admin.contrato-marco.submenu')

    <!-- datos generales y anexos -->
    <div class="container" id="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <li class="nav-item" role="">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                        role="tab" aria-controls="nav-home" aria-selected="true">
                        <h4 class="text-activo">Datos generales</h4>
                    </button>
                </li>
                <li class="nav-item" role="">
                    <a href="javascript: void(0)" onclick="window.open('{{ route('anexos_contrato.index') }}', '_self')"
                        type="button" class="nav-link" id="nav-profile-tab" role="tab" data-bs-toggle="tab"
                        data-bs-target="#nav-profile" aria-controls="nav-profile" aria-selected="true">
                        <h4 class="inactivo text-1">Anexos</h4>
                    </a>
                </li>
            </div>
        </nav>
        <input type="hidden" id="id_contrato_marco" name="id_contrato_marco" value="{{ $cm->id_e }}">
        <div class="tab-content border" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <br>
                <h6 class="mx-3 titl-1">1. Contrato Marco</h6>
                <p class="mx-3">Para esta captura requerirás el documento “Contrato Marco”. Los campos marcados con
                    asterisco (<span class="asterisco_obligatorio">*</span>) son obligatorios.</p>
                <hr>
                <form id="frm_datos_generales" enctype="multipart/form-data" method="POST">
                    @method('PUT')
                    <div class="form-group p-3">
                        <div class="row mz-2">
                            <div class="col-sm-12 col-md-4 text-1">
                                <label for="id_contrato">ID</label>
                                <input type="number" class="form-control text-1 id_contrato" name="id_contrato" placeholder=" " aria-label=" " disabled
                                    id="id_contrato" value="{{ $cm->id }}" readonly="readonly" required>
                            </div>
                            <div class="col-sm-12 col-md-4 text-1">
                                <label for="f_creacion">Fecha creación</label>
                                <input type="text" class="form-control text-1" name="f_creacion" id="f_creacion" placeholder=" " aria-label=" " disabled
                                    value="{{ $cm->created_at->format('d/m/Y') }}" readonly="readonly" required>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <label for="imagen" class="text-1">Imagen<span
                                        class="asterisco_obligatorio">*</span></label>
                                <input type="file" class="form-control text-1" id="imagen"
                                    aria-describedby="inputGroupFileAddon03" aria-label="Upload"
                                    accept="image/png, image/jpeg, image/jpg" name="imagen">
                            </div>
                        </div>
                        <div class="row mt-2 my-3">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="gold" for="numero_cm">Número de contrato</label>
                                        <input type="text" class="form-control text-1" name="numero_cm" id="numero_cm" placeholder=" " aria-label=" " disabled
                                            value="{{ $cm->numero_cm }}" readonly="readonly" required>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 mz-2">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="gold" for="nombre_cm">Nombre del contrato<span
                                                class="asterisco_obligatorio">*</span></label>
                                        <input class="form-control text-1" type="text" name="nombre_cm" id="nombre_cm"
                                            value="{{ $cm->nombre_cm }}" placeholder="Proporcione nombre del contrato"
                                            required>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <label for="f_inicio">Fecha inicio<span class="asterisco_obligatorio">*</span></label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="f_inicio" id="f_inicio"
                                        value="{{ $cm->f_inicio->format('Y-m-d') }}"
                                        min="{{ $cm->f_inicio->format('Y-m-d') }}"
                                        max="{{ $cm->f_inicio->format('Y-m-d') }}" required disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <label for="f_fin">Fecha fin<span class="asterisco_obligatorio">*</span></label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="f_fin" id="f_fin"
                                        value="{{ $cm->f_fin->format('Y-m-d') }}" min="{{ $cm->f_fin->format('Y-m-d') }}"
                                        max="{{ $cm->f_fin->format('Y-m-d') }}" required disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 text-1">
                                <br>
                                <label for="objetivo">Objeto del contrato<span
                                        class="asterisco_obligatorio">*</span></label>
                                <div class="form-group">
                                    <textarea class="form-control text-1 text-uppercase" id="objetivo" name="objetivo" rows="3" required>{{ $cm->objetivo }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <h6 class="mx-3 titl-1">2. Responsables</h6>
                    <p class="mx-3">Entidad y Persona responsable del “Contrato Marco”.</p>
                    <hr>

                    @php $varSeleccionado; @endphp
                    <div class="row mx-2 my-3 align-items-end">
                        @php $tipoUrg = ['Dependencia', 'Órgano desconcentrado', 'Administración paraestatal', 'Alcaldía', 'Organismo autónomo']; @endphp
                        <div class="form-group col-sm-12 col-md-6 text-1">
                            <input type="hidden" id="urg_responsable" name="urg_responsable"
                                value="{{ $cm->urg_responsable }}">
                            <label for="entidad_administradora">Entidad administradora<span
                                    class="asterisco_obligatorio">*</span></label>
                            <select id="entidad_administradora" name="entidad_administradora" class="form-select text-1"
                                required>
                                <option disabled="" selected="" value="0">Seleccione</option>
                                @foreach ($entidad_adm as $key => $entidad)
                                    <option value="{{ $entidad->id_e }}"
                                        @if ($entidad->id == $cm->urg_id) selected {{ $varSeleccionado = $key }} @endif
                                        data="{{ $entidad->direccion }}">
                                        {{ $tipoUrg[$entidad->tipo - 1] . ' - ' . $entidad->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6">
                            <div class="form-group text-1">
                                <label for="domicilio_ea">Domicilio de la entidad administradora<span
                                        class="asterisco_obligatorio">*</span></label>
                                <input type="text" id="domicilio_ea" name="domicilio_ea" class="form-control text-1" placeholder=" " aria-label=" " disabled
                                    readonly required value="{{ $entidad_adm[$varSeleccionado]->direccion }}">
                                <input type="hidden" id="id_urg_responsable" name="id_urg_responsable">
                            </div>
                        </div>
                    </div>
                    <div class="row mx-3 my-3 align-items-end">
                        <div class="form-group col-sm-12 col-md-6 text-1" id="lista_responsables">
                            <label for="responsable_sel">Responsable<span class="asterisco_obligatorio">*</span></label>
                            <select id="responsable_sel" name="responsable_sel" class="form-select text-1" required>
                                <option value="{{ $cm->user->id }}" selected data="{{ $cm->user->cargo }}">
                                    {{ $cm->user->nombre }} {{ $cm->user->primer_apellido }}
                                    {{ $cm->user->segundo_apellido }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-sm-12 col-md-6 text-1">
                            <label for="cargo">Cargo<span class="asterisco_obligatorio">*</span></label>
                            <input type="text" id="cargo" name="cargo" class="form-control text-1" placeholder=" " aria-label=" " disabled
                                readonly="readonly" value="{{ $cm->user->cargo }}" required>
                        </div>
                    </div>
                    <br>

                    <h6 class="mx-3 titl-1">3. Selección de bienes / servicios</h6>
                    <p class="mx-3">Capítulo y Partida de este Contrato Marco</p>
                    <hr>

                    @php
                        $arr_capitulos = [
                            ['1', '1000 SERVICIOS PERSONALES'],
                            ['2', '2000 MATERIALES Y SUMINISTROS'],
                            ['3', '3000 SERVICIOS GENERALES'],
                            ['4', '4000 TRANSFERENCIAS, ASIGNACIONES, SUBSIDIOS Y OTRAS AYUDAS'],
                            ['5', '5000 BIENES MUEBLES, INMUEBLES E INTANGIBLES'],
                        ];
                        $contador = 0;
                        $totalCp = count((array) $cm->capitulo_partida);
                    @endphp

                    <input type="hidden" name="" id="total_capitulos_partidas" value="{{ $totalCp }}">
                    <div id="contenedor" class="parentDivCP">
                        @foreach ($cm->capitulo_partida as $cp)
                            <div class="row mx-3 mb-3 text-1 parentDiv" id="hijo[{{ $contador }}]">
                                <div class="col-sm-12 col-md-6 p-3 mt-3">
                                    <label for="capitulo">Capítulo<span class="asterisco_obligatorio">*</span></label>
                                    <select class="form-select text-1 elcapitulo" id="capitulo{{ $contador }}"
                                        name="capitulo[{{ $contador }}]" required aria-label=" ">
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        @foreach ($arr_capitulos as $item)
                                            @if ($cp->capitulo == $item[0])
                                                <option value="{{ $item[0] }}" selected='selected'>
                                                    {{ $item[1] }}
                                                </option>
                                            @else
                                                <option value="{{ $item[0] }}">{{ $item[1] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-sm-12 col-md-6 p-3 mt-3 mb-4">
                                    <label for="partida">Partida<span class="asterisco_obligatorio">*</span></label>
                                    <select class="form-select text-1 optionsPartida" id="partida"
                                        name="partida[{{ $contador }}]" required aria-label=" ">
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        <option value="{{ $cp->partida }}-{{ $cp->descripcion }}" selected='selected'>
                                            {{ $cp->partida }} -- {{ $cp->descripcion }}
                                        </option>
                                    </select>
                                </div>

                            </div>    
                                <hr>
                                @if ($contador == 0)
                                    <div class="form-row col-12 mt-2 modal-footer">
                                        <button type="button" class="btn boton-1" id="btn-agregar-cp">Agregar</button>
                                    </div>
                                @else
                                    <div class="form-row col-12 mt-2 modal-footer">
                                        <button type="button" class="btn boton-1"
                                            id="btn-eliminar-input-{{ $contador }}">Quitar</button>
                                    </div>
                                @endif
                            </div>
                            @php $contador++; @endphp
                        @endforeach                        
                    </div>

                    <h6 class="mx-3 gold">¿Este Contrato Marco comprende bienes y/o servicios de lineamientos de compras
                        verdes?</h6>
                    <div class="custom-control custom-switch mx-4">
                        <label class="switch form-check form-switch">
                            <input class="form-check-input " type="checkbox" id="compras_verdes" name="compras_verdes"
                                @if ($cm->compras_verdes) checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <br>

                    <div class="row mx-3 my-3" id="parentDivValTec">
                        <div class="form-group col-12 col-md-6">
                            <h6 class="gold">Validación técnica de este Contrato Marco</h6>
                            <div class="custom-control custom-switch">
                                <label class="switch form-check form-switch">
                                    <input class="form-check-input " type="checkbox" id="val_tec" name="val_tec" class="val_tec"
                                        @if ($cm->validacion_tecnica) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 text-1">
                            <label for="validaciones_seleccionadas">Dirección</label>

                            <select class="form-control text-1" id="validaciones_seleccionadas"
                                name="validaciones_seleccionadas[]" multiple="multiple" type="text" placeholder="" aria-label=""
                                @if (!$cm->validacion_tecnica) disabled @endif>
                                @php $encontrado; @endphp
                                @for ($i = 0; $i < count($responsables_vt); $i++)
                                    @for ($j = 0; $j < count($cm->validaciones_seleccionadas); $j++)
                                        @if ($responsables_vt[$i]->id == $cm->validaciones_seleccionadas[$j]->id_val_sel)
                                            @php
                                                $encontrado = true;
                                                break;
                                            @endphp
                                        @else
                                            @php $encontrado = false; @endphp
                                        @endif
                                    @endfor
                                    @if ($encontrado)
                                        <option value="{{ $responsables_vt[$i]->id }}" selected='selected'>
                                            {{ $responsables_vt[$i]->siglas }} -- {{ $responsables_vt[$i]->direccion }}
                                        </option>
                                    @else
                                        <option value="{{ $responsables_vt[$i]->id }}">
                                            {{ $responsables_vt[$i]->siglas }} -- {{ $responsables_vt[$i]->direccion }}
                                        </option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mx-3 my-3">
                        <div class="col-sm-6 col-md-9 mt-3 text-1">
                            @php
                                $sectoresEspecificos = [
                                    ['general', 'General'],
                                    ['mipymes', 'MIPYMES'],
                                    ['campesinos', 'Campesinos'],
                                    ['cooperativas', 'Cooperativas'],
                                    ['elpm', 'Empresas lideradas por mujeres'],
                                    ['sr', 'Grupos rurales'],
                                    ['proa', 'Productor agricola'],
                                ];
                                $sectores_seleccionados;
                            @endphp
                            <label for="sector">¿Este Contrato Marco es para un sector especifico?</label>
                            <select class="form-control" id="sector" name="sector[]" multiple="multiple" aria-label=" ">
                                @for ($i = 0; $i < count($sectoresEspecificos); $i++)
                                    @for ($j = 0; $j < count($cm->sector); $j++)
                                        @if ($sectoresEspecificos[$i][0] == $cm->sector[$j]->sector)
                                            @php
                                                $sectores_seleccionados = true;
                                                break;
                                            @endphp
                                        @else
                                            @php $sectores_seleccionados = false; @endphp
                                        @endif
                                    @endfor
                                    @if ($sectores_seleccionados)
                                        <option value="{{ $sectoresEspecificos[$i][0] }}" selected='selected'>
                                            {{ $sectoresEspecificos[$i][1] }}
                                        </option>
                                    @else
                                        <option value="{{ $sectoresEspecificos[$i][0] }}">
                                            {{ $sectoresEspecificos[$i][1] }}
                                        </option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>    

                    <div class="form-row col-12 mt-3 modal-footer mb-4 px-3">
                        <button type="submit" class="btn boton-1" id="btn-actualizar-contrato">Actualizar y
                            continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- datos generales y anexos -->
@endsection
@section('js')
    @routes(['contratosMarco', 'anexosContrato', 'expedientesContrato', 'submenu'])
    <script src="{{ asset('asset/js/alta-contrato.js') }}" type="text/javascript"></script>
    <script>
        let $sortable = $('.sortable');

        $sortable.on('click', function() {
            let $this = $(this),
                asc = $this.hasClass('asc'),
                desc = $this.hasClass('desc');
            $sortable.removeClass('asc').removeClass('desc');
            if (desc || (!asc && !desc)) {
                $this.addClass('asc');
            } else {
                $this.addClass('desc');
            }
        });
    </script>
@endsection
