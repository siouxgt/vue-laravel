var contenido = ``;
const contenidoCM = document.querySelector(".contenedorCM");

function agregarCuadrosContratoMarco(tipo) {

    let titulo = {'vigentes':'Vigentes','xliberar':'Por liberar','xvencer':'Por vencer','vencido':'Vencidos'};
    
   $.ajax({
        url: route('contrato.filtro',{tipo: tipo}),
        type: 'GET',
        success: function(response){

            contenido = `<div class="row m-2">
                    <div class="col-6 col-sm-6">
                        <h2 class="display-4 titulo-1 fw-bolder">${ titulo[tipo] }</h2>
                    </div>
                </div>
                <div class="row m-2">`;

            switch (tipo) {
                case 'vigentes':
                    $.each(response.data, function(index,value){
                        contenido += ` 
                            <article class="col-12 col-md-4 mt-3">
                                <div class="border rounded p-2 shadow-sm">
                                    <div class="mt-2 ml-2">`;
                                    if( value.created_at < 90){
                                        contenido += `<p class="porLiberar">Nuevo</p>`;
                                    }
                                    contenido += `</div>
                                    <div class="row justify-content-end m-2">
                                            <div class="btn-group bg-gris-inactivo col-2">
                                                <button type="button" class="btn btn-white boton-3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span>
                                                        <i class="fa-solid fa-ellipsis-vertical text-gold"></i>
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu bg-light">
                                                    <div class="card" style="width: 18rem;">
                                                        <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                                            <li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio
                                                                    Marco</strong></li>
                                                            <li class="list-group-item bg-light border-bottom"><a href="${ route('contrato.edit', {contrato: value.id_e} ) }"><i class="fa-solid fa-pen-to-square gris"></i>Editar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-dark text-center">
                                            <a href="${ route('contrato.edit', {contrato: value.id_e}) }"><p class="m-1 text-1"><h4>${ value.nombre_cm }</h4></p></a>
                                        </div>
                                        <div class="row p-3">
                                            <div class="col-3">`;
                                                if( value.imagen ){
                                                    contenido += `<img src="${ url }storage/img-contrato/${ value.imagen }" class="perfil-3" alt="${ value.imagen }}">`;
                                                }
                                                else{    
                                                    contenido += `<h2 class="perfil-3">${ value.nombre_cm.substring(0,1).toUpperCase() }</h2>`;
                                                }
                                    contenido += `    
                                            </div>
                                            <div class="col-9">
                                                <p class="m-1 text-2">Proveedores: ${ value.proveedores }</p>
                                                <p class="m-1 text-2">Productos: ${ value.productos }</p>
                                            </div>
                                        </div>
                                    
                                            
                                                <div class="row mt-3">
                                                    <div class="col-6">
                                                        <p class="text-2">Vigente</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-2 text-end">${ value.porcentaje }%</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar-1" role="progressbar" style="width: ${ value.porcentaje }%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                      </div>
                                                </div>
                                          
                            
                                        <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <span>
                                                        <h2 class="perfil-2">DN</h2>
                                                    </span>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-2 text-end">Ultima Edición: ${ value.updated_at } </p>
                                                </div>
                                            </div>
                                    
                                    </div>
                                </article>`;
                    });
                break;
                case 'xliberar':
                    $.each(response.data, function(index,value){
                        contenido += ` 
                            <article class="col-12 col-md-4 mt-3">
                                <div class="border rounded p-2 shadow-sm">
                                    <div class="row justify-content-end m-2">
                                            <div class="btn-group bg-gris-inactivo col-2">
                                                <button type="button" class="btn btn-white boton-3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span>
                                                        <i class="fa-solid fa-ellipsis-vertical text-gold"></i>
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu bg-light">
                                                    <div class="card" style="width: 18rem;">
                                                        <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                                            <li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio
                                                                    Marco</strong></li>
                                                            <li class="list-group-item bg-light border-bottom"><a href="${ route('contrato.edit', {contrato: value.id_e} ) }"><i class="fa-solid fa-pen-to-square gris"></i>Editar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-dark text-center">
                                            <a href="${ route('contrato.edit', {contrato: value.id_e}) }"><p class="m-1 text-1"><h4>${ value.nombre_cm }</h4></p></a>
                                        </div>
                                        <div class="row" p-3>
                                            <div class="col-3">`;
                                                if( value.imagen ){
                                                    contenido += `<img src="${ url }storage/img-contrato/${ value.imagen }" class="perfil-3" alt="${ value.imagen }}">`;
                                                }
                                                else{    
                                                    contenido += `<h2 class="perfil-3">${ value.nombre_cm.substring(0,1).toUpperCase() }</h2>`;
                                                }
                                    contenido += `    
                                            </div>
                                            <div class="col-9">
                                                <p class="m-1 text-2">Proveedores: ${ value.proveedores }</p>
                                                <p class="m-1 text-2">Productos: ${ value.productos }</p>
                                            </div>
                                        </div>
                                      
                                                <div class="row espacio">
                                                    <div class="col-3 porLiberar-yelow">
                                                        <p class="text-3">liberar</p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="text-2 text-end">${ value.porcentaje }%</p>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="progress">
                                                        <div class="progress-bar-2" role="progressbar" style="width: ${ value.porcentaje }%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                      </div>
                                                </div>

                                        <hr>
                                        
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <span>
                                                        <h2 class="perfil-2">DN</h2>
                                                    </span>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-2 text-end">Ultima Edición: ${ value.updated_at } </p>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </article>`;
                    });
                break;
                case 'xvencer':
                    $.each(response.data, function(index,value){
                        contenido += ` 
                            <article class="col-12 col-md-4 mt-3">
                                <div class="border rounded p-2 shadow-sm">
                                    <div class="row justify-content-end m-2">
                                            <div class="btn-group bg-gris-inactivo col-2">
                                                <button type="button" class="btn btn-white boton-3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span>
                                                        <i class="fa-solid fa-ellipsis-vertical text-gold"></i>
                                                    </span>
                                                </button>
                                                <div class="dropdown-menu bg-light">
                                                    <div class="card" style="width: 18rem;">
                                                        <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                                            <li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio
                                                                    Marco</strong></li>
                                                            <li class="list-group-item bg-light border-bottom"><a href="${ route('contrato.edit', {contrato: value.id_e} ) }"><i class="fa-solid fa-pen-to-square gris"></i>Editar</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row border-dark text-center">
                                            <a href="${ route('contrato.edit', {contrato: value.id_e}) }"><p class="m-1 text-1"><h4>${ value.nombre_cm }</h4></p></a>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">`;
                                                if( value.imagen ){
                                                    contenido += `<img src="${ url }storage/img-contrato/${ value.imagen }" class="perfil-3" alt="${ value.imagen }}">`;
                                                }
                                                else{    
                                                    contenido += `<h2 class="perfil-3">${ value.nombre_cm.substring(0,1).toUpperCase() }</h2>`;
                                                }
                                    contenido += `    
                                            </div>
                                            <div class="col-9">
                                                <p class="m-1 text-2">Proveedores: ${ value.proveedores }</p>
                                                <p class="m-1 text-2">Productos: ${ value.productos }</p>
                                            </div>
                                        </div>

                                                <div class="row espacio mt-3">
                                                    <div class="col-6 porLiberar-red">
                                                        <p class="text-4">Por Vencer</p>
                                                    </div>
                                                </div>

                                        <hr>
                      
                                            <div class="row ">
                                                <div class="col-sm-3">
                                                    <span>
                                                        <h2 class="perfil-2">DN</h2>
                                                    </span>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="text-2 text-end">Ultima Edición: ${ value.updated_at } </p>
                                                </div>
                                            </div>
                                       
                                    </div>
                                </article>`;
                    });
                break;
                case 'vencido':
                    $.each(response.data, function(index,value){
                                           contenido += ` 
                                               <article class="col-12 col-md-4 mt-3">
                                                   <div class="border rounded p-2 shadow-sm">
                                                       <div class="row justify-content-end m-2">
                                                               <div class="btn-group bg-gris-inactivo col-2">
                                                                   <button type="button" class="btn btn-white boton-3" data-bs-toggle="dropdown" aria-expanded="false">
                                                                       <span>
                                                                           <i class="fa-solid fa-ellipsis-vertical text-gold"></i>
                                                                       </span>
                                                                   </button>
                                                                   <div class="dropdown-menu bg-light">
                                                                       <div class="card" style="width: 18rem;">
                                                                           <ul class="list-group list-group-flush list-unstyled bg-light text-2">
                                                                               <li class="list-group-item-2 dropdown-header bg-light  border-bottom"><strong>Configurar Convenio
                                                                                       Marco</strong></li>
                                                                               <li class="list-group-item bg-light border-bottom"><a href="${ route('contrato.edit', {contrato: value.id_e} ) }"><i class="fa-solid fa-pen-to-square gris"></i>Editar</a></li>
                                                                           </ul>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                           <div class="row border-dark text-center">
                                                               <a href="${ route('contrato.edit', {contrato: value.id_e}) }"><p class="m-1 text-1"><h4>${ value.nombre_cm }</h4></p></a>
                                                           </div>
                                                           <div class="row p-3">
                                                               <div class="col-3">`;
                                                                   if( value.imagen ){
                                                                       contenido += `<img src="${ url }storage/img-contrato/${ value.imagen }" class="perfil-3" alt="${ value.imagen }}">`;
                                                                   }
                                                                   else{    
                                                                       contenido += `<h2 class="perfil-3">${ value.nombre_cm.substring(0,1).toUpperCase() }</h2>`;
                                                                   }
                                                       contenido += `    
                                                               </div>
                                                               <div class="col-9">
                                                                   <p class="m-1 text-2">Proveedores: ${ value.proveedores }</p>
                                                                   <p class="m-1 text-2">Productos: ${ value.productos }</p>
                                                               </div>
                                                           </div>

                                                                   <div class="row espacio mt-3">
                                                                       <div class="col-6 porLiberar-gold">
                                                                            <p class="text-5">Vencido</p>
                                                                        </div>
                                                                   </div>

                                                           <hr>
                                                           <
                                                               <div class="row">
                                                                   <div class="col-sm-3">
                                                                       <span>
                                                                           <h2 class="perfil-2">DN</h2>
                                                                       </span>
                                                                   </div>
                                                                   <div class="col-sm-9">
                                                                       <p class="text-2 text-end">Ultima Edición: ${ value.updated_at } </p>
                                                                   </div>
                                                               </div>
                                                           
                                                       </div>
                                                   </article>`;
                                       });
                break;
                
            }            
            contenido += "</div><hr>";
            contenidoCM.innerHTML = contenido;
        }
    });

}

