@extends('layouts.admin')

@section('content') 
    @include('admin.contrato-marco.submenu')   
    <input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">
    <div class="container">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <h4 class="text-activo" id="proceso">Expediente</h4>
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
                <form id="frm_expediente_cm" method="POST" action="{{ route('expedientes_contrato.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mt-3">
                        <div class="row mx-3 solo">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label for="f_creacion">Fecha de creación</label>
                                    <div class="input-group date hoy">
                                        <input type="text" class="form-control text-1" name="f_creacion" id="f_creacion" required autocomplete="off" value="{{ date('d/m/Y') }}">
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row col-12 mt-3">
                                <div class="form-group col-12 col-md-4">
                                    <label for="metodo" class="text-gold">Método</label>
                                    <select id="metodo" name="metodo" class="form-control text-2" required>
                                        <option value="">Seleccione</option>
                                        <option value="Convocatoria Pública Contrato Marco">Convocatoria Pública Contrato Marco</option>
                                        <option value="Convocatoria Restringida Contrato Marco">Convocatoria Restringida Contrato Marco</option>
                                        <option value="Convocatoria Directa Contrato Marco">Convocatoria Directa Contrato Marco</option>
                                    </select>
                                </div>
                                <div class="form-group col-12 col-md-4">
                                    <label for="num_procedimiento" class="text-gold">Número de procedimiento</label>
                                    <input type="text" class="form-control text-2" id="num_procedimiento" name="num_procedimiento" required>
                                </div>
                            </div>
                            <div class="form-row col-12 mt-4 mz-2 text-1">
                                <div class="form-group">
                                    <label for="imagen">Imagen</label>
                                    <input type="file" class="form-control text-1" id="imagen" accept="image/png, image/jpeg, image/jpg" name="imagen">
                                </div>
                            </div>
                            <div class="form-row col-12 mt-3 modal-footer">
                                <button type="submit" class="btn boton-1" id="guardar_expcm">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- acordión -->
        </div>
    </div>
    <hr>
    <div class="container">
        <a href="{{ route('expedientes_contrato.index') }}">
            <h2 class="text-gold-1 text-start"><i class="fa-solid fa-arrow-left gold"></i><strong> Ver expedientes</strong></h2>
        </a>
        <div class="botones">
            <a class="btn m-2 boton-1" href="{{ route('habilitar_proveedores.index') }}" role="button">Continuar</a>
        </div> 
    </div>
@endsection
@section('js')
    @routes(['expedientesContrato','submenu'])
    <script src="{{ asset('asset/js/expediente_contrato.js') }}" type="text/javascript"></script>
@endsection