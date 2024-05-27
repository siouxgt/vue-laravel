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
        fraccion.value = "";
        fechaSesion.setAttribute("disabled","");
        fechaSesion.value = "";
        numeroSesion.setAttribute("disabled","");
        numeroSesion.value = "";
        aprobacionOriginal.setAttribute("disabled","");
        aprobacionOriginal.value = "";
        aprobacionPublica.setAttribute("disabled","");
        aprobacionPublica.value = "";
    }   
});


function store(){
    if(!formValidate('#frm_adjudicacion_1')){ return false; };
    let expediente_id = document.getElementById("expediente_id").value;
    let formData = new FormData($("#frm_adjudicacion_1").get(0));
    formData.append('expediente_id', expediente_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('adjudicacion.store'),
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
                let store = document.querySelector("#store_adjudicacion");
                store.setAttribute("disabled","");
                let fallo = document.querySelector("#fallo");
                fallo.classList.remove('collapsed');
                fallo.setAttribute('aria-expanded',true);
                let collapseTwo = document.querySelector("#collapseTwo");
                collapseTwo.classList.add("show");
                let boton2 = document.querySelector("#update_adjudicacion2");
                boton2.removeAttribute("disabled","");
                let id = document.querySelector("#id_adjudicacion");
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
    let id = document.getElementById("id_adjudicacion").value;
    if(!formValidate('#frm_adjudicacion_'+numUpdate)){ return false; };
    let formData = new FormData($("#frm_adjudicacion_"+numUpdate).get(0));
    formData.append('id_adjudicacion',id);
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('adjudicacion.update',{adjudicacion: id}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                Swal.fire("Proceso  correcto!", respuesta.message,"success");
                let collapseTwo = document.querySelector("#collapseTwo");
                let fallo = document.querySelector("#fallo");
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
                        let update1 = document.querySelector("#update_adjudicacion1");
                        update1.setAttribute("disabled","");
                        fallo.classList.remove('collapsed');
                        fallo.setAttribute('aria-expanded',true);
                        collapseTwo.classList.add("show");
                        let boton2 = document.querySelector("#update_adjudicacion2");
                        boton2.removeAttribute("disabled","");
                    break;
                    case 2:
                        let encabezadoFallo = document.querySelector("#seccion_fallo");
                        encabezadoFallo.innerHTML = 'completa';
                        fallo.classList.remove('boton-1','text-rojo-titulo');
                        fallo.classList.add('boton-2','text-dorado-titulo','collapsed');
                        fallo.setAttribute('area-expande',false);
                        collapseTwo.classList.remove("show");
                        let collapseThree = document.querySelector('#collapseThree');
                        collapseThree.classList.add('show');
                        let  update2 = document.querySelector("#update_adjudicacion2");
                        update2.setAttribute("disabled","");
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

let proveedor = 0;

function contador(element){
    if(element.checked){
        proveedor++; 
    }
    else{
        proveedor--;
    }    
    
    let contadorProveedores = document.querySelector('#contador_proveedores');
    let numeroProveedores = document.querySelector("#numero_proveedores");
    contadorProveedores.innerHTML = numeroProveedores.value = proveedor;

}

const modal = document.querySelector("#anexos_modal");

modal.addEventListener('click', (e)=>{
    if(!$('#id_adjudicacion').val()){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_adjudicacion.create'),
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
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
});

function anexosSave(){
    if(!formValidate('#frm_anexo')){ return false; };
    let formData = new FormData($("#frm_anexo").get(0));
    let id_adjudicacion = $('#id_adjudicacion').val();
    formData.append('id_adjudicacion',id_adjudicacion);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_adjudicacion.store'),
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
                    anexosLoad(id_adjudicacion);
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
        url : route('anexos_adjudicacion.edit',{anexos_adjudicacion: id}),
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
    let id_adjudicacion = $('#id_adjudicacion').val();
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('anexos_adjudicacion.update',{anexos_adjudicacion: id_anexo}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#edit_anexo').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", respuesta.message,"success");
                   anexosLoad(id_adjudicacion);
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
    let id_adjudicacion = $('#id_adjudicacion').val();
    if(id_adjudicacion){
       sleep(300).then(()=> {anexosLoad(id_adjudicacion);}); 
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
            "url": route('anexos_adjudicacion.data',{id: id}),
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
                    
                    return `<a class="btn btn-cdmx" target="_blank" href="${url}storage/adjudicacion-directa-${row.carpeta}/${row.archivo_original}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    
                    return `<a class="btn btn-cdmx" target="_blank" href="${url}storage/adjudicacion-directa-${row.carpeta}/${row.archivo_publica}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" onClick="edit_anexo_modal('${row.id_e}');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>`;
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