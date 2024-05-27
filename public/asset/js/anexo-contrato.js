document.addEventListener("DOMContentLoaded", () => {
    let idContratoMarco = document.getElementById('id_contrato_marco').value;
    $('[data-toggle="popover"]').popover();

    (function () {
        var getMeTo = document.getElementById("punto-encuentro");
        getMeTo?.scrollIntoView({ behavior: 'smooth' }, false);
    })();

    cargarTabla();

    function cargarTabla() {
        if ($.fn.dataTable.isDataTable('#tabla_anexos_contrato')) dataTable.destroy();

        dataTable = $("#tabla_anexos_contrato").DataTable({
            processing: true,
            serverSide: false,
            dom:
                "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                url: url + "asset/datatables/Spanish.json",
            },
            ajax: {
                url: route("anexos_contrato.fetch_anexoscm"),
                type: "GET",
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0,
                },
            ],
            columns: [
                { data: "id", defaultContent: "", orderable: false },
                { data: "nombre_documento" },
                {
                    data: "archivo_original",
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).html("<a  class='btn btn-cdmx' target='_blank' href='" + route("anexos_contrato.descargar_archivo", oData.archivo_original) + "'><i class='fa-solid fa-lg fa-file-pdf'></i></a>");
                    },
                    orderable: false,
                },
                {
                    data: "archivo_publico",
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).html("<a  class='btn btn-cdmx' target='_blank' href='" + route("anexos_contrato.descargar_archivo", oData.archivo_publico) + "'><i class='fa-solid fa-lg fa-file-pdf'></i></a>");
                    },
                    orderable: false,
                },
                {
                    data: "id_e",
                    fnCreatedCell: function (nTd, sData, oData, iRow, iCol) {
                        $(nTd).html("<a class='btn btn-cdmx btn-editar-anexo-contrato' href='javascript:void(0)'><i class='fa fa-edit fa-lg dorado'></i></a>");
                    },
                    orderable: false,
                },
            ],
        });

        dataTable.on("order.dt search.dt", function () {
            let i = 1;
            dataTable.cells(null, 0, { search: "applied", order: "applied" }).every(function (cell) {
                this.data(i++);
            });
        }).draw();

        dataTable.on("click", ".btn-editar-anexo-contrato", function () {
            let row = $('#tabla_anexos_contrato').DataTable().row($(this).closest('tr'));
            editarAnexoContratoModal(row.data().id_e);
        });
    }

    let modalAbierto = [false, false];
    document.querySelector("#modalAnexos").addEventListener("click", (e) => {
        if (idContratoMarco == '') {
            Swal.fire("¡Alerta!", "Para poder adjuntar documentos es necesario que primero dé de alta el contrato.", "warning");
            return false;
        }

        if (modalAbierto[0]) return false;
        modalAbierto[0] = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("anexos_contrato.create"),
            dataType: "html",
            success: function (resp_success) {
                $(resp_success)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#add_anexos") });
                    })
                    .on("hidden.bs.modal", function () {
                        $(this).remove();
                        modalAbierto[0] = false;
                    });
                    $(resp_success).modal('show');
            },
            error: function (respuesta) { console.log(respuesta); },
        });
    });

    function editarAnexoContratoModal(id) {
        if (modalAbierto[1]) return false;
        modalAbierto[1] = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("anexos_contrato.edit", id),
            dataType: "html",
            success: function (resp_success) {
                $(resp_success)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#edit_anexos"), });
                    })
                    .on("hidden.bs.modal", function () {
                        $(this).remove();
                        modalAbierto[1] = false;
                    });
                    $(resp_success).modal('show');
            },
            error: function (respuesta) {
                Swal.fire("¡Alerta!", "Error de conectividad de red USR-03", "warning");
            },
        });
    }

    //---------------------------------
    //       Validando archivos
    $(document).on("change", "#arc_original", function (e) {
        e.preventDefault();
        validarTamanioArchivo(this);
    });

    $(document).on("change", "#arc_publico", function (e) {
        e.preventDefault();
        validarTamanioArchivo(this);
    });

    const validarTamanioArchivo = (input) => {
        if (input.files.length <= 0) return;
        if (input.files[0].type == "application/pdf") {
            if (input.files[0].size > 31457280) {
                input.value = "";
                Swal.fire("Documento demasiado grande", `El tamaño máximo aceptable es de: 30 MB`, "error");
            }
        } else Swal.fire("Archivo no válido", `El archivo no es un PDF`, "error");
    }
    //       Validando archivos
    //---------------------------------

    let banderaTabla = true;
    $(document).on("click", "#btn-guardar-anexo", function (e) {//Manejando la barra de progreso
        e.preventDefault();
        if (!formValidate("#form_subir")) return false;

        inicializarBarra();
        let boton_cancelar = document.getElementById("mis-botones").children[0];
        boton_cancelar.disabled = false;

        let fd = new FormData();
        fd.append("nombre_documento", document.getElementById("nom_doc").value);
        fd.append("archivo_original", $("#arc_original")[0].files[0]);
        fd.append("archivo_publico", $("#arc_publico")[0].files[0]);

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        progress = $.ajax({
            url: route("anexos_contrato.store"),
            type: 'POST',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function (event) {
                    barraProgreso(event, "Guardando... espere por favor.");
                };
                return xhr;
            },
            beforeSend: function (xhr) {
                barraAntes();
            },
            success: function (respuesta) {
                if (respuesta.status == 400) {
                    let mensaje = "<ul>";
                    $.each(respuesta.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    barraError();
                    Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    barraExito();
                    $("#add_anexos")
                        .modal("hide")
                        .on("hidden.bs.modal", function () {
                            banderaTabla ? cargarTabla() : dataTable.ajax.reload();
                            banderaTabla = false;
                            Swal.fire("Proceso  correcto!", respuesta.message, "success");                            
                        });
                }
            },
            error: function () {
                barraError();
            }
        });

        boton_cancelar.addEventListener("click", () => {//cancelar    
            progress.abort();
            barraCancelar();
            boton_cancelar.disabled = true;
        });
    });

    $(document).on("click", "#btn-actualizar-anexo", function (e) {//Función de actualización de anexos cm
        e.preventDefault();
        if (!formValidate("#frm_acm_edit")) return false;

        inicializarBarra();

        let fd = new FormData();
        fd.append("nombre_documento", document.getElementById("nom_doc").value);
        fd.append("archivo_original", $("#arc_original")[0].files[0]);
        fd.append("archivo_publico", $("#arc_publico")[0].files[0]);
        fd.append("_method", "PUT");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: route("anexos_contrato.update", 1),
            type: 'POST',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function (event) {
                    barraProgreso(event, "Actualizando... espere por favor.");
                };
                return xhr;
            },
            beforeSend: function (xhr) {
                barraAntes();
            },
            success: function (respuesta) {
                if (respuesta.status == 400) {
                    let mensaje = "<ul>";
                    $.each(respuesta.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    barraError();
                    Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    barraExito();

                    $("#edit_anexos")
                        .modal("hide")
                        .on("hidden.bs.modal", function () {
                            banderaTabla ? cargarTabla() : dataTable.ajax.reload();
                            banderaTabla = false;
                            Swal.fire("Proceso  correcto!", respuesta.message, "success");
                        });
                }
            },
            error: function (jqXHR, textStatus) {
                barraError();
            }
        });
    });

    let barra_estado = span = cargando = boton_guardar = null;

    const inicializarBarra = () => {
        barra_estado = document.getElementById("barra-estado");
        span = barra_estado.children[0];
        cargando = document.getElementById("cargando");
        boton_guardar = document.getElementById("mis-botones").children[0];
    }

    const barraProgreso = (event, texto) => {
        let porcentaje = Math.round((event.loaded / event.total) * 100);
        barra_estado.style.width = porcentaje + "%";
        span.textContent = porcentaje + "%";
        cargando.style.textAlign = "center";
        cargando.style.fontWeight = "bold";
        cargando.textContent = texto;
        boton_guardar.disabled = true;
    }

    const barraAntes = () => barra_estado.classList.remove("barra_verde", "barra_roja");

    const barraError = () => {
        barra_estado.classList.add("barra_roja");
        span.innerHTML = "Error en subida de archivos";
    }

    const barraExito = () => {
        barra_estado.classList.add("barra_verde");
        span.innerHTML = "Archivos subidos correctamente.";
        cargando.textContent = "";
    }

    const barraCancelar = () => {
        barra_estado.classList.remove("barra_verde");
        barra_estado.classList.add("barra_roja");
        span.innerHTML = "Proceso cancelado";
        cargando.textContent = "";
        boton_guardar.disabled = false;
    }
});