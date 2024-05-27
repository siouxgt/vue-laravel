<div class="modal fade" id="responder_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Responder mensaje</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
          <div class="row">
              <div class="col">
                  <p class="text-2 font-weight-bold">Origen</p>
              </div>
              <div class="col">
                  <p class="text-2 font-weight-bold">ID Producto</p>
              </div>
              <div class="col">
                  <p class="text-2 font-weight-bold">ID Orden</p>
              </div>
              <div class="col">
                  
              </div>
          </div>
          <div class="row mt-3 mb-4">
              <div class="col">
                  <p class="text-2">{{ $mensaje->origen }}</p>
              </div>
              <div class="col">
                  <p class="text-2">{{ $mensaje->producto }}</p>
              </div>
              <div class="col">
                  <p class="text-2">{{ $mensaje->orden_compra }}</p>
              </div>
              <div class="col">
                  
              </div>
          </div>
          <div class="separator mb-3"></div>
          <div class="row">
              <div class="col-7">
                  <p class="text-2">{{ $mensaje->remitente }}</p>
              </div>
              <div class="col-4">
                  <p class="text-2 float-right">{{ $mensaje->created_at }}</p>
              </div>
          </div>

          <p class="text-1 mt-4"><strong>{{ $mensaje->asunto }}</strong></p>

          <div class="col-12 bg-light mt-1">
              <p class="text-1">
                  {{ $mensaje->mensaje }}
              </p>
          </div>
          <div class="col-12">
            @if($mensaje->imagen != null)
              <img src="{{ asset('storage/img-mensaje/'.$mensaje->imagen) }}" class="img_mensaje">
            @endif 
          </div>
          <div class="separator mb-3"></div>
          <form id="frm_responder">
            <div class="form-group">
              <label for="message-text" class="col-form-label">Responde aquí el mensaje</label>
              <textarea class="form-control text-1" id="message-text" rows="5" cols="10" name="respuesta" onkeydown="caracteres(this,'con_resp')" required >{{ $mensaje->respuesta }}</textarea>
              <p class="form-text text-right" id="con_resp">0/1000 palabras</p>
              <input type="hidden" name="mensaje" value="{{ $mensaje->id_e}}">
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        @if($mensaje->respuesta == null)
          <button type="button" class="btn boton-1"  onclick="respuestaSave();">Enviar</button>
        @endif
      </div>
    </div>
    
  </div>
</div>