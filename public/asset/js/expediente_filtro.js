
const contenedorExp = document.querySelector('#contenedor_exp');

function expediente(id){
   let tipo = ["Convocatoria Pública Contrato Marco","Convocatoria Restringida Contrato Marco","Convocatoria Directa Contrato Marco"];
   
   $.ajax({
      url: route('expedientes_contrato.filtro',{tipo: tipo[id]}),
      type: 'GET',
      success: function(response){
         let contenido = "";
         $.each(response.data, function(index,value){
            contenido += `<article class="col-12 col-md-4 mt-3 p-3">
                    <div class="border rounded p-2 shadow-sm">
                        <div>`;
                            if(value.created_at < 90){
                              contenido += `<p class="porLiberar">Nuevo</p>`;
                            }
                        contenido +=`</div>
                        <!-- botonesConfigurarConvenio -->
                        <div class="row justify-content-end m-2">
                            <div class="btn-group dropright bg-gris-inactivo col-2">
                                <button type="button" class="btn btn-white dropdown-toggle boton-3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span><i class="fa-solid fa-ellipsis-vertical text-gold"></i></span>
                                </button>
                                <div class="dropdown-menu bg-light">
                                    <div class="card" style="width: 18rem;">
                                        <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                            <li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio Marco</strong></li>
                                            <li class="list-group-item bg-light border-bottom"><a href="${ route('expedientes_contrato.edit', { expedientes_contrato: value.id_e }) }"><i class="fa-solid fa-pen-to-square gris"></i> Editar</a></li>
                                            <li class="list-group-item bg-light border-bottom"><a href="#">Eliminar</a></li>
                                            <li class="list-group-item bg-light border-bottom"><a href="#">Duplicar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- botonesConfigurarConvenio -->
                        <div class="row border-dark justify-content-center etiquetaNuevo">
                            <h4 class="text-gold">${ value.metodo }</h4>
                        </div>
                        <div class="row p-3">
                            <div class="col-sm-3">
                                    <span>`;
                                        if( value.imagen){
                                            contenido += `<img src="${ url }storage/img-expedientes/${ value.imagen }" class="perfil-3" alt="${ value.imagen }">`;
                                        }
                                        else{    
                                            contenido += `<h2 class="perfil-3">${ value.metodo.substring(0,1).toUpperCase() }${value.metodo.substring(13,14).toUpperCase() } </h2>`;
                                        }
                                        contenido += `</span>
                            </div>
                            <div class="col-sm-9">
                                <a href="${ route('expedientes_contrato.edit', {expedientes_contrato: value.id_e}) }"><p class="m-1 text-1"><h4>Número procedimiento: <br> ${ value.num_procedimiento }</h4></p></a>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="row espacio mt-3">
                                    <div class="col-sm-6">`;
                                        if(value.liberado){
                                            contenido += `<p class="porLiberar-green">Vigente</p>`;
                                        }
                                        else{
                                            contenido += `<p class="porLiberar-yelow">Por Liberar</p>`;
                                        }
                                   contenido += `</div>
                                    <div class="col-sm-6 float-right">
                                        <p class="text-2 text-end">${ value.porcentaje }%</p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="progress text-end">
                                        <div class="`
                                        if( value.porcentaje < 100) { 
                                             contenido +=  `progress-bar-2`;
                                          } 
                                          else { 
                                             contenido += `progress-bar-1`; 
                                          }
                                          contenido += `" role="progressbar" style="width: ${ value.porcentaje }%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                      </div>
                                </div>
                            </div>
                        <hr>
                            <div class="row align-items-center">
                                <div class="col-sm-3">
                                    <span>
                                        <h2 class="perfil-2">DN</h2>
                                    </span>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-2 text-right-1">Ultima Edición: ${ value.updated_at }</p>
                                </div>
                            </div>
                    </div>
                </article>`;
         });
         contenedorExp.innerHTML = contenido;
      }
   });

}