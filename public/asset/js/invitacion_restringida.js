const articulo = document.querySelector("#articulo");

articulo.addEventListener('change',(e)=>{
    let fraccion = document.querySelector("#fraccion"),
        fechaSesion = document.querySelector("#fecha_sesion"),
        numeroSesion = document.querySelector("#numero_sesion"),
        numeroCotizacion = document.querySelector("#numero_cotizacion"),
        aprobacionOriginal = document.querySelector("#aprobacion_original"),
        aprobacionPublica = document.querySelector("#aprobacion_publica");
    if(articulo.value == "Articulo 54"){
        fraccion.removeAttribute("disabled","");
        fechaSesion.removeAttribute("disabled","");
        numeroSesion.removeAttribute("disabled","");
        aprobacionOriginal.removeAttribute("disabled","");
        aprobacionPublica.removeAttribute("disabled","");   
    }
    else{
        fraccion.setAttribute("disabled","");
        fechaSesion.setAttribute("disabled","");
        numeroSesion.setAttribute("disabled","");
        aprobacionOriginal.setAttribute("disabled","");
        aprobacionPublica.setAttribute("disabled","");
    }   
});



function store(){
    if(!formValidate('#frm_invitacion_1')){ return false; };
    let expediente_id = document.getElementById("expediente_id").value;
    let formData = new FormData($("#frm_invitacion_1").get(0));
    formData.append('expediente_id', expediente_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('invitacion.store'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                let encabezadoContratacion = document.querySelector("#seccion_contratacion");
                encabezadoContratacion.innerHTML = 'completa';
                let contratacion = document.querySelector("#contratacion");
                contratacion.classList.remove('boton-1','text-rojo-titulo');
                contratacion.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                contratacion.setAttribute('aria-expanded',false);
                let collapseOne = document.querySelector('#collapseOne');
                collapseOne.classList.remove('show');
                let store = document.querySelector("#store_invitacion");
                store.setAttribute("disabled","");
                let junta = document.querySelector("#junta");
                junta.classList.remove('collapsed');
                junta.setAttribute('aria-expanded',true);
                let collapseTwo = document.querySelector("#collapseTwo");
                collapseTwo.classList.add("show");
                let upadate1 = document.querySelector("#update_invitacion_2");
                upadate1.removeAttribute("disabled","");
                let id = document.querySelector("#id_invitacion");
                id.value = respuesta.id;
                proveedores(respuesta.proveedores.proveedores,'junta');
            } else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(xhr) {
         Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}


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
    let contador = `contador(this,'${ seccion }')`;
    let check = "";
    let espacio = document.querySelector('#espacio_'+seccion);
    if(proveedores.length > 3 || Object.keys(proveedores).length > 3){
        espacio.classList.remove('espacio_proveedores_corto');
        espacio.classList.add('espacio_proveedores_largo');
    }
    divProveedor.innerHTML = "";
    $.each(proveedores,function(index, value){
        if(seccion == 'propuesta' || seccion =="aprobados")
        {
            contador = `contador2(this,'${ seccion}', '${ value['rfc'] }')`;
        }
        check = "";
        if(value['seleccionado'] == 1)
        {
            check = "checked";
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
                                        <input type="checkbox" name="estatus[${ index }]" value="1" onclick="${ contador }" ${ check }>
                                        <span class="slider round"></span>
                                      </label>
                                </div>
                            </div>
                        </div>
                    </div>`;
        divProveedor.innerHTML += contenido;
    });
}

function contador2(element,seccion, rfc){
    let contadorProveedores = document.querySelector('#contador_proveedores_'+seccion);
    let contador = parseInt(contadorProveedores.innerHTML);
    if(element.checked){
        contador++; 
        proveedorClone(seccion,rfc);  
    }
    else{
        contador--;
        proveedorRemove(seccion,rfc);
    }    
    
    let numeroProveedores = document.querySelector("#numero_proveedores_"+seccion);
    contadorProveedores.innerHTML = numeroProveedores.value = contador;

}

function proveedorClone(seccion,rfc){
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



function update(numUpdate){
    let id = document.getElementById("id_invitacion").value;
    if(!formValidate('#frm_invitacion_'+numUpdate)){ return false; };
    let formData = new FormData($("#frm_invitacion_"+numUpdate).get(0));
    formData.append('id_invitacion',id);
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('invitacion.update',{invitacion: id}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                let junta = document.querySelector("#junta");
                let propuesta = document.querySelector("#propuesta");
                let fallo = document.querySelector("#fallo");
                let collapseTwo = document.querySelector("#collapseTwo");
                let collapseThree = document.querySelector("#collapseThree");
                let collapseFour = document.querySelector("#collapseFour");
                let botonUpdate3 = document.querySelector("#update_invitacion_3");
                let botonUpdate4 = document.querySelector("#update_invitacion_4");
                switch(numUpdate) {
                    case 1:
                        let encabezadoContratacion = document.querySelector("#seccion_contratacion");
                        encabezadoContratacion.innerHTML = 'completa';
                        let contratacion = document.querySelector("#contratacion");
                        contratacion.classList.remove('boton-1','text-rojo-titulo');
                        contratacion.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        contratacion.setAttribute('aria-expanded',false);
                        let collapseOne = document.querySelector('#collapseOne');
                        collapseOne.classList.remove('show');
                        junta.classList.remove('collapsed');
                        junta.setAttribute('aria-expanded',true);
                        collapseTwo.classList.add("show");
                        proveedores(respuesta.proveedores.proveedores,'junta');
                    break;
                    case 2:
                        let encabezadoJunta = document.querySelector("#seccion_junta");
                        encabezadoJunta.innerHTML = 'completa';
                        junta.classList.remove('boton-1','text-rojo-titulo');
                        junta.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        junta.setAttribute('aria-expanded',false);
                        collapseTwo.classList.remove('show');
                        let botonUpdate2 = document.querySelector("#update_invitacion_2");
                        botonUpdate2.setAttribute("disabled","");
                        propuesta.classList.remove('collapsed');
                        propuesta.setAttribute('aria-expanded',true);
                        collapseThree.classList.add("show");
                        botonUpdate3.removeAttribute("disabled","");
                        proveedores(respuesta.proveedores.proveedores,'propuesta'); 
                    break;
                    case 3:
                        let encabezadoPropuesta = document.querySelector("#seccion_propuesta");
                        encabezadoPropuesta.innerHTML = 'completa';
                        propuesta.classList.remove('boton-1','text-rojo-titulo');
                        propuesta.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        propuesta.setAttribute('aria-expanded',false);
                        collapseThree.classList.remove('show');
                        botonUpdate3.setAttribute("disabled","");
                        fallo.classList.remove('collapsed');
                        fallo.setAttribute('aria-expanded',true);
                        collapseFour.classList.add("show");
                        botonUpdate4.removeAttribute("disabled","");  
                        proveedores(respuesta.proveedores.proveedores,'aprobados'); 
                    break;
                    case 4:
                        let encabezadoFallo = document.querySelector("#seccion_fallo");
                        encabezadoFallo.innerHTML = 'completa';
                        fallo.classList.remove('boton-1','text-rojo-titulo');
                        fallo.classList.add('boton-2','text-dorado-titulo', 'collapsed');
                        fallo.setAttribute('aria-expanded',false);
                        collapseFour.classList.remove('show');
                        botonUpdate4.setAttribute("disabled","");
                        let anexos = document.querySelector("#anexos");
                        anexos.classList.remove('collapsed');
                        anexos.setAttribute('aria-expanded',true);
                        let collapseFive = document.querySelector("#collapseFive");
                        collapseFive.classList.add("show");                        
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




const modal = document.querySelector("#anexos_modal");

modal.addEventListener('click', (e)=>{
    if(!$('#id_invitacion').val()){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_invitacion.create'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#add_anexo")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            
        }
    });
});

function anexosSave(){
    if(!formValidate('#frm_anexo')){ return false; };
    let formData = new FormData($("#frm_anexo").get(0));
    let id_invitacion = $('#id_invitacion').val();
    formData.append('id_invitacion',id_invitacion);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_invitacion.store'),
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
                   anexosLoad(id_invitacion);
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
        url : route('anexos_invitacion.edit',{anexos_invitacion: id}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#edit_anexo")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            
        }
    });
}

function anexosUpdate(){
    if(!formValidate('#frm_edit')){ return false; };
    let formData = new FormData($("#frm_edit").get(0));
    let id_anexo = $('#id_anexo').val();
    let id_invitacion = $('#id_invitacion').val();
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_invitacion.update',{anexos_invitacion: id_anexo}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#edit_anexo').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", respuesta.message,"success");
                   anexosLoad(id_invitacion);
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

    let fraccion = document.querySelector("#fraccion"),
        fechaSesion = document.querySelector("#fecha_sesion"),
        numeroSesion = document.querySelector("#numero_sesion"),
        numeroCotizacion = document.querySelector("#numero_cotizacion"),
        aprobacionOriginal = document.querySelector("#aprobacion_original"),
        aprobacionPublica = document.querySelector("#aprobacion_publica");
    if(articulo.value == "Articulo 54"){
        fraccion.removeAttribute("disabled","");
        fechaSesion.removeAttribute("disabled","");
        numeroSesion.removeAttribute("disabled","");
        aprobacionOriginal.removeAttribute("disabled","");
        aprobacionPublica.removeAttribute("disabled","");   
    }

});

$('#anexos').click(function(){
    let id_invitacion = $('#id_invitacion').val();
    if(id_invitacion){
        sleep(300).then(()=> {anexosLoad(id_invitacion);});
    }
})

function anexosLoad(id){
     if($.fn.dataTable.isDataTable( '#tabla_anexos' )){
        dataTable.destroy();
    }
    
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
            "url": route('anexos_invitacion.data',{id: id}),
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
                    return `<a class="btn btn-cdmx" target="_blank" href="${url}storage/invitacion-restringida-${row.carpeta}/${row.archivo_original}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" target="_blank" href="${url}storage/invitacion-restringida-${row.carpeta}/${row.archivo_publica}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
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