$(document).ready(function() {

	let dataTable = $('#tabla_validacion').DataTable({
		processing: true,
        serverSide: false,
	     dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('validacion.data'),
            "type": "GET"
        },
        columnDefs: [
            {
                searchable: false,
                orderable: false,
                targets: 0,
                className: "text-center"
            }
	    ],
	    order: [[1, 'asc']],
        columns: [
        	{ data: 'id_t', defaultContent: '' },
            { data: 'entidad' },
            { data: 'direccion' },
            { data: 'estatus', className: "text-center" },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                	
                    return `<a class="btn btn-cdmx" href="${route('validacion.show',{validacion: row.id_e })}"><i class="fa fa-eye fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" onClick="edit_validacion_modal('${row.id_e }');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>`;
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

});

const create = document.querySelector("#validacion_modal");

create?.addEventListener('click',(e)=>{
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('validacion.create'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal('show');
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#add_validador")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
});

function cargaCg(element){
    if(element.value.length == 6){

        let ccg = element.value;
        let entidad = document.querySelector('#entidad')

        $.ajax({
            url: route("service.almacen", {ccg: ccg}),
            type: "GET",
            success: function (respuesta) {
                if (respuesta.success == true) {
                    entidad.value = respuesta.elurg;
                    personalAcceso(ccg);
                } else {
                    Swal.fire('error', respuesta.message,"error");
                    const divPersonal = document.querySelector("#personal");
                    divPersonal.style.height = "0px";    
                    divPersonal.innerHTML = ""; 
                    entidad.value = "";
                }
            },
        });
    }
}

function personalAcceso(ccg){
    const divPersonal = document.querySelector("#personal");
    let contenido = "";

    $.ajax({
        url: route("service.acceso_unico", {ccg: ccg}),
        type: "GET",
        success: function (respuesta){
            let data = JSON.parse(respuesta.data);
            
            if(data.data.length != 0){
                
                for (personal of data.data)
                {
                     contenido +=  `<div class="row">
                           <div class="col-12 col-sm-2">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-5">
                                <div class="form-group">
                                    <input type="text" id="nombre" name="nombre[]" class="form-control" readonly value="${personal.nombre} ${personal.primer_apellido} ${personal.segundo_apellido}">
                                    <input type="hidden" name="rfc[]" value="${personal.rfc}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-1">
                                <div class="form-group">
                                    <label for="formGroupExampleInput">Activo</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2 text-align-center">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <label class="switch">
                                            <input type="checkbox" name="estatus[${personal.rfc}]" value="1">
                                            <span class="slider round"></span>
                                          </label>
                                    </div>
                                </div>
                            </div>
                    </div> 
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-5">
                            <div class="form-group">
                                <input type="text" id="cargo" name="cargo[]" class="form-control" readonly value="${personal.cargo}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                <label for="permiso">Permiso</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <select name="permiso[]" class="form-control text-1">
                                    <option value="">Seleccione una opción..</option>
                                    <option value="tecnico">Técnico</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <hr> `;
                }
                divPersonal.style.height = "300px";    
                divPersonal.innerHTML = contenido; 
            } else {
                divPersonal.style.height = "50px";    
                divPersonal.innerHTML = `<div class="row">
                                       <div class="col-12 col-sm-12">
                                            <div class="form-group">
                                                <p class="text-center">Sin usuarios registrados en Acceso Unico</p>
                                            </div>
                                        </div>
                                        </div>`; 
            }
        }
    });
}

function save_validacion_create() {
    if(!formValidate('#frm_validador')){ return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('validacion.store'),
        type: 'POST',
        data: $("#frm_validador").serialize(),
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#add_validador').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", respuesta.message,"success");
                    $('#tabla_validacion').DataTable().ajax.reload();
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

function edit_validacion_modal(data) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('validacion.edit',{validacion: data}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal('show');
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#edit_validador")});
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-03','warning');
        }
    });
}

function validacion_update() {
    let id = document.getElementById("id").value;
    if(!formValidate('#frm_validador')){ return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('validacion.update', {validacion: id}),
        type: 'PUT',
        data: $("#frm_validador").serialize(),
        dataType: 'json',
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#edit_validador').modal('hide').on('hidden.bs.modal', function() {
                    Swal.fire("Proceso  correcto!", respuesta.message,"success");
                    $('#tabla_validacion').DataTable().ajax.reload();
                });
            }else {
                Swal.fire('error', respuesta.message,"error");
            }
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-04','warning');
        }
     });
}