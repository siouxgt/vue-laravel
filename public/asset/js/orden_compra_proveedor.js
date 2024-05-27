document.addEventListener("DOMContentLoaded", () => {

    $(document).ready(function () {
        let dataTable = $("#tbl_productos_orden_compra").DataTable({
            processing: true,
            serverSide: false,
            dom: "<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row justify-content-md-center'<'col-sm-12't>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                url: url + "asset/datatables/Spanish.json",
            },
            ajax: {
                url: route("orden_compra_proveedores.fetch_productos_poc"),
                type: "GET",
            },
            columnDefs: [
                {
                    searchable: false,
                    orderable: false,
                    targets: 0,
                    className: "text-center"
                },
            ],
            order: [[1, "asc"]],
            columns: [
                { data: "id_e", className: "text-center", defaultContent: "" },
                { data: "cabms", className: "text-center" },
                { "mRender": function (data, type, row) { return row.nombre.toUpperCase(); } },
                { "className": "text-center", "mRender": function (data, type, row) { return row.cantidad + '(s)'; } },
                { "className": "text-center", "mRender": function (data, type, row) { return new Intl.NumberFormat("es-MX", { style: "currency", currency: "MXN" }).format(row.total); } },
                { "className": "text-center", "mRender": function (data, type, row) { return `<span class="etapa-${row.css} px-3">${row.estatus}</span>`; } },
            ],
        });

        dataTable
            .on("order.dt search.dt", function () {
                let i = 1;
                dataTable.cells(null, 0, { search: "applied", order: "applied" }).every(function (cell) { this.data(i++); });
            })
            .draw();
    });

    $(document).on("click", `#btn_comentario_sobre_urg`, function (e) {
        e.preventDefault();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("orden_compra_proveedores.modal", 0),
            dataType: "html",
            success: function (resp_success) {
                $(resp_success)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#comentario_sobre_urg"), });
                    })
                    .on("hidden.bs.modal", function () { $(this).remove(); });
            },
            error: function (respuesta) { console.log(respuesta); },
        });
    });

    $(document).on("click", `#btn_mensaje_para_comprador`, function (e) {
        e.preventDefault();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("orden_compra_proveedores.modal", 1),
            dataType: "html",
            success: function (resp_success) {
                $(resp_success)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $("#mensaje_para_comprador"), });
                        agregarEscuchaCantidadCaracteres('mensaje', 'cantidad_caracteres_mensaje');
                    })
                    .on("hidden.bs.modal", function () { $(this).remove(); });
            },
            error: function (respuesta) { console.log(respuesta); },
        });
    });

    $(document).on("click", `#btn_enviar_mensaje_comprador`, function (e) {
        e.preventDefault();
        if (!formValidate("#frm_mensaje_comprador")) return false;

        let formData = new FormData($("#frm_mensaje_comprador").get(0));
        let btnEnviar = $('#btn_enviar_mensaje_comprador').attr('disabled', true);
        btnEnviar.text("Enviando...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_proveedores.guardar_mensaje"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnEnviar.text("Enviar");
                    btnEnviar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#mensaje_para_comprador").modal("hide").on("hidden.bs.modal",
                        function () {
                            Swal.fire("Proceso  correcto!", response.message, "success");
                        });
                }
            },
        });

        return false
    });

    //Zona de confirmacion

    let formDataRechazarOrden = null;

    $(document).on("click", `#btn_seleccionar_productos_entregar`, function (e) {
        e.preventDefault();
        abrirModal(5, "#seleccionar_productos_entrega");
    });

    $(document).on("click", `#btn_ver_productos_rechazados`, function (e) {
        e.preventDefault();
        abrirModal(6, "#seleccionar_productos_entrega");
    });

    $(document).on("click", `#btn_modal_datos_legales_proveedor`, function (e) {
        e.preventDefault();
        abrirModal(2, "#datos_legales_proveedor");
    });

    $(document).on("click", "#btn_cerrar_datos_legales_proveedor", function (e) {
        e.preventDefault();
        $("#datos_legales_proveedor").modal("hide").on("hidden.bs.modal");
    });

    $(document).on("click", `#btn_modal_rechazar_orden`, function (e) {
        e.preventDefault();
        abrirModal(3, "#rechazar_orden_compra");
    });

    $(document).on("click", "#btn_aceptar_rechazar_orden", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_rechazo_orden")) return false;

        let warningsRechazoOrden = '';

        if (comprobarFrmRechazoOrden() === '') {
            formDataRechazarOrden = new FormData($("#frm_rechazo_orden").get(0));
            abrirModal(4, "#rechazar_orden_compra_confirmar", 1);
        } else {
            Swal.fire("No se puede continuar", warningsRechazoOrden, "error");
        }

        function comprobarFrmRechazoOrden() {
            const motivoRechazoOrden = document.getElementById("motivo_rechazo_orden");
            const descripcionRechazoOrden = document.getElementById("txt_a_descripcion_rechazo_orden"); //TextArea
            warningsRechazoOrden = '';

            if (motivoRechazoOrden.value === '') warningsRechazoOrden += `<p>Selecciona el <b>motivo de tu rechazo</b> por favor.</p>`;
            if (descripcionRechazoOrden.value.trim() === "") warningsRechazoOrden += `<p>Describe la <b>situación de tu rechazo</b> por favor.</p>`;

            return warningsRechazoOrden;
        }
    });

    $(document).on("click", "#btn_no_rechazar_orden", function (e) {
        e.preventDefault();
        formDataRechazarOrden = null;
    });

    $(document).on("click", "#btn_si_rechazar_orden", function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_proveedores.rechazar_orden"),
            data: formDataRechazarOrden,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#rechazar_orden_compra")
                        .modal("hide")
                        .on("hidden.bs.modal", function () {
                            Swal.fire("Proceso  correcto!", "Rechazo exitoso", "success");
                        });

                    window.location = route("orden_compra_proveedores.seguimiento", response.retornar);
                }
            },
        });
    });

    let modalAbierto = [false, false];
    function abrirModal(idModal, tituloModal, posicion = 0) {
        if (modalAbierto[posicion]) return false;

        modalAbierto[posicion] = true;

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: route("orden_compra_proveedores.modal", idModal),
            dataType: "html",
            success: function (resp_success) {
                $(resp_success)
                    .modal()
                    .on("shown.bs.modal", function () {
                        $("[class='make-switch']").bootstrapSwitch("animate", true);
                        $(".select2").select2({ dropdownParent: $(tituloModal), });

                        if (idModal == 3) agregarEscuchaCantidadCaracteres('txt_a_descripcion_rechazo_orden', 'alerta_cantidad_caracteres_rechazo_orden');
                        if (idModal == 7) agregarEscuchaCantidadCaracteres('txt_comentarios_confirmacion_envio', 'cantidad_caracteres_confirmacion_envio');
                        if (idModal == 13) agregarEscuchaCantidadCaracteres('descripcion', 'cantidad_caracteres_descripcion_reporte_pago');
                        if (idModal == 14) agregarEscuchaCantidadCaracteres('descripcion', 'cantidad_caracteres_descripcion_incidencia_pago');
                        if (idModal == 15) agregarEscuchaCantidadCaracteres('comentario', 'cantidad_caracteres_comentario');
                        if (idModal == 5 || idModal == 6) cargarSeleccionarProductosEntrega();
                        if (idModal == 9) {
                            agregarEscuchaDiasSolicitados();
                            agregarEscuchaCantidadCaracteres('descripcion_situacion_solicitud', 'numero_caracteres_motivo_solicitud');
                        }

                    }).on("hidden.bs.modal", function () {
                        $(this).remove();
                        modalAbierto[posicion] = false;
                    });
            },
            error: function (respuesta) { console.log(respuesta); },
        });
    }

    function cargarSeleccionarProductosEntrega() {
        const chkProdSeleccionarTodos = $("#chk_producto_seleccionar_todos");
        const chkProducto = $("input[name='chk_producto[]']");

        mostrarCantidadProductosSeleccionados();

        chkProdSeleccionarTodos.click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
            mostrarCantidadProductosSeleccionados();
        });

        chkProducto.on('change', function (e) {
            chkProdSeleccionarTodos.prop("checked", comprobarChecksTodosSeleccionados());
            mostrarCantidadProductosSeleccionados();
        });

        function mostrarCantidadProductosSeleccionados() {
            $("#cantidad_productos_seleccionados").text('2. ' + obtenerCantidadProductosSeleccionados());
            // comprobarChecksTodosSeleccionados() ? limpiarRazonesProductosRechazados() : '';
        }

        function obtenerCantidadProductosSeleccionados() {
            return `Seleccionaste ${cantidadChecksSeleccionados()} de ${chkProducto.length} producto(s) para entregar.`;
        }

        function limpiarRazonesProductosRechazados() {
            document.getElementById("motivo_rechazo_producto").options.item(0).selected = 'selected';
            document.getElementById("txt_a_descripcion_rechazo_producto").value = '';
        }

        function comprobarChecksTodosSeleccionados() { //Comprobar si todos los checks estan seleccionados
            return chkProducto.length === cantidadChecksSeleccionados();
        }

        function cantidadChecksSeleccionados() {
            return chkProducto.filter(":checked").length;
        }

        $(document).ready(function () {
            $("#btn_generar_acuse").click(function () {
                let formulario = document.getElementById('frm_productos_entrega');
                let leyenda = comprobarFrmSeleccionarProductosEntrega();

                if (leyenda === "") {
                    let textoFull = `<p class="">${obtenerCantidadProductosSeleccionados()}<br>Una vez confirmado no se podrá deshacer la acción.</p>
                                    <br>
                                    <p class="text-10">¿Confirmas tu selección?</p>`;
                    Swal.fire({ title: "Confirmar acción", icon: 'warning', iconColor: '#9E2241', html: textoFull, showCancelButton: true, confirmButtonColor: "#9E2241", cancelButtonColor: "#dadada", confirmButtonText: "Si", cancelButtonText: "No", })
                        .then((result) => {
                            if (result.isConfirmed) {
                                $("#seleccionar_productos_entrega").modal("hide").on("hidden.bs.modal");
                                formulario.submit();
                            }
                        });
                } else {
                    let mensaje = "<ul>";
                    mensaje += leyenda;
                    mensaje += "</ul>";

                    Swal.fire({ title: 'No se puede continuar', icon: 'error', html: mensaje, confirmButtonColor: "#3085d6", confirmButtonText: "OK", width: leyenda.length > 100 ? '600px' : '500px' });
                }

            });
        });

        function comprobarFrmSeleccionarProductosEntrega() {
            const fechaEntregaPr = document.getElementById("fecha_entrega");
            const motivoRechazoPr = document.getElementById("motivo_rechazo_producto"); //Select
            const descripcionRechazoPr = document.getElementById("txt_a_descripcion_rechazo_producto"); //TextArea
            let warningsRechazoProd = '';

            if (fechaEntregaPr.value.trim() === "") return warningsRechazoProd += `<li>Es necesario que declares la <b>fecha de entrega</b>.</li>`;

            if (cantidadChecksSeleccionados() > 0) {
                if (!comprobarChecksTodosSeleccionados()) {
                    if (motivoRechazoPr.value === '0' || descripcionRechazoPr.value.trim() === "") {
                        warningsRechazoProd += `<p>Parece que <b>rechazaras productos</b> (existen productos que no has seleccionado para su entrega).</p><br>`;
                        warningsRechazoProd += `<p><b>Proporciona</b> los siguientes datos por favor:</p><br>`;
                    }
                    if (motivoRechazoPr.value === '0') warningsRechazoProd += `<li>Declara el <b>motivo de tu rechazo</b>.</li>`;
                    if (descripcionRechazoPr.value.trim() === "") warningsRechazoProd += `<li>Describe cual es la <b>situación de tu rechazo</b>.</li>`;
                }
            } else {
                warningsRechazoProd += `<p><b>Ha seleccionado 0 productos</b>:</p><br>`;
                return warningsRechazoProd += `<li>Es necesario que seleccione por lo menos <b>un producto</b>.</li>`
            }

            return warningsRechazoProd;
        }

        agregarEscuchaCantidadCaracteres('txt_a_descripcion_rechazo_producto', 'alerta_cantidad_caracteres');
    }

    agregarEscuchaCantidadCaracteres('descripcion_situacion_solicitud', 'numero_caracteres_motivo_solicitud');

    function agregarEscuchaCantidadCaracteres(nombreTxtArea, nombreTxtCantidad) {//Funcion que permite agregar un escucha a text area para el conteo de la cantidad de caracteres insertados
        $(`#${nombreTxtArea}`).on('input', function (e) {
            document.querySelector(`#${nombreTxtCantidad}`).innerHTML = `${e.target.value.length}/1000`;
        });
    }

    //Zona de envio
    $(document).on("click", `#btn_confirmar_envio`, function (e) {
        e.preventDefault();
        abrirModal(7, "#modal_confirmacion_envio");
    });

    $(document).on("click", "#btn_confirmacion_envio", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_confirmacion_envio")) return false;

        let btnConfirmacionEnvio = $('#btn_confirmacion_envio').attr('disabled', true).text("Guardando..."),
            formData = new FormData($("#frm_confirmacion_envio").get(0));
        formData.append("_method", "PUT");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_envio.update", 1),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnConfirmacionEnvio.text("Guardar");
                    btnConfirmacionEnvio.attr('disabled', false);
                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#modal_confirmacion_envio")
                        .modal("hide")
                        .on("hidden.bs.modal", function () {

                            Swal.fire({ title: "Proceso correcto!", text: response.message, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK", })
                                .then((result) => {
                                    if (result.isConfirmed) location.reload();
                                });
                        });
                }
            },
        });
    });

    //Zona de confirmacion de entrega del envio
    $(document).on("click", `#btn_confirmar_entrega`, function (e) {
        e.preventDefault();
        abrirModal(8, "#modal_confirmacion_entrega");
    });

    $(document).on("click", "#btn_guardar_confirmacion_entrega", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_confirmacion_entrega")) return false;

        let btnConfirmacionEnvio = $('#btn_guardar_confirmacion_entrega').attr('disabled', true).text("Guardando..."),
            formData = new FormData($("#frm_confirmacion_entrega").get(0));
        formData.append("_method", "PUT");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_envio.update", 2),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnConfirmacionEnvio.text("Guardar");
                    btnConfirmacionEnvio.attr('disabled', false);
                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#modal_confirmacion_entrega")
                        .modal("hide")
                        .on("hidden.bs.modal", function () {

                            Swal.fire({ title: "Proceso correcto!", text: response.message, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK", })
                                .then((result) => {
                                    if (result.isConfirmed) location.reload();
                                });
                        });
                }
            },
        });
    });

    $(document).on("click", `#btn_solicitar_prorroga`, function (e) {
        e.preventDefault();
        abrirModal(9, "#modal_solicitud_prorroga");
    });

    function agregarEscuchaDiasSolicitados() {

        $('#dias_solicitados').on('wheel', function (e) {
            setTimeout(function () {//Si el campo esta vacio, entonces esperar un par de segundos (Tal vez la URG escribira un valor diferente)
                operacionFechas();
            }, 200);
        });

        $("#dias_solicitados").on('keyup', function () {
            operacionFechas();
        });

        $("#dias_solicitados").on('click', function () {
            operacionFechas();
        });

        let diasSolicitadosGuardado = 1;

        function operacionFechas() {
            let fechaSolicitud = new Date($('#fecha_solicitud').val());
            let diasSolicitados = $('#dias_solicitados').val();

            if (diasSolicitados == "" || diasSolicitados == 0) {
                setTimeout(function () {//Si el campo esta vacio, entonces esperar un par de segundos (Tal vez la URG escribira un valor diferente)
                    realizarOperacion();
                }, 2000);
            } else {
                realizarOperacion();
            }

            function realizarOperacion() {
                if (!isNaN(diasSolicitados)) {
                    diasSolicitados = parseInt(diasSolicitados);
                    if (diasSolicitados >= 1 && diasSolicitados <= 20) {
                        diasSolicitadosGuardado = diasSolicitados;
                    } else {
                        diasSolicitadosGuardado = diasSolicitadosGuardado;
                    }
                } else {
                    diasSolicitadosGuardado = diasSolicitadosGuardado;
                }
                $('#dias_solicitados').val(diasSolicitadosGuardado);
                establecerFechaCompromiso();
            }

            function establecerFechaCompromiso() {
                let fechaCompromisoEntrega = document.getElementById("fecha_compromiso_entrega");
                fechaCompromisoEntrega.value = sumarDias(fechaSolicitud, diasSolicitadosGuardado).toISOString().substring(0, 10);
            }

            function sumarDias(fecha, dias) {
                fecha.setDate(fecha.getDate() + dias);
                return fecha;
            }
        }
    }

    $(document).on("click", "#btn_generar_solicitud_prorroga", function (e) {
        e.preventDefault();

        if (!formValidate("#frm_solicitud_prorroga")) return false;

        Swal.fire({
            title: "<div style='color:#9E2241'>¿Quieres generar la solicitud?</div>",
            html: `<p class='text-justify'>Al generar la solicitud, deberás completar el proceso con tu firma electrónica. Si no lo concluyes, no se podrá generar de nuevo.</p>`,
            icon: "warning",
            iconColor: '#9E2241',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: "#9E2241",
            cancelButtonColor: "#818181ff",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) generarSolicitudProrroga();
        });

        function generarSolicitudProrroga() {
            let formData = new FormData($("#frm_solicitud_prorroga").get(0));
            let btnConfirmacionEnvio = $('#btn_generar_solicitud_prorroga').attr('disabled', true);
            btnConfirmacionEnvio.text("Guardando...");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "POST",
                url: route("orden_compra_prorroga.store"),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 400) {
                        btnConfirmacionEnvio.text("Guardar");
                        btnConfirmacionEnvio.attr('disabled', false);
                        let mensaje = "<ul>";
                        $.each(response.errors, function (key, err_value) {
                            mensaje += "<li>- " + err_value + "</li>";
                        });
                        mensaje += "</ul>";

                        Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                    } else {
                        $("#modal_solicitud_prorroga")
                            .modal("hide")
                            .on("hidden.bs.modal", function () {
                                window.location = route("orden_compra_proveedores.abrir_pagina", [response.seguimiento, response.seccion]);
                            });
                    }
                },
            });
        }
    });

    $(document).on("click", "#btn_firmar_prorroga", function (e) {
        e.preventDefault();

        const mensajeAlerta = comprobarFrmFirmasCer();

        if (mensajeAlerta.trim() === "") {
            Swal.fire({
                title: "<div style='color:#9E2241'>¿Confirmas la firma de la solicitud?</div>",
                html: `<p>Al firmar la solicitud será enviada al comprador y será sujeta a revisión y aprobación.</p>
                        <br>
                        <p>Al confirmar la acción no se podrá deshacer.</p>`,
                icon: "warning",
                iconColor: '#9E2241',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: "#9E2241",
                cancelButtonColor: "#818181ff",
                confirmButtonText: "Si",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) firmarProrroga();
            });
        } else {
            Swal.fire({
                title: "<div style='color:#9E2241'>No se puede continuar</div>",
                html: mensajeAlerta,
                icon: "error",
                iconColor: '#9E2241',
                allowOutsideClick: false,
                confirmButtonText: "OK",
            });
        }

        function comprobarFrmFirmasCer() {
            const inputCer = document.getElementsByName("archivo_cer");
            const inputKey = document.getElementsByName("archivo_key");
            const inputContra = document.getElementById("contrasenia");
            let mensajeAlerta = '';

            if (inputCer[0].textLength === 0 || inputKey[0].textLength === 0) {
                mensajeAlerta += `<li>- Es necesario que selecciones los archivos <b>.cer</b> y <b>.key</b>.</li>`
            }
            if (inputContra.value.trim() === "") {
                mensajeAlerta += `<li>- Proporciona tu <b>contraseña</b> por favor.</li>`
            }
            return mensajeAlerta;
        }

        function firmarProrroga() {
            let formData = new FormData($("#frm_firma_cer_key").get(0));
            let btnFirmarProrroga = $('#btn_firmar_prorroga').attr('disabled', true);
            btnFirmarProrroga.text("Firmando...");

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "POST",
                url: route("orden_compra_prorroga.firmar_prorroga"),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status == 400) {
                        btnFirmarProrroga.text("Firmar Prórroga");
                        btnFirmarProrroga.attr('disabled', false);
                        let mensaje = "<ul>";
                        $.each(response.errors, function (key, err_value) {
                            mensaje += "<li>- " + err_value + "</li>";
                        });
                        mensaje += "</ul>";

                        Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                    } else {
                        Swal.fire({
                            title: "<div style='color:#9E2241'>Proceso correcto</div>", html: `${response.mensaje}`, icon: "success", allowOutsideClick: false, confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = route("orden_compra_proveedores.abrir_pagina", [response.seguimiento, response.seccion]);
                            }
                        });
                    }
                },
            });
        }
    });


    $(document).on("click", "#btn_si_firma_prorroga", function (e) {//Botón ubicado en modal para filtros por cabms
        e.preventDefault();
        $(`#modal_confirmar_firma_prorroga`).modal('hide');
        window.location = route('orden_compra_proveedores.abrir_pagina', 'envio_index');
    });

    // Zona de sustitucion : confirmacion del envio de sustitucion
    let fechaHoy = document.getElementById('fecha_hoy')?.value;

    $(document).on("click", `#btn_confirmar_envio_sust`, function (e) {
        e.preventDefault();
        Swal.fire({
            title: "<div style='color:#9E2241'>¿Seguro?</div>",
            html: `<p>Fecha de envío: <strong> ${fechaHoy} </strong></p><p>¿Confirma el envío del producto a sustituir?</p>
            `,
            icon: "warning",
            iconColor: '#9E2241',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: "#9E2241",
            cancelButtonColor: "#818181ff",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                confirmarEnvioSustitucion();
            }
        });

        function confirmarEnvioSustitucion() {
            let btnConfirmar = $('#btn_confirmar_envio_sust').attr('disabled', true);
            btnConfirmar.text("Confirmando...");
            let formData = new FormData();
            formData.append("estatus", true);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "POST",
                url: route("orden_compra_sustitucion.confirmar_envio_sustitucion"),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    btnConfirmar.text("Confirmar envío");
                    if (response.status == 400) {
                        btnConfirmar.attr('disabled', false);
                        let mensaje = "<ul>";
                        $.each(response.errors, function (key, err_value) {
                            mensaje += "<li>- " + err_value + "</li>";
                        });
                        mensaje += "</ul>";

                        Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                    } else {
                        Swal.fire({
                            title: "Proceso correcto", html: `${response.mensaje}`, icon: "success", allowOutsideClick: false, confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    }
                },
            });
        }

    });

    //Zona de sustitucion : Entrega
    $(document).on("click", `#btn_confirmar_entrega_sustitucion`, function (e) {
        e.preventDefault();
        abrirModal(10, "#modal_confirmacion_entrega_sustitucion");
    });

    $(document).on("click", "#btn_guardar_confirmacion_entrega_sustitucion", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_confirmacion_entrega_sustitucion")) return false;

        let formData = new FormData($("#frm_confirmacion_entrega_sustitucion").get(0));
        formData.append("_method", "PUT");

        let btnConfirmacionEnvio = $('#btn_guardar_confirmacion_entrega_sustitucion').attr('disabled', true);
        btnConfirmacionEnvio.text("Confirmando...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_sustitucion.update", 2),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnConfirmacionEnvio.text("Guardar");
                    btnConfirmacionEnvio.attr('disabled', false);
                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });
                    mensaje += "</ul>";

                    Swal.fire({
                        title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK",
                    });
                } else {
                    $("#modal_confirmacion_entrega_sustitucion")
                        .modal("hide")
                        .on("hidden.bs.modal", function () {

                            Swal.fire({
                                title: "Proceso correcto!", text: response.mensaje, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        });
                }
            },
        });
    });

    // Zona de facturacion : revisar datos de facturacion
    $(document).on("click", `#btn_datos_facturacion`, function (e) {
        e.preventDefault();
        abrirModal(11, "#modal_facturacion_datos");
    });

    $(document).on("click", `#btn_adjuntar_prefactura`, function (e) {
        e.preventDefault();
        abrirModal(12, "#modal_adjuntar_prefactura");
    });

    $(document).on("click", "#btn_enviar_prefactura", function (e) {
        e.preventDefault();
        if (!formValidate("#frm_adjuntar_prefactura")) return false;

        let formData = new FormData($("#frm_adjuntar_prefactura").get(0));
        let btnEnviar = $('#btn_enviar_prefactura').attr('disabled', true);
        btnEnviar.text("Enviando...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_factura.store"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnEnviar.text("Enviar");
                    btnEnviar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) { mensaje += "<li>" + err_value + "</li>"; });
                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#modal_adjuntar_prefactura").modal("hide").on("hidden.bs.modal", function () {
                        Swal.fire({ title: "Proceso correcto!", text: response.mensaje, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK", })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                    });
                }
            },
        });
    });

    //Zona de pagos
    //Validar CLC
    $(document).on("click", `#btn_validar_pago`, function (e) {
        e.preventDefault();
        Swal.fire({
            title: "<div style='color:#9E2241'>¿Seguro?</div>",
            html: `<p>¿Confirma que el pago fue realizado correctamente?</p>`,
            icon: "warning",
            iconColor: '#9E2241',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: "#9E2241",
            cancelButtonColor: "#818181ff",
            confirmButtonText: "Si",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                confirmarPago();
            }
        });

        function confirmarPago() {
            let btnValidar = $('#btn_validar_pago').attr('disabled', true);
            btnValidar.text("Confirmando...");
            let formData = new FormData();
            formData.append("estatus", true);

            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "POST",
                url: route("orden_compra_pago.confirmar_pago"),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    btnValidar.text("Validar pago");
                    if (response.status == 400) {
                        btnValidar.attr('disabled', false);
                        let mensaje = "<ul>";
                        $.each(response.errors, function (key, err_value) { mensaje += "<li>- " + err_value + "</li>"; });
                        mensaje += "</ul>";

                        Swal.fire({ title: "No se puede continuar", html: mensaje, icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                    } else {
                        Swal.fire({ title: "Proceso correcto", html: `${response.mensaje}`, icon: "success", allowOutsideClick: false, confirmButtonText: "OK", })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                    }
                },
            });
        }

    });
    //Reportes
    $(document).on("click", `#btn_reporte_retraso`, function (e) {
        e.preventDefault();
        abrirModal(13, "#modal_reporte_pago");
    });

    $(document).on("click", "#btn_enviar_reporte_pago", function (e) {
        e.preventDefault();

        let formData = new FormData($("#frm_reporte_pago").get(0));
        let btnEnviar = $('#btn_enviar_reporte_pago').attr('disabled', true);
        btnEnviar.text("Enviando...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_pago.reporte_guardar"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnEnviar.text("Enviar reporte");
                    btnEnviar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });

                    Swal.fire({ title: "No se puede continuar", html: mensaje += "</ul>", icon: "error", confirmButtonColor: "#3085d6", confirmButtonText: "OK", });
                } else {
                    $("#modal_reporte_pago").modal("hide").on("hidden.bs.modal", function () {
                        Swal.fire({
                            title: "Proceso correcto!", text: response.mensaje, icon: "success", confirmButtonColor: "#3085d6", confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    });
                }
            },
        });
    });

    //Incidencias
    $(document).on("click", `#btn_incidencia_pago`, function (e) {
        e.preventDefault();
        abrirModal(14, "#modal_incidencia_pago");
    });

    $(document).on("click", "#btn_enviar_incidencia_pago", function (e) {
        e.preventDefault();
        let formData = new FormData($("#frm_incidencia_pago").get(0));
        let btnEnviar = $('#btn_enviar_incidencia_pago').attr('disabled', true);
        btnEnviar.text("Abriendo...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("orden_compra_pago.incidencia_guardar"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnEnviar.text("Abrir incidencia");
                    btnEnviar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });

                    Swal.fire({
                        title: "No se puede continuar",
                        html: mensaje += "</ul>",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK",
                    });
                } else {
                    $("#modal_incidencia_pago").modal("hide").on("hidden.bs.modal", function () {
                        Swal.fire({
                            title: "Proceso correcto!",
                            text: response.mensaje,
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    });
                }
            },
        });
    });

    $(document).on("click", `#btn_firmar_contrato`, function (e) {
        e.preventDefault();
        if (!formValidate("#frm_firma")) return false;
        firmar();
    });

    function firmar() {
        let key = document.querySelector('#archivo_key'),
            cer = document.querySelector('#archivo_cer'),
            banca = document.querySelector('#archivo_banca'),
            pass = document.querySelector('#contrasena'),
            btnFirmar = $('#btn_firmar_contrato').attr('disabled', true).text("Firmando...");

        if (key.value != "" && cer.value != "" && banca.value != "" && pass.value != "") {
            Swal.fire({
                html: `Al firmar el contrato se comunicará a los involucrados. <br><br> 
                Al confirmar la acción no se podrá deshacer.<br><br>
                <span class="red">¿Confirmas la firma del contrato?</span>`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#9E2241",
                cancelButtonColor: "#818181ff",
                confirmButtonText: "Si",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData($("#frm_firma").get(0));

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: route('orden_compra_proveedores.efirma_save'),
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (respuesta) {
                            if (respuesta.status == 200) {
                                window.location.href = url + 'orden_compra_proveedores/seguimiento/' + respuesta.retorno;
                            } else {
                                btnFirmar.text("Firmar contrato");
                                btnFirmar.attr('disabled', false);

                                let mensaje = "<ul>";
                                $.each(respuesta.errors, function (key, err_value) {
                                    mensaje += "<li>" + err_value + "</li>";
                                });
                                Swal.fire('No se puede continuar', mensaje, "error");
                            }
                        },
                        error: function (xhr) {
                            Swal.fire('¡Alerta!', xhr, 'warning');
                        }
                    });
                } else {
                    btnFirmar.text("Firmar contrato");
                    btnFirmar.attr('disabled', false);
                }
            });
        } else {
            btnFirmar.text("Firmar contrato");
            btnFirmar.attr('disabled', false);
            Swal.fire('¡Alerta!', 'Proporcione todos los datos solicitados por favor.', 'warning');
        }
    }

    //Zona de la encuesta
    $(document).on("click", `#btn_dejar_comentarios`, function (e) {
        e.preventDefault();
        abrirModal(15, "#modal_encuesta_comentarios");
    });

    $(document).on("click", "#btn_enviar_encuesta_comentario", function (e) {
        e.preventDefault();
        let formData = new FormData($("#frm_encuesta_comentarios").get(0));
        let btnEnviar = $('#btn_enviar_encuesta_comentario').attr('disabled', true);
        btnEnviar.text("Enviando...");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url: route("proveedor_comentario.store"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status == 400) {
                    btnEnviar.text("Enviar");
                    btnEnviar.attr('disabled', false);

                    let mensaje = "<ul>";
                    $.each(response.errors, function (key, err_value) {
                        mensaje += "<li>" + err_value + "</li>";
                    });

                    Swal.fire({
                        title: "No se puede continuar",
                        html: mensaje += "</ul>",
                        icon: "error",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK",
                    });
                } else {
                    $("#modal_encuesta_comentarios").modal("hide").on("hidden.bs.modal", function () {
                        Swal.fire({
                            title: "Proceso correcto!",
                            text: response.mensaje,
                            icon: "success",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "OK",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    });
                }
            },
        });
    });
});