@extends('layouts.admin')

@section('content')
@include('admin.contrato-marco.submenu')
<input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">
    <div class="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <h4 class="text-activo" id="proceso">{{ $expediente->metodo }}</h4>
                </button>
            </div>
        </nav>
        <div class="tab-content border" id="nav-tabContent">
            <!-- datos generales -->
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <br>
                <h6 class="mx-3 titl-1">1. Método de contratación</h6>
                <p class="text-1 mx-3">Selecciona los siguientes campos.</p>
                <hr>
                <form id="frm_expediente_cm">
                    <div class="form-group mt-3">
                        <div class="row mx-3 solo">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label for="f_creacion">Fecha de creación</label>
                                    <div class="input-group date hoy">
                                        <input type="text" class="form-control" name="f_creacion" id="f_creacion" required value="{{ $expediente->f_creacion->format('d/m/Y') }}" autocomplete="off">
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="form-group col-sm-4">
                                    <label for="inputState" class="text-gold">Método</label>
                                    <select id="metodo" name="metodo" class="form-control text-2" required disabled>
                                        <option value="{{ $expediente->metodo }}">{{ $expediente->metodo }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="num_procedimiento" class="text-gold">Número de procedimiento</label>
                                    <input type="text" class="form-control text-2" id="num_procedimiento" name="num_procedimiento" required value="{{ $expediente->num_procedimiento }}">
                                </div>
                            </div>
                             <div class="row mt-4 mz-2 text-1">
                                <div class="col-sm-6">
                                    <label for="imagen">Imagen</label>
                                    <input type="file" class="form-control text-1" id="imagen" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept="image/png, image/jpeg, image/jpg" name="imagen">
                                </div>
                            </div>
                            <input type="hidden" name="expediente_id" id="expediente_id" value="{{ $expediente->id_e}}">
                            <div class="form-row col-12 mt-3 modal-footer">
                                <button type="button" class="btn boton-1" id="update_expediente" onclick="updateExp()">Actualizar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- acordión -->
        </div>
        
        @switch( $expediente->metodo )
            @case('Convocatoria Pública Contrato Marco')
                @include('admin.licitacion-publica.edit')
            @break
            @case('Convocatoria Restringida Contrato Marco')
                @include('admin.invitacion-restringida.edit')
            @break
            @case('Convocatoria Directa Contrato Marco')
                @include('admin.adjudicacion-directa.edit')
            @break
        @endswitch
        </div>
        <hr>
        <div class="container">
            <a href="{{ route('expedientes_contrato.index') }}">
                <span class="text-gold-1 float-left"><i class="fa-solid fa-arrow-left gold"></i><strong> Ver expedientes</strong></span>
            </a>
            <div class="botones">
                <a class="btn m-2 boton-1" href="{{ route('habilitar_proveedores.index') }}" role="button">Continuar</a>
            </div> 
        </div>
@endsection
@section('js')
    @routes(['expedientesContrato','adjudicacion','anexosAdjudicacion','licitacion','anexosLicitacion','invitacion','anexosInvitacion','submenu'])
    <script src="{{ asset('asset/js/expediente_contrato.js') }}" type="text/javascript"></script>
@endsection