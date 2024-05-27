$(document).ready(function () {
    $.fn.dataTable.moment( 'DD/MM/YYYY' );
    let dataTable = $('#tabla_contratos').DataTable({
        processing: true,
        serverSide: false,
        dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
            "<'row justify-content-md-center'<'col-sm-12't>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        language: {
            "url": url + "asset/datatables/Spanish.json"
        },
        ajax: {
            "url": route('firmante.data'),
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
            { data: 'orden_compra', className: "text-center" },
            { data: 's_fecha', className: 'text-center' },
            { data: 'nombre_proveedor' },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let proveedor = "";
                    if(row.proveedor){
                        proveedor = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return proveedor;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let titular = "";
                    if(row.titular){
                        titular = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return titular;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let adquisiciones = "";
                    if(row.adquisiciones){
                        adquisiciones = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return adquisiciones;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let financiera = "";
                    if(row.financiera){
                        financiera = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return financiera;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let requiriente = "";
                    if(row.requiriente){
                        requiriente = '<i class="green fa-solid fa-check fa-lg"></i>';
                    }
                    return requiriente;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    let firmar = `<button type="button" class="boton-verde px-2" onclick="firmar('${row.id_e}')">Firmar</button>`;
                    if(row.sello != null)
                    {
                        firmar = `<button type="button" class="boton-gris px-2">Firmar</button>`;
                    }
                    return firmar;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    return `<a href="${url}storage/contrato-pedido/contrato_pedido_${row.contrato_pedido}.pdf" class="mx-4" target="_blank"><i class="fa-solid fa-file-signature text-gold"></i></a>`;
                }
            },
            {
                "className": "text-center",
                "orderable": false,
                "mRender": function (data, type, row) {
                    return row.fecha * -1;
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

function firmar(id){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url : route('firmante.firmar_modal'),
        dataType: 'html',
        success: function(resp_success) {
            var modal = resp_success;
            $(modal).modal().on('shown.bs.modal', function() {
                $("[class='make-switch']").bootstrapSwitch('animate', true);
                $('.select2').select2({dropdownParent: $("#firmar")});
                let contrato = document.querySelector("#contrato");
                contrato.value = id;
                const fileCer = document.querySelector('#archivo_cer');
                const dropCer = document.querySelector('#drop_cer');
                const nombreCer = document.querySelector('#nombre_cer');

                dropCer.addEventListener('click', () => fileCer.click())

                dropCer.addEventListener('dragover', (e) => {
                    e.preventDefault()
                    dropCer.classList.remove('punteado');
                    dropCer.classList.add('punteado-active');
                })

                dropCer.addEventListener('dragleave', (e) => {
                    e.preventDefault()

                    dropCer.classList.remove('punteado-active');
                    dropCer.classList.add('punteado');
                })


                dropCer.addEventListener('drop', (e) => {
                    e.preventDefault()

                    fileCer.files = e.dataTransfer.files;
                    const file = fileCer.files[0];
                    if(file != undefined){
                        nombreArchivoCer(file);
                    }
                })

                fileCer.addEventListener('change', (e) => {
                    const file = e.target.files[0]
                    nombreArchivoCer(file);
                })

                const nombreArchivoCer = (file) => {
                    nombreCer.innerHTML =  file.name;
                }

                const filekey = document.querySelector('#archivo_key');
                const dropkey = document.querySelector('#drop_key');
                const nombrekey = document.querySelector('#nombre_key');

                dropkey.addEventListener('click', () => filekey.click())

                dropkey.addEventListener('dragover', (e) => {
                    e.preventDefault()
                    dropkey.classList.remove('punteado');
                    dropkey.classList.add('punteado-active');
                })

                dropkey.addEventListener('dragleave', (e) => {
                    e.preventDefault()

                    dropkey.classList.remove('punteado-active');
                    dropkey.classList.add('punteado');
                })


                dropkey.addEventListener('drop', (e) => {
                    e.preventDefault()

                    filekey.files = e.dataTransfer.files;
                    const file = filekey.files[0];
                    if(file != undefined){
                        nombreArchivokey(file);
                    }
                })

                filekey.addEventListener('change', (e) => {
                    const file = e.target.files[0]
                    nombreArchivokey(file);
                })

                const nombreArchivokey = (file) => {
                    nombrekey.innerHTML =  file.name;
                }
            }).on('hidden.bs.modal', function() {
                $(this).remove();
            });
        },
        error: function(xhr) {
            Swal.fire('¡Alerta!', xhr, 'warning');
        }
    });
}

function firmarSave(){
    let formulario = document.querySelector('#frm_firma');
    let key = document.querySelector('#archivo_key');
    let cer = document.querySelector('#archivo_cer');
    let pass = document.querySelector('#contrasena');

    if(key.value != "" && cer.value != "" && pass.value != ""){
        Swal.fire({
            html: `Estas por firmar el contrato. Al confirmar la acción no se podrá deshacer<br><br>
            <span class="red">¿Confirmas la firma del contrato?</span>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                if(!formValidate('#frm_firma')){ return false; };
                let formData = new FormData($("#frm_firma").get(0));
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url : route('firmante.store'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(respuesta) {
                        if (respuesta.success == true) {
                            $('#firmar').modal('hide').on('hidden.bs.modal', function () {
                                Swal.fire("Proceso  correcto!", respuesta.message, "success");
                                $('#tabla_contratos').DataTable().ajax.reload();
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
        });
    }
    else{
        Swal.fire('¡Alerta!','LLena todos los campos');
    }
}