<div class="modal fade" id="edit_urg_cm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Editar URG participante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul id="alerta_modificado_ucm"></ul>
                    <form class="form-group text-1" id="frmCMU" method="POST">
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="id_urg">URG participante</label>
                                    <select class="form-control text-1" id="id_urg" name="id_urg">
                                        <option disabled="" selected="" value="0">Seleccione</option>
                                        <option value="{{ $urg[0]->id }}" selected>{{ $urg[0]->nombre }}</option>
                                        @foreach($urgs as $item)
                                        <option value="{{ $item->id }}" @if($cmu->urg_id == $item->id) selected='selected' @endif>{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="fecha_firma" class="text-1">Fecha de firma</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="fecha_firma" id="fecha_firma" value="{{ date('d-m-Y', strtotime($cmu->fecha_firma)) }}">
                                        <span class="input-group-addon input-group-text" id="fecha_firma"><i class="fa fa-calendar" id="fecha_firma"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="arch_actual">Firma terminos especificos (Archivo actual)</label>
                                    <input type="text" class="form-control" name="arch_actual" id="arch_actual" value="{{$cmu->a_terminos_especificos}}" disabled>
                                    <input type="hidden" id="id_cmu" name="id_cmu" value="{{ $cmu->id }}">
                                    <input type="hidden" id="id_cm" name="id_cm" value="{{ $cmu->contrato_marco_id }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="terminos_especificos">Firma terminos especificos (Archivo Nuevo)</label>
                                    <input type="file" class="form-control" id="terminos_especificos" name="terminos_especificos" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="numero_archivo_adhesion">Numero archivo adhesión</label>
                                    <input type="text" class="form-control text-1" id="numero_archivo_adhesion" name="numero_archivo_adhesion" required value="{{ $cmu->numero_archivo_adhesion}}"> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="btn_edit_ucm">Guardar</button>
            </div>
        </div>
    </div>
</div>