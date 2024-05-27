@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

       <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <div class="col text-center">
                    <p class="text-1  m-2">Revisa los siguientes datos. Para problemas técnicos, contacta al administrador.</p>
                </div>
                <br>
                 <div class="row justify-content-center mb-3">
                    <button type="button" class="btn bg-white d-flex align-items-center" id="problemas_tecnicos">
                        <i class="fa-solid fa-message text-10"></i>
                        <p class="text-mensaje">Problemas técnicos</p>
                    </button>
                </div>

                <div class="text-center mb-2">
                    <p class="text-14 ">Datos del Contrato</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-6 col-sm-12">
                        <div class="progress-1">
                            <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <p class="text-11">5 de 5</p>
                </div>

                <form action="{{ route('orden_compra_urg.revisar_contrato') }}" method="POST" id="frm_datos_contrato">
                    @csrf
                    <div class="form-group m-3">
                        <div class="row">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label class="text-1">Teléfono</label>
                                    <input type="number" class="form-control text-1" name="telefono_urg" required value="{{ $contrato->telefono_urg }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label class="text-1" for="oficio_adhesion">Oficio de adhesión</label>
                                    <select name="oficio_adhesion" id="oficio_adhesion" class="form-control text-1" required>
                                            <option value="">Selecciones una opción</option>
                                        @foreach($archivos as $archivo)
                                            <option value="{{ $archivo->numero_archivo_adhesion }}" @if($contrato->oficio_adhesion == $archivo->numero_archivo_adhesion) selected @endif data="{{ $archivo->contratos->nombre_cm }}" data2="{{ $archivo->contratos->numero_cm }}" data3="{{ $archivo->contrato_m_id }}">{{ $archivo->numero_archivo_adhesion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label class="text-1">Contrato marco</label>
                                    <input type="text" class="form-control text-1" name="antecedente" id="antecedente" readonly value="{{ $contrato->antecedentes }}">
                                    <input type="hidden" name="numero_contrato" id="numero_contrato" value="{{ $contrato->numero_contrato_marco }}">
                                    <input type="hidden" name="contrato_m_id" id="contrato_m_id" value="{{ $contrato->contrato_m_id }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-4 mz-2 text-1">
                                <div class="form-group">
                                    <label class="text-1" for="numero_cm">Artículo</label>
                                    <input type="text" class="form-control text-1" name="articulo" value="{{ $contrato->articulo }}">
                                </div>
                            </div>
                        </div>
                            

                        <div class="row">
                            <div class="col-12 col-md-12 mz-2 text-1">
                                <div class="form-group">
                                    <label class="text-1" for="numero_cm">Garantias solicitadas</label>
                                    <textarea name="garantias_anexas" class="form-control text-1" cols="30" rows="5">{{ $contrato->garantias_anexas }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
    

                <div class="row mb-4 mt-5">
                    <div class="col-6">
                       <a class="btn btn-outline-light-v mt-3 mr-2 float-right" href="javascript: void(0);" onclick="history.back();">
                       <i class="fa-solid fa-arrow-left text-9"></i> Atras</a>
                    </div>
                    <div class="col-6">
                        <div class="botones">
                            <button type="submit" form="frm_datos_contrato" class="btn boton-2 mt-3">Revisar contrato</button>
                        </div>
                    </div>
                </div>
               
        </section>

    @endsection
    @section('js')
    @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection