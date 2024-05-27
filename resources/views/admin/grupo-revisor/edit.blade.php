@extends('layouts.admin')

@section('content')
    @include('admin.contrato-marco.submenu')
    <input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">
    <div class="container">

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link mz-2 active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button"
                    role="tab" aria-controls="nav-home" aria-selected="true">
                    <h4 class="text-activo">Grupo Revisor</h4>
                </button>
            </div>
        </nav>
        <div class="tab-content border" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <form id="frm_grupo_1" enctype="multipart/form-data" method="POST"
                    action="{{ route('grupo_revisor.update', ['grupo_revisor' => $grupo->id_e]) }}">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-3 mb-3 text-gold">
                            <label for="convocatoria">Convocatoria No</label>
                            <input type="text" class="form-control text-1" id="convocatoria" name="convocatoria"
                                value="{{ $grupo->convocatoria }}">
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                                <h2 class="mb-0 accordion-header" id="headingOne">
                                    <button class="accordion-button boton-1  text-dorado-titulo" type="button"
									data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        GRUPO REVISOR CONVOCATORIA<span class="text-dorado float-end">Sección <span
                                                id="seccion_grupo">Completa</span>
												<i class="fa-solid fa-circle-exclamation"></i></span>
                                    </button>
                                </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body m-2">
                                    <div class="row my-3">
                                        <div class="col-12">
                                            <p class="text-1 mt-4">Todos los campos son automaticos solo adjunta los
                                                documentos que se solicitan.
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-8 mz-2">
                                            <div class="form-group">
                                                <label for="emite" class=" text-1">Emite</label>
                                                <input type="text" class="form-control text-1" id="emite"
                                                    name="emite" value="{{ $grupo->emite }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label for="objeto" class="text-1">Objeto del bien/servicio del Contrato
                                                    Marco</label>
                                                <textarea class="form-control text-1" id="objeto" name="objeto" rows="3" readonly>{{ $grupo->objeto }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label for="motivo" class="text-1">Motivo de la convocatoria</label>
                                                <textarea class="form-control text-1" id="motivo" name="motivo" rows="3" readonly>{{ $grupo->motivo }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-8 mz-2">
                                            <div class="form-group">
                                                <label for="numero_oficio" class=" text-1">Número de oficio de invitación a
                                                    la mesa de trabajo</label>
                                                <input type="text" id="numero_oficio" name="numero_oficio"
                                                    class="form-control text-1" value="{{ $grupo->numero_oficio }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-12">
                                            <h6 class="titl-1">Adjuntar documentos</h6>
                                            <p class="text-1">Escanea el documento en formato PDF no mayor a 30MB.</p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="archivo_invitacion" class="text-1 mx-3">Oficio de invitación a
                                                    la mesa de trabajo</label>
                                                <input type="file" class="form-control text-1" id="archivo_invitacion"
                                                    aria-describedby="inputGroupFileAddon03" aria-label="Upload"
                                                    accept=".pdf" name="archivo_invitacion">
                                                <label class="text-1 mt-3 mx-3">Archivo actual: <span
                                                        id="requisiciones_invitacion">{{ $grupo->archivo_invitacion }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="archivo_ficha_tecnica" class="text-1 mx-3">Ficha
                                                    técnica</label>
                                                <input type="file" class="form-control text-1"
                                                    id="archivo_ficha_tecnica" aria-describedby="inputGroupFileAddon03"
                                                    aria-label="Upload" accept=".pdf" name="archivo_ficha_tecnica">
                                                <label class="text-1 mt-3 mx-3">Archivo actual: <span
                                                        id="requisiciones_ficha">{{ $grupo->archivo_ficha_tecnica }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                                <h2 class="mb-0 accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed boton-2 btn-block text-left text-dorado-titulo" type="button"
									data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
									aria-controls="collapseTwo">
                                        GRUPO REVISOR MESA DE TRABAJO<span class="text-dorado float-end">Sección <span
                                                id="seccion_grupo_mesa">Completa</span> <i
                                                class="fa-solid fa-circle-exclamation"></i></span>
                                    </button>
                                </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
							data-bs-parent="#accordionExample">
                                <div class="accordion-body m-2">
                                    <div class="row my-3">
                                        <div class="col-12">
                                            <p class="text-1 mt-4">La captura de los campos es automático y sólo adjuntarás
                                                la “Minuta”.
                                            </p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-4 mz-2">
                                            <div class="form-group">
                                                <label for="fecha_mesa" class="text-1 mx-3">Fecha de mesa de
                                                    trabajo</label>
                                                <div class="input-group date hoyant">
                                                    <input type="text" class="form-control text-1" name="fecha_mesa"
                                                        id="fecha_mesa" value="{{ $grupo->fecha_mesa->format('d/m/Y') }}"
                                                        readonly>
                                                    <span class="input-group-addon input-group-text" id="basic-addon1"><i
                                                            class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-8 mz-6">
                                            <div class="form-group">
                                                <label for="lugar" class="text-1">Lugar de la mesa de trabajo</label>
                                                <input type="text" id="lugar" name="lugar"
                                                    class="form-control text-1" value="{{ $grupo->lugar }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label for="comentarios" class="text-1">Comentarios de las URG</label>
                                                <textarea class="form-control text-1" id="comentarios" name="comentarios" rows="3" readonly>{{ $grupo->comentarios }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-4 mz-2">
                                            <div class="form-group">
                                                <label class="text-1 mx-3">Asistieron <span id="contador_urg">
                                                        {{ $grupo->numero_asistieron }} </span> URG's</label>
                                                <input type="hidden" name="numero_urg" id="numero_urg"
                                                    value="{{ $grupo->numero_asistieron }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3 scrollspy-example bg-light p-3 rounded-2 scroll @if (count($urgs) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" tabindex="0">
                                        <div class="col-12 col-md-12 mz-2">
                                            <div class="form-group">
                                                @foreach ($urgs as $key => $urg)
                                                    <div class="row hr p-3">
                                                        <div class="col-12 col-sm-3">
                                                            <div class="form-group">
                                                                <input type="text" name="nombre[]"
                                                                    class="form-control text-1" readonly
                                                                    value="{{ $urg->nombre }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-sm-2 text-align-center">
                                                            <div class="form-group">
                                                                <div class="custom-control custom-switch">
                                                                    <label class="switch">
                                                                        <input type="checkbox"
                                                                            name="estatus[{{ $key }}]"
                                                                            value="1"
                                                                            @if ($urg->seleccionado == 1) checked @endif
                                                                            onclick="contador(this);">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label for="observaciones" class="text-1">Observaciones</label>
                                                <textarea class="form-control text-1" id="observaciones" name="observaciones" rows="3" readonly>{{ $grupo->observaciones }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-12">
                                            <h6 class="titl-1">Adjuntar documentos</h6>
                                            <p class="text-1">Escanea el documento en formato PDF no mayor a 30MB.</p>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="archivo_minuta" class="text-1 mx-3">Minuta</label>
                                                <input type="file" class="form-control text-1" id="archivo_minuta"
                                                    aria-describedby="inputGroupFileAddon03" aria-label="Upload"
                                                    accept=".pdf" name="archivo_minuta">
                                                <label class="text-1 mt-3 mx-3">Archivo subido en requisiciones: <span
                                                        id="requisiciones_minuta">{{ $grupo->archivo_minuta }}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn boton-1" id="update_grupo">Actualizar</button>
                                    </div>
                                </div>
							</div>
						</div>		
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <a href="{{ route('expedientes_contrato.index') }}" class="btn boton-1">Continuar</a>
    </div>
@endsection

@section('js')
    @routes(['service', 'submenu'])
    <script src="{{ asset('asset/js/grupo_revisor.js') }}" type="text/javascript"></script>
@endsection
