$(document).ready(function(){
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    dataTable = $('#tabla_adhesion').DataTable({
        processing: true,
        serverSide: false,
         dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
        "<'row justify-content-md-center'<'col-sm-12't>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",       
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
         ajax: {
            "url": route('habilitar_proveedores.data'),
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
            { data: 'rfc', className: "text-center" },
            { data: 'num_procedimiento' },
            { data: 'fecha_adhesion', className: "text-center" },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let contentContrato = "";
                    if(row.archivo_adhesion){
                        contentContrato = `<a class="btn btn-cdmx" target="_blank" href="${url}storage/contrato-adhesion/${row.archivo_adhesion}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>`;
                    }

                    return  contentContrato;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let contentPerfil = ""
                    if(row.perfil_completo){
                        contentPerfil += `<i class="gris fa-solid fa-check fa-lg"></i>`;
                    }
                    else{
                        contentPerfil += `<i class="gris fa-solid fa-xmark fa-lg"></i>`;
                    }
                    return contentPerfil;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    let contentHabilitado = ""
                    if(row.habilitado){
                        contentHabilitado = `<i class="gris fa-solid fa-check fa-lg"></i>`;
                    }
                    else{
                        contentHabilitado = `<i class="gris fa-solid fa-xmark fa-lg"></i>`;
                    }
                    return contentHabilitado;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" href="${route('cat_proveedor.show',{cat_proveedor: row.proveedor_id})}"><i class="fa fa-eye fa-lg dorado"></i></a>`;
                }
            },
            {
                "orderable":      false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return `<a class="btn btn-cdmx" onClick="edit_modal('${row.id_e}');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>`;
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

function edit_modal(data){
     $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('habilitar_proveedores.edit',{habilitar_proveedore: data}),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#edit_adhesion")});
                let today = new Date();
                let date = today.getDate()+'/'+(today.getMonth()+1)+'/'+today.getFullYear();
                $("#fecha_adhesion").datepicker({
                    format: "dd/mm/yyyy",
                    language: "es",
                    daysOfWeekDisabled: [0,6],
                    endDate: date,
                });                
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(respuesta) {
            Swal.fire('¡Alerta!','Error de conectividad de red USR-03','warning');
        }
    });
}

function update_adhesion(){
    let id = document.getElementById("id_adhesion").value;
    if(!formValidate('#frm_adhesion')){ return false; };
    let formData = new FormData($("#frm_adhesion").get(0));
    formData.append('_method', 'PUT');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('habilitar_proveedores.update',{habilitar_proveedore: id}),
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(respuesta) {
            if (respuesta.success == true) {
                $('#edit_adhesion').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_adhesion').DataTable().ajax.reload();
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