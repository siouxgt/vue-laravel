<div class="modal fade" id="info_proveedor_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaAlmacenLabel"><samp class="text-mensaje">Datos del contacto - Matriz de escalamiento</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p class="text-gold">TERCER NIVEL</p>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" value="{{ $proveedor->nombre_tres." ".$proveedor->primer_apellido_tres." ".$proveedor->segundo_apellido_tres }}" readonly>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" id="cargo" value="{{ $proveedor->cargo_tres }}" readonly>
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="">Número fijo</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->telefono_tres }}" readonly>
                </div>
                <div class="col">
                    <label for="">Extensión</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->extension_tres }}" readonly>
                </div>
                <div class="col">
                    <label for="">Número de celular</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->celular_tres }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="">Correo electrónico</label>
                <input type="text" class="form-control" id="" value="{{ $proveedor->correo_tres }}" readonly>
            </div>

            <hr>

            <p class="text-gold">SEGUNDO NIVEL</p>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" value="{{ $proveedor->nombre_dos." ".$proveedor->primer_apellido_dos." ".$proveedor->segundo_apellido_dos }}" readonly>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" id="cargo" value="{{ $proveedor->cargo_dos }}" readonly>
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="">Número fijo</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->telefono_dos }}" readonly>
                </div>
                <div class="col">
                    <label for="">Extensión</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->extension_dos }}" readonly>
                </div>
                <div class="col">
                    <label for="">Número de celular</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->celular_dos }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="">Correo electrónico</label>
                <input type="text" class="form-control" id="" value="{{ $proveedor->correo_dos }}" readonly>
            </div>

            <hr>

             <p class="text-gold">PRIMER NIVEL</p>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" value="{{ $proveedor->nombre_uno." ".$proveedor->primer_apellido_uno." ".$proveedor->segundo_apellido_uno }}" readonly>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" id="cargo" value="{{ $proveedor->cargo_uno }}" readonly>
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="">Número fijo</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->telefono_uno }}" readonly>
                </div>
                <div class="col">
                    <label for="">Extensión</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->extension_uno }}" readonly>
                </div>
                <div class="col">
                    <label for="">Número de celular</label>
                    <input class="form-control" type="text" id="" value="{{ $proveedor->celular_uno }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="">Correo electrónico</label>
                <input type="text" class="form-control" id="" value="{{ $proveedor->correo_uno }}" readonly>
            </div>

        </div>
      </div>
    </div>
</div>