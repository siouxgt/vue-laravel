function store(){
    if(!formValidate('#frm_licitacion_1')){ return false; };
    let expediente_id = document.getElementById("expediente_id").value;
    let formData = new FormData($('#frm_licitacion_1').get(0));
    formData.append('expediente_id', expediente_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('licitacion.store'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                let encabezadoDatos = document.querySelector("#seccion_datos");
                encabezadoDatos.innerHTML = 'completa';
                let datosGenerales = document.querySelector("#datos");
                datosGenerales.classList.remove('boton-1','text-rojo-titulo');
                datosGenerales.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                datosGenerales.setAttribute('aria-expanded',false);
                let collapseOne = document.querySelector('#collapseOne');
                collapseOne.classList.remove('show');
                let store = document.querySelector("#store_licitacion");
                store.setAttribute("disabled","");
                let adquisicion = document.querySelector("#adquisicion");
                adquisicion.classList.remove('collapsed');
                adquisicion.setAttribute('aria-expanded',true);
                let collapseTwo = document.querySelector("#collapseTwo");
                collapseTwo.classList.add("show");
                let adjudicacionBoton = document.querySelector("#update_licitacion_2");
                adjudicacionBoton.removeAttribute("disabled","");
                let id = document.querySelector("#id_licitacion");
                id.value = respuesta.id.id_e;
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}


function update(numUpdate){
    let id = document.getElementById("id_licitacion").value;
    if(!formValidate('#frm_licitacion_'+numUpdate)){ return false; };
    let formData = new FormData($("#frm_licitacion_"+numUpdate).get(0));
    formData.append('id_licitacion',id);
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('licitacion.update',{licitacion: id}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                let adquisicion = document.querySelector("#adquisicion");
                let aclaraciones = document.querySelector('#aclaraciones');
                let propuesta = document.querySelector('#propuesta');
                let fallo = document.querySelector('#fallo');
                let collapseTwo = document.querySelector("#collapseTwo");
                let collapseThree = document.querySelector("#collapseThree");
                let collapseFour = document.querySelector("#collapseFour");
                let collapseFive = document.querySelector("#collapseFive");
                let botonUpdate3 = document.querySelector("#update_licitacion_3");
                let botonUpdate4 = document.querySelector("#update_licitacion_4");
                let botonUpdate5 = document.querySelector("#update_licitacion_5");
                switch(numUpdate) {
                    case 1:
                        let encabezadoDatos = document.querySelector("#seccion_datos");
                        encabezadoDatos.innerHTML = 'completa';
                        let datosGenerales = document.querySelector("#datos");
                        datosGenerales.classList.remove('boton-1','text-rojo-titulo');
                        datosGenerales.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        datosGenerales.setAttribute('aria-expanded',false);
                        let collapseOne = document.querySelector('#collapseOne');
                        collapseOne.classList.remove('show');
                        adquisicion.classList.remove('collapsed');
                        adquisicion.setAttribute('aria-expanded',true);
                        collapseTwo.classList.add("show");
                    break;
                    case 2:
                        let encabezadoAdjudicacion = document.querySelector("#seccion_adquisicion");
                        encabezadoAdjudicacion.innerHTML = "completa";
                        adquisicion.classList.remove('boton-1','text-rojo-titulo');
                        adquisicion.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        adquisicion.setAttribute('aria-expanded',false);
                        collapseTwo.classList.remove('show');
                        let botonUpdate2 = document.querySelector("#update_licitacion_2");
                        botonUpdate2.setAttribute("disabled","");
                        aclaraciones.classList.remove('collapsed');
                        aclaraciones.setAttribute('aria-expanded',true);
                        collapseThree.classList.add("show");
                        botonUpdate3.removeAttribute("disabled","");
                        proveedores(respuesta.proveedores.proveedores,'propuesta'); 
                    break;
                    case 3:
                        let encabezadoAclaracion = document.querySelector("#seccion_aclaracion");
                        encabezadoAclaracion.innerHTML = "completa";
                        aclaraciones.classList.remove('boton-1','text-rojo-titulo');
                        aclaraciones.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        aclaraciones.setAttribute('aria-expanded',false);
                        collapseThree.classList.remove('show');
                        botonUpdate3.setAttribute("disabled","");
                        propuesta.classList.remove('collapsed');
                        propuesta.setAttribute('aria-expanded',true);
                        collapseFour.classList.add("show");
                        botonUpdate4.removeAttribute("disabled","");

                    break;
                    case 4:
                        let encabezadoPropuesta = document.querySelector("#seccion_propuesta");
                        encabezadoPropuesta.innerHTML = "completa";
                        propuesta.classList.remove('boton-1','text-rojo-titulo');
                        propuesta.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        propuesta.setAttribute('aria-expanded',false);
                        collapseFour.classList.remove('show');
                        botonUpdate4.setAttribute("disabled","");
                        fallo.classList.remove('collapsed');
                        fallo.setAttribute('aria-expanded',true);
                        collapseFive.classList.add("show");
                        botonUpdate5.removeAttribute("disabled","");
                        proveedores(respuesta.proveedores.proveedores,'aprobados');
                    break;
                    case 5:
                        let encabezadoFallo = document.querySelector("#seccion_fallo");
                        encabezadoFallo.innerHTML = "completa";
                        fallo.classList.remove('boton-1','text-rojo-titulo');
                        fallo.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        fallo.setAttribute('aria-expanded',false);
                        collapseFive.classList.remove('show');
                        botonUpdate5.setAttribute("disabled","");
                        let anexos = document.querySelector("#anexos");
                        anexos.classList.remove('collapsed');
                        anexos.setAttribute('aria-expanded',true);
                        let collapseSix = document.querySelector("#collapseSix");
                        collapseSix.classList.add("show");
                    break;
                }
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });

};


function contador(element,seccion){
    let contadorProveedores = document.querySelector('#contador_proveedores_'+seccion);
    let contador = parseInt(contadorProveedores.innerHTML);
    if(element.checked){
        contador++; 
    }
    else{
        contador--;
    }    
    
    let numeroProveedores = document.querySelector("#numero_proveedores_"+seccion);
    contadorProveedores.innerHTML = numeroProveedores.value = contador;

}

function proveedores(proveedores, seccion){
    let divProveedor = document.querySelector('#proveedores_'+ seccion);
    let contador = `contador(this,'${ seccion}')`;
    let espacio = document.querySelector('#espacio_'+seccion);
    if(proveedores.length > 3 || Object.keys(proveedores).length > 3){
        espacio.classList.remove('espacio_proveedores_corto');
        espacio.classList.add('espacio_proveedores_largo');
    }
    $.each(proveedores,function(index, value){
        if(seccion == 'propuesta' || seccion =="aprobados")
        {
            contador = `contador2(this,'${ seccion}', '${ value['rfc'] }', '${ value['nombre'] }')`;
        }
        let contenido = `<div class="row hr">
                       <div class="col-12 col-sm-1">
                            <div class="form-group">
                                <label for="rfc">RFC</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <input type="text" name="rfc[]" class="form-control" readonly value="${ value['rfc'] }">
                            </div>
                        </div>
                        <div class="col-12 col-sm-2 text-align-center">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <label class="switch">
                                        <input type="checkbox" name="estatus[${ index }]" value="1" onclick="${ contador }">
                                        <span class="slider round"></span>
                                      </label>
                                </div>
                            </div>
                        </div>
                    </div>`;
        divProveedor.innerHTML += contenido;
    });
}

function contador2(element,seccion, rfc, nombre){
    let contadorProveedores = document.querySelector('#contador_proveedores_'+seccion);
    let contador = parseInt(contadorProveedores.innerHTML);
    if(element.checked){
        contador++; 
        proveedorClone(seccion,rfc,nombre);  
    }
    else{
        contador--;
        proveedorRemove(seccion,rfc);
    }    
    
    let numeroProveedores = document.querySelector("#numero_proveedores_"+seccion);
    contadorProveedores.innerHTML = numeroProveedores.value = contador;

}

function proveedorClone(seccion,rfc,nombre){
    if(seccion == 'propuesta'){
        seccion = 'descalificados';
    }
    if(seccion == 'aprobados'){
        seccion = 'adjudicados';
    }
    let espacio = document.querySelector("#espacio_"+seccion);
    let proveedoresSeccion = document.querySelector("#proveedores_"+seccion);
    let contenido = document.createElement('div');
    if(proveedoresSeccion.children.length >= 2){
        espacio.classList.remove('espacio_proveedores_corto');
        espacio.classList.add('espacio_proveedores_largo');
    }
    contenido.classList.add('row', 'hr');
    contenido.setAttribute('id', rfc+seccion );

    contenido.innerHTML =`<div class="col-12 col-sm-1">
                            <div class="form-group">
                                <label for="rfc">RFC</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-3">
                            <div class="form-group">
                                <input type="text" name="_rfc[]" class="form-control" readonly value="${ rfc }">
                            </div>
                        </div>
                        <div class="col-12 col-sm-2 text-align-center">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <label class="switch">
                                        <input type="checkbox" name="_estatus[${ rfc }]" value="1" onclick="contador(this,'${ seccion }')">
                                        <span class="slider round"></span>
                                      </label>
                                </div>
                            </div>
                        </div>
                    </div>`;

    proveedoresSeccion.appendChild(contenido); 

}

function proveedorRemove(seccion, rfc){
    if(seccion == 'propuesta'){
        seccion = "descalificados";
    }
    if(seccion == 'aprobados'){
        seccion = 'adjudicados';
    }
    
    let proveedoresSeccion = document.querySelector("#proveedores_"+seccion);
    let nodo = document.querySelector("#"+rfc+seccion);
    if(nodo.querySelector('.switch > input').checked){ 
        let contadorSeccion = document.querySelector('#contador_proveedores_'+seccion);
        let contador = parseInt( contadorSeccion.innerHTML);
        contador --;
        let numeroProveedores = document.querySelector("#numero_proveedores_"+seccion);
        contadorSeccion.innerHTML = numeroProveedores.value = contador;
    }
    proveedoresSeccion.removeChild(nodo);
}


const modal = document.querySelector("#anexos_modal");

modal.addEventListener('click', (e)=>{
    if(!$('#id_licitacion').val()){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_licitacion.create'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#add_anexo")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
            $(resp_success).modal('show')
        },
        error: function(respuesta) {
            
        }
    });
});

function anexosSave(){
    if(!formValidate('#frm_anexo')){ return false; };
    let formData = new FormData($("#frm_anexo").get(0));
    let id_licitacion = $('#id_licitacion').val();
    formData.append('id_licitacion',id_licitacion);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_licitacion.store'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#add_anexo').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", respuesta.message,"success");
                    let encabezadoAnexos = document.querySelector("#seccion_anexos");
                    encabezadoAnexos.innerHTML ='completa';
                    let anexos = document.querySelector("#anexos");
                    anexos.classList.remove('boton-1','text-rojo-titulo');
                    anexos.classList.add('boton-2','text-dorado-titulo','collapsed');
                   anexosLoad(id_licitacion);
                });
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function edit_anexo_modal(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_licitacion.edit',{anexos_licitacion: id}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#edit_anexo")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
            $(resp_success).modal('show')
        },
        error: function(respuesta) {
            
        }
    });
}

function anexosUpdate(){
    if(!formValidate('#frm_edit')){ return false; };
    let formData = new FormData($("#frm_edit").get(0));
    let id_anexo = $('#id_anexo').val();
    let id_licitacion = $('#id_licitacion').val();
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_licitacion.update',{anexos_licitacion: id_anexo}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#edit_anexo').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", respuesta.message,"success");
                   anexosLoad(id_licitacion);
                });
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });

}

$(document).ready(function() {

    dataTable = $('#tabla_anexos').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        }
    });

});

$('#anexos').click(function(){
    let id_licitacion = $('#id_licitacion').val();
    if(id_licitacion){
       sleep(300).then(()=> {anexosLoad(id_licitacion);}); 
    }
})

function anexosLoad(id){
    dataTable.destroy();
    con = 0;
    dataTable = $('#tabla_anexos').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
         ajax: {
            "url": route('anexos_licitacion.data',{id: id}),
            "type": "GET"
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center",
            }
        ],
        order: [[1, 'asc']],
        columns: [
            { data: 'id_t', defaultContent: '' },
            { data: 'nombre' },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" target="_blank" href="${url}storage/licitacion-publica-${row.carpeta}/${row.archivo_original}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" target="_blank" href="${url}storage/licitacion-publica-${row.carpeta}/${row.archivo_publica}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" onClick="edit_anexo_modal('${ row.id_e }');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>`;
                }
            }
        ]
    });

    dataTable.on('order.dt search.dt', function () {
        let i = 1;
        dataTable.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
 }

function buscador() {
   var input, filter, section, div, rfc, i,j;
   input = document.getElementById("buscar");
   filter = input.value.toUpperCase();
   section = document.getElementById("proveedores");
   div = section.getElementsByTagName("div");
   j = 0;
   for (i = 4; i < div.length; i+=8) {
         rfc = div[i].getElementsByTagName("input")[0];
         if (rfc) {
             if (rfc.value.toUpperCase().indexOf(filter) > -1) {
                 div[j].style.display = "";
             } 
             else {
                 div[j].style.display = "none";
             }
         }
         j+=8;
   }
} 