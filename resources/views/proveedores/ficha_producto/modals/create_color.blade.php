<div class="modal fade" id="mod_colores" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    <p class="titel-2">Color</p>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-1">Escribe el o los colores de tu producto.</p>
                <form id="frm_colores" enctype="multipart/form-data" method="POST">
                    <div id="color_todos">
                        @php $numColores = 0; @endphp

                        @if($los_colores[0]->color != null)
                        @foreach( $los_colores[0]->color as $c)
                        <div id="color_otro_div_{{$numColores}}" class="form-inline" style='margin-top: 5px'>
                            <label for="color_" class="ml-2">Color</label>
                            <input type="text" class="form-control ml-3" id="color_[]" name="color_[]" placeholder="Inserte nombre del color" require value='{{strtoupper($c->el_color)}}'>
                            @if($numColores == 0)
                            <a class="text-9 ml-5" href="javascript:void(0)" id="btn_agregar_input_color" title="Clic aquí si deseas agregar más colores">
                                <i class="fa-solid fa-circle-plus green"></i><strong>Agregar</strong>
                            </a>
                            @else
                            <button type="button" class="close ml-1" data-dismiss="alert" aria-label="Close" id="color_otro_{{$numColores}}">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            @endif
                        </div>
                        @php $numColores++; @endphp
                        @endforeach

                        @else
                        <div id="color_otro_div_{{$numColores}}" class="form-inline" style='margin-top: 5px'>
                            <label for="color_" class="ml-2">Color</label>
                            <input type="text" class="form-control ml-3" id="color_[]" name="color_[]" placeholder="Inserte nombre del color" require>
                            <a class="text-9 ml-5" href="javascript:void(0)" id="btn_agregar_input_color" title="Si deseas agregar más colores da clic aquí">
                                <i class="fa-solid fa-circle-plus green"></i><strong>Agregar</strong>
                            </a>
                        </div>
                        @php $numColores++;@endphp
                        @endif
                        <input type="hidden" id="mi_contador" value="{{$numColores}}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="btn_agregar_colores">Guardar</button>
            </div>
        </div>
    </div>
</div>