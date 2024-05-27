$(document).ready(function () {
    let dataTable = $('#tabla_proveedor').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('cat_proveedor.data'),
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
            { data: 'nombre' },
            { data: 'rfc', className: "text-center" },
            { data: 'estatus', className: "text-center" },
            {
                "orderable": false,
                "className": "text-center",
                "mRender": function (data, type, row) {

                    return '<a class="btn btn-cdmx" href="' + route('cat_proveedor.show', { cat_proveedor: row.id_e }) + '"><i class="fa fa-eye fa-lg dorado"></i></a>';
                }
            },
            {
                "orderable": false,
                "className": "text-center",
                "mRender": function (data, type, row) {
                    return '<a class="btn btn-cdmx" onClick="edit_proveedor_modal(\'' + row.id_e + '\');" href="javascript:void(0)"><i class="fa fa-edit fa-lg dorado"></i></a>';
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

const create = document.querySelector("#proveedor_modal");
if (create != null) {
    create.addEventListener('click', (e) => {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route('cat_proveedor.create'),
            dataType: 'html',
            success: function (resp_success) {
                var modal = resp_success;
                $(modal).modal('show');
            },
            error: function (respuesta) {
                Swal.fire('¡Alerta!', xhr, 'warning');
            }
        });
    });
}

function save_proveedor_create() {
    if (!formValidate('#frm_proveedor')) { return false; };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('cat_proveedor.store'),
        type: 'POST',
        data: $("#frm_proveedor").serialize(),
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.success == true) {
                $('#add_proveedor').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_proveedor').DataTable().ajax.reload();
                });
            } else {
                Swal.fire('error', respuesta.message, "error");
            }
        },
        error: function (xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function edit_proveedor_modal(data) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('cat_proveedor.edit', { cat_proveedor: data }),
        dataType: 'html',
        success: function (resp_success) {
            var modal = resp_success;
            $(modal).modal('show');
        },
        error: function (respuesta) {
            Swal.fire('¡Alerta!', 'Error de conectividad de red USR-03', 'warning');
        }
    });
}

function proveedor_update() {
    let id = document.getElementById("id").value;
    if (!formValidate('#frm_proveedor')) { return false; }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route('cat_proveedor.update', { cat_proveedor: id }),
        type: 'PUT',
        data: $("#frm_proveedor").serialize(),
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.success == true) {
                $('#edit_proveedor').modal('hide').on('hidden.bs.modal', function () {
                    Swal.fire("Proceso  correcto!", respuesta.message, "success");
                    $('#tabla_proveedor').DataTable().ajax.reload();
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

function proveedor(element) {
    if (element.value.length == 12 || element.value.length == 13) {
        let rfc = element.value;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route('cat_proveedor.buscar', { rfc: rfc }),
            type: 'GET',
            success: function (respuesta) {
                if(respuesta.success){
                    let msg = document.querySelector('#msg');
                    if(respuesta.data.length != 0){
                        msg.classList.add("alert", "alert-danger");
                        msg.innerHTML = '-ESTE RFC DE PROVEEDOR YA HA SIDO REGISTRADA, INGRESA UN RFC DIFERENTE PARA CONTINUAR CON EL REGISTRO.';
                    }
                    else{
                        msg.classList.remove("alert", "alert-danger");
                        msg.innerHTML = ' ';
                    }
                }
                
            },
            error: function (respuesta) {
                Swal.fire('¡Alerta!', 'Error de conectividad de red USR-04', 'warning');
            }
        });

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: route('service.proveedores', { rfc: rfc }),
            type: 'GET',
            success: function (respuesta) {
                if (respuesta.success == true) {
                    let data = JSON.parse(respuesta.data);
                    let data2 = JSON.parse(respuesta.data2);
                    let data3 = JSON.parse(respuesta.data3);
                    $('#folio_padron').val(data.data.folio_tramite);
                    $('#constancia').val(data.data.activo);
                    if(data.data.id_tipo_persona == 'F'){
                        $('#nombre').val(data.data.primer_ap_representante + " " + data.data.segundo_ap_representante + " " + data.data.nombre_representante);
                    }
                    else{
                        $('#nombre').val(data.data.razon_social);   
                    }
                    $('#persona').val(data.data.id_tipo_persona == 'M' ? 'Moral' : 'Física');
                    $('#nacionalidad').val(data.data.pais);
                    $('#mipyme').val(data.data.es_mipyme == true ? 'Si' : 'No');
                    $('#tipo_pyme').val(data.data.tipo_mipymes);
                    $('#nombre_completo').val(data.data.primer_ap_representante + " " + data.data.segundo_ap_representante + " " + data.data.nombre_representante);
                    $('#direccion').val(data.data.tipo_vialidad + " " + data.data.vialidad + " " + data.data.num_ext + " " + data.data.num_int + " " + data.data.cp + " " + data.data.tipo_asentamiento + " " + data.data.asentamiento + " " + data.data.municipio + " " + data.data.entidad);
                    $('#telefono_legal').val(data.data.telefono_fijo);
                    $('#extension_legal').val(data.data.extension);
                    $('#celular_legal').val(data.data.telefono_movil);
                    $('#correo_legal').val(data.data.email_alterno);
                    $('#nombre_legal').val(data.data.nombre_representante);
                    $('#primer_apellido_legal').val(data.data.primer_ap_representante);
                    $('#segundo_apellido_legal').val(data.data.segundo_ap_representante);
                    $('#rfc_legal').val(data.data.rfc_representante);
                    $('#codigo_postal').val(data.data.cp);
                    $('#colonia').val(data.data.asentamiento);
                    $('#alcaldia').val(data.data.municipio);
                    $('#entidad_federativa').val(data.data.entidad);
                    $('#pais').val(data.data.pais);
                    $('#tipo_vialidad').val(data.data.tipo_vialidad);
                    $('#vialidad').val(data.data.vialidad);
                    $('#numero_exterior').val(data.data.num_ext);
                    $('#numero_interior').val(data.data.num_int);
                    if(data2.url){
                        $('#imagen').val(data2[0].url);
                    }
                    $('#acta_identidad').val(data3.acta_identidad);
                    $('#fecha_constitucion_identidad').val(data3.fecha_constitucion_identidad);
                    $('#titular_identidad').val(data3.titular_identidad);
                    $('#num_notaria_identidad').val(data3.num_notaria_identidad);
                    $('#entidad_identidad').val(data3.entidad_identidad);
                    $('#num_reg_identidad').val(data3.num_reg_identidad);
                    $('#fecha_reg_identidad').val(data3.fecha_reg_identidad);
                    $('#num_instrumento_representante').val(data3.num_instrumento_representante);
                    $('#titular_representante').val(data3.titular_representante);
                    $('#num_notaria_representante').val(data3.num_notaria_representante);
                    $('#entidad_representante').val(data3.entidad_representante);
                    $('#num_reg_representante').val(data3.num_reg_representante);
                    $('#fecha_reg_representante').val(data3.fecha_reg_representante);
                } else {
                    Swal.fire('error', respuesta.message, "error");
                    $('#folio_padron').val("");
                    $('#constancia').val("");
                    $('#nombre').val("");
                    $('#persona').val("");
                    $('#nacionalidad').val("");
                    $('#mipyme').val("");
                    $('#tipo_pyme').val("");
                    $('#nombre_completo').val("");
                    $('#direccion').val("");
                    $('#telefono_legal').val("");
                    $('#extension_legal').val("");
                    $('#celular_legal').val("");
                    $('#correo_legal').val("");
                    $('#nombre_legal').val("");
                    $('#primer_apellido_legal').val("");
                    $('#segundo_apellido_legal').val("");
                    $('#rfc_legal').val("");
                    $('#codigo_postal').val("");
                    $('#colonia').val("");
                    $('#alcaldia').val("");
                    $('#entidad_federativa').val("");
                    $('#pais').val("");
                    $('#tipo_vialidad').val("");
                    $('#vialidad').val("");
                    $('#numero_exterior').val("");
                    $('#numero_interior').val("");
                    $('#imagen').val("");
                    $('#acta_identidad').val("");
                    $('#fecha_constitucion_identidad').val("");
                    $('#titular_identidad').val("");
                    $('#num_notaria_identidad').val("");
                    $('#entidad_identidad').val("");
                    $('#num_reg_identidad').val("");
                    $('#fecha_reg_identidad').val("");
                    $('#num_instrumento_representante').val("");
                    $('#titular_representante').val("");
                    $('#num_notaria_representante').val("");
                    $('#entidad_representante').val("");
                    $('#num_reg_representante').val("");
                    $('#fecha_reg_representante').val("");
                }
            },
            error: function (respuesta) {
                Swal.fire('¡Alerta!', 'Error de conectividad de red USR-04', 'warning');
            }
        });
    }
}
