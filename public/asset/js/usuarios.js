$(document).ready(function () {
    let dataTable = $('#tabla_usuarios').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('usuarios.data'),
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
            { data: 'rfc', className: "text-center" },
            { data: 'urg' },
            { data: 'rol' },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {

                    return '<a class="btn btn-cdmx" href="' + route('usuarios.show', { usuario: row.id_e }) + '"><i class="fa fa-eye fa-lg dorado"></i></a>';
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    return '<a class="btn btn-cdmx" onClick="edit_usuario_modal(\'' + row.id_e + '\');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>';
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

function edit_usuario_modal(data) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('usuarios.edit', { usuario: data }),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function () {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({ dropdownParent: $("#edit_usuario") });
            }).on('hidden.bs.modal', function () {
                $(this).remove();
            });
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', 'Error de conectividad de red USR-03', 'warning');
        }
    });
}

function usuario_update() {
    let id = document.getElementById("id_usuario").value;
    if (!formValidate('#frm_usuario')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('usuarios.update', { usuario: id }),
        type: 'PUT',
        data: $("#frm_usuario").serialize(),
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.success == true) {
                $('#edit_usuario').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_usuarios').DataTable().ajax.reload();
                });
            } else {
                Swal.fire('error', respuesta.message, "error");
            }
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', 'Error de conectividad de red USR-04', 'warning');
        }
    });
}