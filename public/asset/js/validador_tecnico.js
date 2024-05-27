$(document).ready(function(){

    dataTable = $('#tabla_producto').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
         ajax: {
            "url": route('validador_tecnico.data'),
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
            { data: 'nombre_cm' },
            { data: 'nombre' },
            { data: 'nombre_producto' },
            { data: 'siglas' },
            { data: 'tipo_prueba' },
            {
                "className": "text-center",
                "orderable":      false,
                "mRender": function (data, type, row) {
                    return `<a target="_blank" href="${url}storage/validacion-tec-pfp/${row.validacion_tecnica_prueba}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
                }
            },
            {
                "className": "text-center",
                "orderable":      false,
                "mRender": function (data, type, row) {
                    let validacion = `<i class="fa-solid fa-clipboard-check gris"></i>`;
                    if(row.validacion_tecnica == null || row.validacion_tecnica == false){
                        validacion = `<a onClick="validar_modal('${row.id_e}','${row.nombre_producto}');"><i class="fa-solid fa-clipboard-check dorado"></i></a>`;
                    }
                    return validacion;
                }
            },
            {   
                "className": "text-center",
                "orderable": false,
                "mRender": function(data, type, row){
                    let habilitado = "";
                    if(row.validacion_tecnica == null)
                    {
                        habilitado = "";
                    }
                    else if(row.validacion_tecnica == true){
                        habilitado = `<i class="gris fa-solid fa-check fa-lg tab-cent"></i>`;
                    }
                    else{
                        habilitado = `<i class="gris fa-solid fa-xmark fa-lg tab-cent"></i>`;
                    }
                    return habilitado;
                }

            },            
            {
                "className": "text-center",
                "orderable":      false,
                "mRender": function (data, type, row) {
                    return `<a class="btn-cdmx" href="${ route('validador_tecnico.show_producto',{producto_id: row.id_e} ) }"><i class="fa-solid fa-eye fa-lg dorado"></i></a>`;
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


function validar_modal(id,nombreProducto){
    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('validador_tecnico.create'),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#modal_add_admin") });
                let today = new Date();
                let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                $("#fecha_revision").datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    startDate: date,
                    endDate: date
                }); 
                let productoId = document.querySelector('#producto_id');
                let nombre = document.querySelector('#nombre_producto');
                nombre.innerHTML = nombreProducto;
                productoId.value = id;
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function add_tecnica(){
    let id = document.querySelector('#producto_id');
    if(!formValidate('#frm_tecnica')){ return false; };
    let formData = new FormData($("#frm_tecnica").get(0));
    formData.append('producto_id',id.value);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('validador_tecnico.store'),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#modal_tecnico').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_producto').DataTable().ajax.reload();     
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